<?php

namespace App\Livewire\Phpcatru;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class LeadForm extends Component
{
    public $name = '';
    public $email = '';
    public $phone = '';
    public $sent = false;

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'phone' => 'required|min:5',
    ];

    public function submit()
    {
        $this->validate();

        $text = "Скачали чек-лист с php-cat.ru\n"
            . "Имя: {$this->name}\n"
            . "Email: {$this->email}\n"
            . "Телефон: {$this->phone}";

        \Nyos\Msg::sendTelegramm($text, null, 2, env('TOKEN_WARN_TELEGA'));

        $this->sendToVk($text);

        $this->sent = true;
        $this->reset(['name', 'email', 'phone']);
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
        return view('livewire.phpcatru.lead-form');
    }
}
