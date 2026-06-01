<?php

namespace App\Livewire\Phpcatru;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ContactForm extends Component
{
    public $name = '';
    public $phone = '';
    public $email = '';
    public $message = '';
    public $service = '';
    public $sent = false;

    public $services = [
        '' => 'Выберите услугу',
        'on-site' => 'Выездная настройка',
        'local-ai' => 'Локальные модели',
        'hosted' => 'Наша площадка',
        'training' => 'Обучение',
        'support' => 'Техподдержка',
        'security' => 'Аудит безопасности',
    ];

    protected $rules = [
        'name' => 'required|min:2',
        'phone' => 'required|min:5',
        'message' => 'nullable|min:5',
    ];

    public function submit()
    {
        $this->validate();

        $serviceText = $this->service ? ($this->services[$this->service] ?? $this->service) : 'Не указана';

        $text = "Заявка с php-cat.ru\n"
            . "Имя: {$this->name}\n"
            . "Телефон: {$this->phone}\n"
            . "Email: " . ($this->email ?: 'не указан') . "\n"
            . "Услуга: {$serviceText}\n"
            . "Сообщение: " . ($this->message ?: 'не указано');

        \Nyos\Msg::sendTelegramm($text, null, 2, env('TOKEN_WARN_TELEGA'));

        $this->sendToVk($text);

        $this->sent = true;
        $this->reset(['name', 'phone', 'email', 'message', 'service']);
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
        return view('livewire.phpcatru.contact-form')
            ->layout('livewire.phpcatru.layouts.app-component', [
                'title' => 'Контакты — php-cat.ru'
            ]);
    }
}
