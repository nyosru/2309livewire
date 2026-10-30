<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DzudoApplications extends Command
{
    protected $signature = 'dzudo:applications {--limit=20 : Число последних заявок} {--id= : Показать одну заявку} {--pending : Показать заявки без уведомления}';

    protected $description = 'Просмотр заявок центра дзюдо (только на сервере)';

    public function handle(): int
    {
        if ($id = $this->option('id')) {
            $application = DB::table('dzudo_applications')->where('id', $id)->first();
            if (! $application) {
                $this->error('Заявка не найдена.');

                return self::FAILURE;
            }

            $this->table(['Поле', 'Значение'], [
                ['ID', $application->id],
                ['Номер заявки', $application->reference],
                ['Телефон', decrypt($application->phone)],
                ['Источник', $application->source],
                ['Создана', $application->created_at],
                ['Уведомление отправлено', $application->notified_at ?: 'нет'],
            ]);

            return self::SUCCESS;
        }

        $query = DB::table('dzudo_applications')->orderByDesc('id');
        if ($this->option('pending')) {
            $query->whereNull('notified_at');
        }

        $rows = $query->limit(max(1, min(100, (int) $this->option('limit'))))
            ->get(['id', 'reference', 'source', 'notified_at', 'created_at']);

        $this->table(['ID', 'Номер заявки', 'Источник', 'Уведомление', 'Дата'], $rows->map(fn ($row) => [
            $row->id,
            $row->reference,
            $row->source,
            $row->notified_at ? 'отправлено' : 'ожидает',
            $row->created_at,
        ])->all());
        $this->info('Телефон доступен только при запросе одной заявки: php artisan dzudo:applications --id=<ID>');

        return self::SUCCESS;
    }
}
