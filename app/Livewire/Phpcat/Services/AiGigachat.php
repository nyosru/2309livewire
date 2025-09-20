<?php

namespace App\Livewire\Phpcat\Services;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class AiGigachat extends Component
{
    public $question = '';
    public $answer = '';
    public $isLoading = false;
    public $error = '';

    protected $rules = [
        'question' => 'required|min:3|max:1000'
    ];

    public function render()
    {
        return view('livewire.phpcat.services.ai-gigachat');
    }

    public function askQuestion()
    {
        $this->validate();
        $this->isLoading = true;
        $this->error = '';
        $this->answer = '';

        try {
            $accessToken = $this->getAccessToken();

            if (!$accessToken) {
                throw new \Exception('Не удалось получить access token');
            }

            $response = $this->sendToGigaChat($this->question, $accessToken);
            $this->answer = $response;

        } catch (\Exception $e) {
            $this->error = 'Ошибка при получении ответа: ' . $e->getMessage();
            Log::error('GigaChat API error: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    private function getAccessToken()
    {
        // Проверяем кэш на наличие действительного токена
        if (Cache::has('gigachat_access_token')) {
            return Cache::get('gigachat_access_token');
        }

        $clientId = config('services.gigachat.client_id');
        $clientSecret = config('services.gigachat.client_secret');
        $scope = 'GIGACHAT_API_PERS';
        $rqUid = uniqid('', true);

        // Формируем Basic Auth header
        $authHeader = base64_encode($clientId . ':' . $clientSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $authHeader,
            'RqUID' => $rqUid,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->asForm()->post('https://ngw.devices.sberbank.ru:9443/api/v2/oauth', [
            'scope' => $scope,
            'grant_type' => 'client_credentials',
        ]);

        if ($response->failed()) {
            Log::error('GigaChat auth failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);
            throw new \Exception('Ошибка аутентификации: ' . $response->body());
        }

        $data = $response->json();

        if (!isset($data['access_token'])) {
            throw new \Exception('Access token не получен в ответе');
        }

        // Кэшируем токен на время его жизни (обычно 30 минут)
        $expiresIn = $data['expires_in'] ?? 1800;
        Cache::put('gigachat_access_token', $data['access_token'], $expiresIn - 60); // -60 секунд для запаса

        return $data['access_token'];
    }

    private function sendToGigaChat($question, $accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->timeout(60)->post('https://gigachat.devices.sberbank.ru/api/v1/chat/completions', [
            'model' => 'GigaChat',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $question
                ]
            ],
            'temperature' => 0.7,
            'max_tokens' => 1000,
            'stream' => false
        ]);

        if ($response->failed()) {
            Log::error('GigaChat API request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'headers' => $response->headers()
            ]);
            throw new \Exception('Ошибка API: ' . $response->body());
        }

        $data = $response->json();

        if (!isset($data['choices'][0]['message']['content'])) {
            Log::error('GigaChat response format unexpected', ['response' => $data]);
            throw new \Exception('Неожиданный формат ответа от GigaChat');
        }

        return $data['choices'][0]['message']['content'];
    }

    public function clearForm()
    {
        $this->question = '';
        $this->answer = '';
        $this->error = '';
    }
}
