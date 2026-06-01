<?php

namespace App\Livewire\Phpcatru;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class IndexComponent extends Component
{
    public $name = '';
    public $phone = '';
    public $service = '';
    public $sent = false;

    public $services = [
        ['slug' => 'on-site', 'title' => 'Выездная настройка', 'sub' => 'Бесплатные + платные модели', 'desc' => 'Приезжаем, настраиваем ИИ под ваши задачи. Вы платите только за модели.', 'icon' => '🚀', 'price' => 'от 15 000 ₽'],
        ['slug' => 'local-ai', 'title' => 'Локальные модели', 'sub' => 'На вашем сервере', 'desc' => 'ИИ работает на вашем оборудовании. Все данные остаются у вас. Полная приватность.', 'icon' => '🖥️', 'price' => 'от 25 000 ₽'],
        ['slug' => 'hosted', 'title' => 'Наша площадка', 'sub' => 'Аренда серверов с ИИ', 'desc' => 'Мы предоставляем сервер с моделями, настраиваем программы и доступы. Всё включено.', 'icon' => '☁️', 'price' => 'от 5 000 ₽/мес'],
        ['slug' => 'training', 'title' => 'Обучение', 'sub' => 'Стартовое обучение сотрудников', 'desc' => 'Научим вашу команду работать с ИИ. Базовый и продвинутый уровни.', 'icon' => '🎓', 'price' => 'от 10 000 ₽'],
        ['slug' => 'support', 'title' => 'Техподдержка', 'sub' => 'Наблюдаем 24/7', 'desc' => 'Мониторинг и поддержка. Всё работает без сбоев. SLA — 1 час.', 'icon' => '🛡️', 'price' => 'от 3 000 ₽/мес'],
        ['slug' => 'security', 'title' => 'Аудит безопасности', 'sub' => 'Проверка сети', 'desc' => 'Проверим вашу сеть на уязвимости. Найдём проблемы — предложим решения.', 'icon' => '🔒', 'price' => 'от 20 000 ₽'],
    ];

    protected $rules = [
        'name' => 'required|min:2',
        'phone' => 'required|min:5',
    ];

    public function submit()
    {
        $this->validate();

        $text = "Новая заявка с php-cat.ru\n"
            . "Имя: {$this->name}\n"
            . "Телефон: {$this->phone}\n"
            . "Услуга: " . ($this->service ?: 'Не указана');

        \Nyos\Msg::sendTelegramm($text, null, 2, env('TOKEN_WARN_TELEGA'));

        $this->sendToVk($text);

        $this->sent = true;
        $this->reset(['name', 'phone', 'service']);
    }

    private function sendToVk(string $message): void
    {
        $token = env('VK_GROUP_TOKEN');
        $groupId = env('VK_GROUP_ID');
        if (!$token || !$groupId) {
            return;
        }
        try {
            Http::post('https://api.vk.com/method/messages.send', [
                'access_token' => $token,
                'v' => '5.199',
                'peer_id' => -abs((int) $groupId),
                'message' => $message,
                'random_id' => random_int(1, 999999),
            ]);
        } catch (\Throwable $e) {
            \Nyos\Msg::sendTelegramm('VK send error: ' . $e->getMessage(), null, 2, env('TOKEN_WARN_TELEGA'));
        }
    }

    public function render()
    {
        return view('livewire.phpcatru.index-component')
            ->layout('livewire.phpcatru.layouts.app-component', [
                'title' => 'Внедрение ИИ в бизнес — php-cat.ru'
            ]);
    }
}
