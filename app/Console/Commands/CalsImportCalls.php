<?php

namespace App\Console\Commands;

use App\Models\Cals\Call;
use App\Models\Cals\Contact;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CalsImportCalls extends Command
{
    protected $signature = 'cals:import-calls {directory : Папка с датированными папками звонков}';

    protected $description = 'Импортировать расшифровки и сводки звонков из папки';

    public function handle(): int
    {
        $root = rtrim($this->argument('directory'), DIRECTORY_SEPARATOR);
        if (! is_dir($root)) {
            $this->error('Папка не найдена.');

            return self::FAILURE;
        }

        $imported = 0;
        $skipped = 0;
        $callsIndexPath = $root.DIRECTORY_SEPARATOR.'calls-index.json';
        $callsIndex = is_file($callsIndexPath) ? json_decode(file_get_contents($callsIndexPath), true) : [];
        $callsIndex = is_array($callsIndex) ? $callsIndex : [];

        foreach (glob($root.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) ?: [] as $dayDirectory) {
            if (! preg_match('/\d{4}-\d{2}-\d{2}$/', basename($dayDirectory), $folderMatch)) {
                continue;
            }
            $folderMatch[0] = basename($dayDirectory);

            foreach (File::allFiles($dayDirectory) as $file) {
                if ($file->getExtension() !== 'txt') {
                    continue;
                }

                $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1));
                $mp3Path = preg_replace('/\.txt$/', '.mp3', $relativePath);
                $recordingData = $callsIndex[$mp3Path] ?? [];
                $metadataPath = $file->getPathname().'.summary.json';
                $metadata = is_file($metadataPath) ? json_decode(file_get_contents($metadataPath), true) : null;
                $metadata = is_array($metadata) ? $metadata : [];
                $phone = $this->phoneFrom($metadata, $file->getFilename());
                $normalizedPhone = $this->normalizePhone($phone);

                $metadataDate = $metadata['date'] ?? null;
                $date = is_string($metadataDate) && trim($metadataDate) !== '' ? trim($metadataDate) : $folderMatch[0];
                $metadataTime = $metadata['time'] ?? null;
                $time = is_string($metadataTime) && trim($metadataTime) !== ''
                    ? trim($metadataTime)
                    : ((is_string($recordingData['time'] ?? null) && trim($recordingData['time']) !== '')
                        ? trim($recordingData['time'])
                        : ($this->timeFromFilename($file->getFilename()) ?: '00:00:00'));
                try {
                    $calledAt = Carbon::parse($date.' '.$time);
                } catch (\Throwable) {
                    try {
                        $calledAt = Carbon::parse($folderMatch[0].' '.($this->timeFromFilename($file->getFilename()) ?: '00:00:00'));
                    } catch (\Throwable) {
                        $skipped++;
                        continue;
                    }
                }

                $contact = $normalizedPhone
                    ? Contact::firstOrCreate(
                        ['phone_normalized' => $normalizedPhone],
                        ['phone' => $phone, 'name' => null]
                    )
                    : null;

                $summary = $metadata['summary'] ?? $this->markdownSummary($file->getPathname());
                $metadata['keywords'] = $metadata['topics'] ?? $metadata['keywords'] ?? [];

                Call::updateOrCreate(
                    ['source_path' => $relativePath],
                    [
                        'contact_id' => $contact?->id,
                        'phone' => $phone,
                        'call_at' => $calledAt,
                        'duration_seconds' => isset($recordingData['duration_seconds']) ? (int) $recordingData['duration_seconds'] : null,
                        'transcript' => file_get_contents($file->getPathname()),
                        'summary' => is_string($summary) ? $summary : null,
                        'metadata' => $metadata ?: null,
                    ]
                );
                $imported++;
            }
        }

        $this->info("Импортировано или обновлено звонков: {$imported}. Пропущено файлов без даты: {$skipped}.");

        return self::SUCCESS;
    }

    private function phoneFrom(array $metadata, string $filename): ?string
    {
        $phone = preg_replace('/\D+/', '', (string) ($metadata['phone'] ?? ''));
        if (strlen($phone) === 10 || strlen($phone) === 11) {
            return $phone;
        }

        $filename = preg_replace('/\.txt$/i', '', $filename);
        $parts = preg_split('/\s+-\s+/u', $filename);
        $candidate = trim((string) end($parts));
        if (count($parts) === 1 && preg_match('/^\d{2}-\d{2}-(.+)$/', $filename, $match)) {
            $candidate = $match[1];
        }
        if (preg_match('/^(\+?\d{10,11})-\d+$/', $candidate, $match)) {
            $candidate = $match[1];
        }
        $phone = preg_replace('/\D+/', '', $candidate);

        return strlen($phone) === 10 || strlen($phone) === 11 ? $phone : null;
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (! $phone) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $phone);
        if (strlen($digits) === 10) {
            return '7'.$digits;
        }
        if (strlen($digits) === 11 && $digits[0] === '8') {
            return '7'.substr($digits, 1);
        }

        return strlen($digits) === 11 ? $digits : null;
    }

    private function timeFromFilename(string $filename): ?string
    {
        if (preg_match('/^(\d{2})-(\d{2})-/', $filename, $match) && (int) $match[1] < 24 && (int) $match[2] < 60) {
            return $match[1].':'.$match[2].':00';
        }

        return null;
    }

    private function markdownSummary(string $transcriptPath): ?string
    {
        $base = preg_replace('/\.txt$/', '', $transcriptPath);
        $summaryPath = $base.'-summary.md';
        if (! is_file($summaryPath)) {
            return null;
        }

        $summary = file_get_contents($summaryPath);
        if (preg_match('/Краткое содержание:\s*(.+?)(?:\n\n|\n##)/us', $summary, $match)) {
            return trim($match[1]);
        }

        return null;
    }
}
