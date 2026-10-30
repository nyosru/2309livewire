<?php

namespace App\Services\Vkusno;

use App\Models\Vkusno\Order;
use App\Services\VkNotifierService;
use Illuminate\Support\Facades\Log;

class OrderNotifier
{
    public function __construct(private VkNotifierService $vkNotifier)
    {
    }

    public function send(Order $order): void
    {
        Log::info('vkusno - new order', [
            'order_id' => $order->id,
            'reference' => $order->reference,
        ]);

        $this->vkNotifier->send($this->message($order), timeout: 3);
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
