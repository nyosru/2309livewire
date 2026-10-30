<?php

namespace App\Services\Ttt;

use App\Services\VkNotifierService;
use Illuminate\Support\Facades\Log;

class TrainingRequestNotifier
{
    public function __construct(private VkNotifierService $vkNotifier)
    {
    }

    public function send(string $phone, string $source): void
    {
        $message = "Заявка на обучение бильярду с ТТТ72\n"
            ."Телефон: {$phone}\n"
            ."Форма: {$source}";

        Log::info('ttt72 - training request', [
            'phone' => $phone,
            'source' => $source,
        ]);

        $this->vkNotifier->send($message);
    }
}
