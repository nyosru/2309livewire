<?php

namespace App\Console\Commands;

use App\Services\Max\MaxAuthException;
use App\Services\Max\MaxService;
use Illuminate\Console\Command;

class MaxRegisterWebhook extends Command
{
    protected $signature = 'max:register-webhook';

    protected $description = 'Подключить прямой webhook MAX из настроек сервера';

    public function handle(MaxService $max): int
    {
        try {
            $max->subscribe((string) config('max.webhook_url'));
        } catch (MaxAuthException $exception) {
            $this->error($exception->getMessage());

            return self::FAILURE;
        }
        $this->info('Webhook MAX подключён: bot_started, message_created.');

        return self::SUCCESS;
    }
}
