<?php

namespace App\Services\Checko;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class CheckoService
{
    private const BASE_URL = 'https://api.checko.ru/v2';

    /**
     * Варианты поиска: что ищем и какой идентификатор передаём в API.
     */
    public static function targets(): array
    {
        return [
            'company_inn' => [
                'label' => 'Организация по ИНН',
                'endpoint' => 'company',
                'param' => 'inn',
                'digits' => 10,
                'placeholder' => '4027148080',
            ],
            'company_ogrn' => [
                'label' => 'Организация по ОГРН',
                'endpoint' => 'company',
                'param' => 'ogrn',
                'digits' => 13,
                'placeholder' => '1224000000278',
            ],
            'entrepreneur_inn' => [
                'label' => 'ИП по ИНН',
                'endpoint' => 'entrepreneur',
                'param' => 'inn',
                'digits' => 12,
                'placeholder' => '402907671076',
            ],
            'entrepreneur_ogrn' => [
                'label' => 'ИП по ОГРНИП',
                'endpoint' => 'entrepreneur',
                'param' => 'ogrn',
                'digits' => 15,
                'placeholder' => '310402910200035',
            ],
        ];
    }

    public static function target(string $key): ?array
    {
        return self::targets()[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function lookup(string $targetKey, string $number): array
    {
        $target = self::target($targetKey);

        if ($target === null) {
            throw new RuntimeException('Неизвестный вариант поиска.');
        }

        $apiKey = config('services.checko.api_key');

        if (! is_string($apiKey) || $apiKey === '') {
            throw new RuntimeException('Ключ API Чекко не настроен.');
        }

        try {
            $response = Http::acceptJson()
                ->timeout(15)
                ->get(self::BASE_URL.'/'.$target['endpoint'], [
                    'key' => $apiKey,
                    $target['param'] => $number,
                ]);
        } catch (ConnectionException $exception) {
            Log::warning('Checko API connection failed', ['endpoint' => $target['endpoint']]);

            throw new RuntimeException('Не удалось связаться с сервисом Чекко. Попробуйте позже.');
        }

        if ($response->failed()) {
            Log::warning('Checko API request failed', [
                'endpoint' => $target['endpoint'],
                'status' => $response->status(),
            ]);

            throw new RuntimeException('Сервис Чекко вернул ошибку ('.$response->status().').');
        }

        $payload = $response->json();

        if (! is_array($payload)) {
            throw new RuntimeException('Сервис Чекко вернул некорректный ответ.');
        }

        $meta = $payload['meta'] ?? [];

        if (is_array($meta) && ($meta['status'] ?? null) === 'error') {
            $message = $meta['message'] ?? null;

            throw new RuntimeException(is_string($message) && $message !== ''
                ? $message
                : 'Сервис Чекко не смог выполнить запрос.');
        }

        if (empty($payload['data'])) {
            throw new RuntimeException('По этому номеру ничего не найдено.');
        }

        return $payload;
    }
}
