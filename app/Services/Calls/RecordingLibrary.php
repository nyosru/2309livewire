<?php

namespace App\Services\Calls;

use Illuminate\Support\Carbon;

class RecordingLibrary
{
    public function key(string $source, string $path): string
    {
        return hash('sha256', $source.':'.$path);
    }

    public function resolve(string $source, string $path): ?string
    {
        $directory = config('calls.sources')[$source] ?? null;
        if (! is_string($directory) || str_contains($path, "\0")) {
            return null;
        }
        $root = realpath($directory);
        $real = $root === false ? false : realpath($root.DIRECTORY_SEPARATOR.$path);

        return $real !== false && str_starts_with($real, $root.DIRECTORY_SEPARATOR)
            && is_file($real) && is_readable($real) ? $real : null;
    }

    public function scan(): array
    {
        $items = [];
        $errors = [];
        foreach (config('calls.sources') as $source => $directory) {
            if (! is_dir($directory) || ! is_readable($directory)) {
                $errors[] = 'Папка '.($source === 'call' ? 'звонков' : 'диктофона').' недоступна: '.$directory;

                continue;
            }
            $folders = [''];
            // Only date folders: ignore service directories and unrelated files on the disk.
            foreach (scandir($directory) ?: [] as $entry) {
                if (preg_match('/\A\d{4}-\d{2}-\d{2}\z/', $entry) && is_dir($directory.'/'.$entry)) {
                    $folders[] = $entry;
                }
            }
            foreach ($folders as $folder) {
                foreach (scandir($directory.($folder ? '/'.$folder : '')) ?: [] as $name) {
                    if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) !== 'mp3') {
                        continue;
                    }
                    $relative = ($folder ? $folder.'/' : '').$name;
                    $real = $this->resolve($source, $relative);
                    if ($real === null) {
                        continue;
                    }
                    $basename = pathinfo($name, PATHINFO_FILENAME);
                    $stem = ($folder ? $folder.'/' : '').$basename;
                    $summary = null;
                    foreach ([$stem.'_summary.md', $stem.'-summary.md', rtrim($stem).'-summary.md'] as $candidate) {
                        if ($this->resolve($source, $candidate)) {
                            $summary = $candidate;
                            break;
                        }
                    }
                    $mtime = filemtime($real) ?: 0;
                    $date = $folder ?: null;
                    $time = null;
                    if (preg_match('/\A([01]\d|2[0-3])-([0-5]\d)-/', $basename, $filenameTime)) {
                        $time = $filenameTime[1].':'.$filenameTime[2].':00';
                    }
                    $metadataPath = $this->resolve($source, $stem.'.txt.summary.json');
                    if ($metadataPath) {
                        $metadata = json_decode(file_get_contents($metadataPath, false, null, 0, 20000), true);
                        if (is_array($metadata)) {
                            if (is_string($metadata['date'] ?? null) && preg_match('/\A\d{4}-\d{2}-\d{2}\z/', $metadata['date'])) {
                                $date = $metadata['date'];
                            }
                            if ($time === null && is_string($metadata['time'] ?? null) && preg_match('/\A\d{2}:\d{2}(:\d{2})?\z/', $metadata['time'])) {
                                $time = $metadata['time'];
                            }
                        }
                    }
                    try {
                        $recordedAt = $date ? Carbon::parse($date.' '.($time ?? '00:00:00'))->timestamp : $mtime;
                    } catch (\Throwable) {
                        $recordedAt = $mtime;
                    }
                    $key = $this->key($source, $relative);
                    $transcriptPath = $this->resolve($source, $stem.'.txt');
                    $transcriptPreview = null;
                    if ($transcriptPath) {
                        $transcriptStart = file_get_contents($transcriptPath, false, null, 0, 4096);
                        if (is_string($transcriptStart)) {
                            $transcriptPreview = mb_substr(trim($transcriptStart), 0, 150);
                        }
                    }
                    $items[$key] = [
                        'key' => $key, 'source' => $source, 'path' => $relative,
                        'name' => $name, 'basename' => $basename, 'size' => filesize($real),
                        'recorded_at' => $recordedAt, 'date_estimated' => $date === null,
                        'txt_path' => $transcriptPath ? $stem.'.txt' : null,
                        'transcript_preview' => $transcriptPreview,
                        'summary_path' => $summary,
                        'tag_key' => $source === 'recorder' && $folder === '' ? $basename : $key,
                    ];
                }
            }
        }
        uasort($items, fn ($a, $b) => ($b['recorded_at'] <=> $a['recorded_at']) ?: strcmp($a['path'], $b['path']));

        return ['items' => $items, 'errors' => $errors];
    }
}
