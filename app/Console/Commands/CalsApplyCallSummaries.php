<?php

namespace App\Console\Commands;

use App\Models\Cals\Call;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalsApplyCallSummaries extends Command
{
    protected $signature = 'cals:apply-call-summaries {file : JSON-файл со source_path и summary}';

    protected $description = 'Заменить шаблонные сводки звонков индивидуальными';

    private const TEMPLATE_SUMMARY = 'Обсуждались детали предстоящей встречи и согласовывалось время для обсуждения проекта.';

    public function handle(): int
    {
        $file = $this->argument('file');
        if (! is_file($file)) {
            $this->error('Файл со сводками не найден.');

            return self::FAILURE;
        }

        $items = json_decode(file_get_contents($file), true);
        if (! is_array($items)) {
            $this->error('Некорректный JSON со сводками.');

            return self::FAILURE;
        }

        $updated = 0;
        DB::transaction(function () use ($items, &$updated): void {
            foreach ($items as $item) {
                if (! is_array($item)) {
                    continue;
                }

                $path = $item['source_path'] ?? null;
                $summary = $item['summary'] ?? null;
                if (! is_string($path) || $path === '' || str_contains($path, '..')
                    || ! is_string($summary) || trim($summary) === '') {
                    continue;
                }

                $updated += Call::query()
                    ->where('source_path', $path)
                    ->where('summary', self::TEMPLATE_SUMMARY)
                    ->update(['summary' => trim($summary)]);
            }
        });

        $this->info("Заменено шаблонных сводок: {$updated}.");

        return self::SUCCESS;
    }
}
