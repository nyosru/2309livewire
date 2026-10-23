<?php

namespace App\Services\Max;

use GuzzleHttp\Exception\TransferException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class MaxService
{
    public function configured(): bool
    {
        return filled(app(MaxSettings::class)->get('bot_token'));
    }

    public function botUrl(): ?string
    {
        $username = app(MaxSettings::class)->get('bot_username');

        return is_string($username) && preg_match('/^[A-Za-z0-9_]+$/D', $username) ? 'https://max.ru/'.$username : null;
    }

    public function getBotInfo(): array
    {
        return $this->request('/me', [], 'GET');
    }

    public function getSubscriptions(): array
    {
        return $this->request('/subscriptions', [], 'GET')['subscriptions'] ?? [];
    }

    public function sendToUser(string $userId, string $text): void
    {
        $this->validateUserId($userId);
        $this->send(['user_id' => $userId], $text);
    }

    public function requestContact(string $userId, string $text): void
    {
        $this->validateUserId($userId);
        $this->send(['user_id' => $userId], $text, [[
            'type' => 'inline_keyboard',
            'payload' => ['buttons' => [[['type' => 'request_contact', 'text' => 'Поделиться телефоном']]]],
        ]]);
    }

    public function sendToChat(string $chatId, string $text): void
    {
        if (! preg_match('/^-?[0-9]{1,19}$/D', $chatId)) {
            throw new \InvalidArgumentException('Invalid MAX chat ID.');
        }
        $this->send(['chat_id' => $chatId], $text);
    }

    public function subscribe(string $url): void
    {
        $parts = parse_url($url);
        $secret = app(MaxSettings::class)->get('webhook_secret');
        if (! filter_var($url, FILTER_VALIDATE_URL) || ($parts['scheme'] ?? '') !== 'https'
            || (isset($parts['port']) && $parts['port'] !== 443) || isset($parts['user']) || isset($parts['pass'])
            || ! is_string($secret) || ! preg_match('/^[A-Za-z0-9_-]{5,256}$/D', $secret)) {
            throw new MaxAuthException('На странице «Настройки» укажите HTTPS-адрес получения событий MAX и секрет подключения (5–256 символов A-Z, a-z, 0-9, _ и -).');
        }
        $data = $this->request('/subscriptions', ['url' => $url, 'secret' => $secret, 'update_types' => ['bot_started', 'message_created']]);
        if (($data['success'] ?? false) !== true) {
            throw new MaxAuthException('MAX не подтвердил подключение webhook.');
        }
    }

    public function validateUserId(string $id): void
    {
        if (! preg_match('/^[1-9][0-9]{0,18}$/D', $id) || (strlen($id) === 19 && strcmp($id, '9223372036854775807') > 0)) {
            throw new \InvalidArgumentException('Invalid MAX user ID.');
        }
    }

    private function send(array $recipient, string $text, array $attachments = []): void
    {
        if (mb_strlen($text) < 1 || mb_strlen($text) > 4000) {
            throw new \InvalidArgumentException('MAX message must contain 1–4000 characters.');
        }
        $body = ['text' => $text];
        if ($attachments) {
            $body['attachments'] = $attachments;
        }
        $data = $this->request('/messages?'.http_build_query($recipient), $body);
        if (! is_string(data_get($data, 'message.body.mid'))) {
            throw new MaxAuthException('MAX не подтвердил отправку сообщения.');
        }
    }

    private function request(string $path, array $body, string $method = 'POST'): array
    {
        if (! $this->configured()) {
            throw new MaxAuthException('Укажите токен бота MAX на странице «Настройки».');
        }
        $verify = true;
        $bundle = config('max.ca_bundle');
        if (filled($bundle)) {
            $verify = str_starts_with($bundle, '/') ? $bundle : base_path($bundle);
            if (! is_readable($verify)) {
                throw new MaxAuthException('Не найден файл сертификата MAX_CA_BUNDLE. Проверьте настройки сервера.');
            }
        }
        try {
            // Tokens and codes must not inherit the app's global verify=false.
            $http = Http::withOptions(['verify' => $verify, 'allow_redirects' => false])->withHeaders(['Authorization' => app(MaxSettings::class)->get('bot_token')])
                ->acceptJson()->asJson()->connectTimeout(5)->timeout(15);
            $response = $method === 'GET' ? $http->get('https://platform-api2.max.ru'.$path) : $http->post('https://platform-api2.max.ru'.$path, $body);
        } catch (ConnectionException|TransferException) {
            throw new MaxAuthException('MAX временно недоступен. Попробуйте позже.');
        }
        if (! $response->successful() || ! is_array($response->json())) {
            // Never expose the provider response or token/code in logs and error pages.
            throw new MaxAuthException('MAX не принял запрос. Проверьте настройки бота и доступность получателя.');
        }

        return $response->json();
    }
}
