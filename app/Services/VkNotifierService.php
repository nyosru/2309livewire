<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class VkNotifierService
{

    public function send(string $text, ?string $userId = null, int $timeout = 15): void
    {
        $token = (string) config('services.vk.token_order');
        $userId ??= (string) config('services.vk.vk_admin_id');
        $version = (string) config('services.vk.api_version', '5.199');

        if ($token === '' || $userId === '') {
            throw new RuntimeException('Не настроены параметры отправки сообщения во ВКонтакте.');
        }

        $response = Http::asForm()
            ->timeout($timeout)
            ->post('https://api.vk.com/method/messages.send', [
                'access_token' => $token,
                'v' => $version,
                'user_id' => $userId,
                'message' => $text,
                'random_id' => random_int(1, PHP_INT_MAX),
            ])
            ->throw()
            ->json();

        if (! is_array($response)) {
            throw new RuntimeException('ВКонтакте вернул неожиданный ответ.');
        }

        if (isset($response['error'])) {
            throw new RuntimeException($response['error']['error_msg'] ?? 'ВКонтакте не принял сообщение.');
        }

        if (! array_key_exists('response', $response)) {
            throw new RuntimeException('ВКонтакте вернул неожиданный ответ.');
        }
    }
}
