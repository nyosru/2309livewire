<?php

namespace App\Console\Commands;

use App\Models\Cals\Call;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CalsUpdateCallTimes extends Command
{
    protected $signature = 'cals:update-call-times';

    protected $description = 'Обновить время звонков по имени файла';

    public function handle(): int
    {
        $updated = 0;

        Call::query()->select(['id', 'source_path', 'call_at'])->orderBy('id')->chunkById(200, function ($calls) use (&$updated): void {
            foreach ($calls as $call) {
                $filename = basename((string) $call->source_path);
                if (! preg_match('/\A([01]\d|2[0-3])-([0-5]\d)-.+\.txt\z/i', $filename, $match)) {
                    continue;
                }

                $existingAt = Carbon::parse($call->call_at);
                $callAt = $existingAt->copy()->setTime((int) $match[1], (int) $match[2], 0);
                if ($callAt->format('Y-m-d H:i:s') === $existingAt->format('Y-m-d H:i:s')) {
                    continue;
                }

                Call::query()->whereKey($call->id)->update(['call_at' => $callAt]);
                $updated++;
            }
        });

        $this->info("Обновлено звонков: {$updated}.");

        return self::SUCCESS;
    }
}
