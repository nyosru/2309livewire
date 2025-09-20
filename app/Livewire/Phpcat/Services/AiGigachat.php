<?php

namespace App\Livewire\Phpcat\Services;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AiGigachat extends Component
{
    public $question = '';
    public $answer = '';
    public $isLoading = false;
    public $error = '';
    public $showDemoWarning = true;

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
            // Проверяем наличие учетных данных
            if (!$this->hasValidCredentials()) {
                $this->answer = $this->getMockResponse($this->question);
                $this->showDemoWarning = true;
                $this->isLoading = false;
                return;
            }

            $accessToken = $this->getAccessToken();

            if (!$accessToken) {
                throw new \Exception('Не удалось получить access token');
            }

            $response = $this->sendToGigaChat($this->question, $accessToken);
            $this->answer = $response;
            $this->showDemoWarning = false;

        } catch (\Exception $e) {
            $this->error = 'Ошибка: ' . $e->getMessage();
            Log::error('GigaChat API error: ' . $e->getMessage());

            // Показываем демо-ответ при ошибке
            $this->answer = $this->getMockResponse($this->question);
            $this->showDemoWarning = true;
        }

        $this->isLoading = false;
    }

    private function hasValidCredentials()
    {
        $clientId = config('services.gigachat.client_id');
        $clientSecret = config('services.gigachat.client_secret');

        return !empty($clientId) && !empty($clientSecret) &&
            $clientId !== 'your_client_id_here' &&
            $clientSecret !== 'your_client_secret_here';
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
        $rqUid = Str::uuid()->toString();

        // Согласно новой документации: https://developers.sber.ru/docs/redirect?uniq_id=getGigaAccessToken
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($clientId . ':' . $clientSecret),
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

            if ($response->status() === 400) {
                throw new \Exception('Неверные учетные данные. Проверьте Client ID и Client Secret.');
            }

            if ($response->status() === 401) {
                throw new \Exception('Ошибка авторизации. Учетные данные недействительны.');
            }

            throw new \Exception('Ошибка аутентификации: ' . $response->status());
        }

        $data = $response->json();

        if (!isset($data['access_token'])) {
            throw new \Exception('Access token не получен в ответе API');
        }

        // Кэшируем токен на время его жизни (обычно 30 минут)
        $expiresIn = $data['expires_in'] ?? 1800;
        Cache::put('gigachat_access_token', $data['access_token'], $expiresIn - 60);

        return $data['access_token'];
    }

    private function sendToGigaChat($question, $accessToken)
    {
        // Согласно документации GigaChat API
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->timeout(30)->post('https://gigachat.devices.sberbank.ru/api/v1/chat/completions', [
            'model' => 'GigaChat', // или 'GigaChat-Pro' для продвинутой версии
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $question
                ]
            ],
            'temperature' => 0.7,
            'top_p' => 0.9,
            'n' => 1,
            'stream' => false,
            'max_tokens' => 1024,
            'repetition_penalty' => 1.0,
        ]);

        if ($response->failed()) {
            Log::error('GigaChat API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->status() === 401) {
                // Токен устарел, очищаем кэш
                Cache::forget('gigachat_access_token');
                throw new \Exception('Токен устарел. Попробуйте еще раз.');
            }

            throw new \Exception('Ошибка API GigaChat: ' . $response->status());
        }

        $data = $response->json();

        if (!isset($data['choices'][0]['message']['content'])) {
            Log::error('GigaChat response format unexpected', ['response' => $data]);
            throw new \Exception('Неожиданный формат ответа от GigaChat');
        }

        return $data['choices'][0]['message']['content'];
    }

    private function getMockResponse($question)
    {
        $mockResponses = [
            'laravel' => [
                'title' => 'Laravel Framework',
                'content' => "Laravel - это современный PHP-фреймворк с элегантным синтаксисом. Он предоставляет:\n\n• MVC архитектуру\n• Eloquent ORM\n• Миграции баз данных\n• Blade шаблонизатор\n• Artisan CLI\n• Встроенную аутентификацию\n• Middleware\n• Тестирование\n\nLaravel значительно ускоряет разработку веб-приложений."
            ],
            'livewire' => [
                'title' => 'Laravel Livewire',
                'content' => "Livewire - это полнофреймворк для Laravel, позволяющий создавать динамические интерфейсы без написания JavaScript.\n\nОсновные возможности:\n• Декларативные компоненты\n• Двусторонняя binding\n• Жизненный цикл компонентов\n• События\n• Валидация\n• Загрузка файлов\n• Пагинация\n\nLivewire идеален для разработчиков PHP, которые хотят создавать современные SPA-приложения."
            ],
            'php' => [
                'title' => 'PHP Language',
                'content' => "PHP - серверный язык программирования для веб-разработки.\n\nОсновные особенности:\n• Интерпретируемый язык\n• Широкая поддержка хостингов\n• Большое сообщество\n• Множество фреймворков\n• Интеграция с базами данных\n• Поддержка ООП\n\nPHP powers 79% всех веб-сайтов, включая WordPress, Facebook (изначально), и многие другие."
            ],
            'default' => [
                'title' => 'Демо-ответ',
                'content' => "Спасибо за ваш вопрос: \"{$question}\"\n\nЭто демонстрационный ответ. Для получения реальных ответов от GigaChat AI:\n\n1. Зарегистрируйтесь на https://sbercloud.ru/\n2. Получите Client ID и Client Secret\n3. Добавьте их в .env файл:\n\nGIGACHAT_CLIENT_ID=ваш_client_id\nGIGACHAT_CLIENT_SECRET=ваш_client_secret\n\nПосле настройки вы получите доступ к мощному AI-ассистенту от Sber."
            ]
        ];

        $questionLower = strtolower($question);

        foreach ($mockResponses as $key => $response) {
            if ($key !== 'default' && str_contains($questionLower, $key)) {
                return "**{$response['title']}**\n\n{$response['content']}";
            }
        }

        return "**{$mockResponses['default']['title']}**\n\n{$mockResponses['default']['content']}";
    }

    public function clearForm()
    {
        $this->question = '';
        $this->answer = '';
        $this->error = '';
        $this->showDemoWarning = false;
    }

    public function tryExample($example)
    {
        $examples = [
            'laravel' => 'Расскажи о возможностях Laravel Framework',
            'livewire' => 'Что такое Laravel Livewire и как его использовать?',
            'php' => 'Какие нововведения в последних версиях PHP?'
        ];

        $this->question = $examples[$example] ?? $examples['laravel'];
        $this->askQuestion();
    }
}
