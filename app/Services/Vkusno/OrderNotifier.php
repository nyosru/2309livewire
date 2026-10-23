<?php

namespace App\Services\Vkusno;

use App\Models\Vkusno\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OrderNotifier
{
    public function send(Order $order): void
    {
        $token = (string) config('services.vk.token_order');
        $userId = (string) config('services.vk.vk_admin_id');
        $version = (string) config('services.vk.api_version', '5.199');

        if ($token === '' || $userId === '') {
            throw new RuntimeException('Не настроены параметры отправки заявки во ВКонтакте.');
        }

        Log::info('vkusno - new order', [
            'order_id' => $order->id,
            'reference' => $order->reference,
        ]);

        $response = Http::asForm()
            ->timeout(3)
            ->post('https://api.vk.com/method/messages.send', [
                'access_token' => $token,
                'v' => $version,
                'user_id' => $userId,
                'message' => $this->message($order),
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

    private function message(Order $order): string
    {
        $lines = [
            'Новая заявка «Вкусняжки72»',
            'Заявка №'.$order->id,
            'Имя: '.$order->name,
            'Телефон: '.$order->phone,
            $order->fulfillment === 'delivery'
                ? 'Доставка: '.$order->address
                : 'Самовывоз',
        ];

        if ($order->requested_date) {
            $lines[] = 'Желаемая дата: '.$order->requested_date->format('d.m.Y');
        }

        if (! empty($order->items)) {
            $lines[] = 'Состав:';
            foreach ($order->items as $item) {
                $unit = ! empty($item['unit']) ? ' ('.$item['unit'].')' : '';
                $estimate = ! empty($item['price_is_estimate']) ? ' (предварительно)' : '';
                $lines[] = '- '.$item['name'].$unit.' × '.$item['quantity']
                    .' — '.number_format($item['price'] * $item['quantity'], 0, ',', ' ').' ₽'.$estimate;
            }
        }

        if ($order->cake) {
            $lines[] = 'Торт: '.$order->cake['filling'].', '.$order->cake['weight'].' кг';
            if (! empty($order->cake['design'])) {
                $lines[] = 'Оформление: '.$order->cake['design'];
            }
        }

        $lines[] = 'Блюда: '.number_format($order->subtotal, 0, ',', ' ').' ₽';
        $lines[] = 'Доставка: '.($order->delivery_fee === null ? 'уточняется' : number_format($order->delivery_fee, 0, ',', ' ').' ₽');

        if ($order->comment) {
            $lines[] = 'Комментарий: '.$order->comment;
        }

        $lines[] = 'Создана: '.$order->created_at->format('d.m.Y H:i');

        return mb_substr(implode("\n", $lines), 0, 4000);
    }
}
