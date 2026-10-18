<?php

namespace App\Services\Ttt;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class TrainingRequestNotifier
{
    public function send(string $phone, string $source): void
    {
        $token = (string) config('services.vk.token_order');
        $userId = (string) config('services.vk.vk_admin_id');
        $version = (string) config('services.vk.api_version', '5.199');

        if ($token === '' || $userId === '') {
            throw new RuntimeException('Не настроены параметры отправки заявки во ВКонтакте.');
        }

        $message = "Заявка на обучение бильярду с ТТТ72\n"
            ."Телефон: {$phone}\n"
            ."Форма: {$source}";

        Log::info('ttt72 - training request', [
            'phone' => $phone,
            'source' => $source,
        ]);

        $response = Http::asForm()
            ->timeout(15)
            ->post('https://api.vk.com/method/messages.send', [
                'access_token' => $token,
                'v' => $version,
                'user_id' => $userId,
                'message' => $message,
                'random_id' => random_int(1, PHP_INT_MAX),
            ])
            ->throw()
            ->json();

        if (isset($response['error'])) {
            throw new RuntimeException($response['error']['error_msg'] ?? 'ВКонтакте не принял сообщение.');
        }

        if (! array_key_exists('response', $response)) {
            throw new RuntimeException('ВКонтакте вернул неожиданный ответ.');
        }
    }
}
