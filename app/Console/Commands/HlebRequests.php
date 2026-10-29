<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HlebRequests extends Command
{
    protected $signature = 'hleb:requests {--limit=20 : Число последних заявок} {--id= : Подробности одной заявки}';

    protected $description = 'Просмотр заявок магазина и франшизы Хлебничной (только на сервере)';

    public function handle(): int
    {
        if ($id = $this->option('id')) {
            $request = DB::table('hleb_requests')->where('id', $id)->first();
            if (! $request) {
                $this->error('Заявка не найдена.');

                return self::FAILURE;
            }
            $contact = json_decode(decrypt($request->contact), true);
            $this->table(['Поле', 'Значение'], [
                ['Номер', $request->reference], ['Тип', $request->type], ['Создана', $request->created_at],
                ['Имя', $contact['name']], ['Телефон', $contact['phone']], ['Город', $contact['city']],
                ['Комментарий', $contact['comment'] ?? ''], ['Предварительная сумма', $request->total.' ₽'],
            ]);
            $this->table(['Товар', 'Цена', 'Количество'], array_map(fn ($item) => [$item['name'], $item['price'], $item['quantity']], json_decode($request->items, true)));

            return self::SUCCESS;
        }
        $rows = DB::table('hleb_requests')->orderByDesc('id')->limit(max(1, min(100, (int) $this->option('limit'))))->get(['id', 'type', 'total', 'created_at']);
        $this->table(['ID', 'Тип', 'Сумма', 'Дата'], $rows->map(fn ($row) => (array) $row)->all());
        $this->info('Контакты и состав: php artisan hleb:requests --id=<ID>');

        return self::SUCCESS;
    }
}
