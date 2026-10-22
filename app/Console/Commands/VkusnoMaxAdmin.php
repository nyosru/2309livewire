<?php

namespace App\Console\Commands;

use App\Models\Vkusno\PhoneAdministrator;
use App\Services\Max\PhoneNumber;
use App\Services\Max\RecipientRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VkusnoMaxAdmin extends Command
{
    protected $signature = 'vkusno:max-admin {phone} {max_id?} {--name=}';

    protected $description = 'Выдать доступ к панели кафе по телефону без VK';

    public function handle(RecipientRegistry $recipients): int
    {
        try {
            DB::transaction(function () use ($recipients) {
                $phone = PhoneNumber::normalize($this->argument('phone'));
                if ($this->argument('max_id')) {
                    $recipients->register($phone, $this->argument('max_id'));
                }
                PhoneAdministrator::firstOrCreate(['phone' => $phone], ['name' => mb_substr((string) $this->option('name'), 0, 100)]);
            });
        } catch (ValidationException $exception) {
            $this->error(collect($exception->errors())->flatten()->first());

            return self::FAILURE;
        }
        $this->info('Доступ через MAX выдан. Для входа запросите код на сайте.');

        return self::SUCCESS;
    }
}
