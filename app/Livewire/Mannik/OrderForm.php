<?php

namespace App\Livewire\Mannik;

use Livewire\Component;
use Nyos\Msg;

class OrderForm extends Component
{
    public $phone;
    public $successMessage = '';

    protected $rules = [
        'phone' => 'required|string|min:6|max:20',
    ];

    public function submit()
    {
        $this->validate();

        // Здесь можно добавить логику сохранения заказа или отправки уведомления
        // Например, сохранить в базу или отправить email

//        Msg::sendTelegramm('Заказ манника'.PHP_EOL.'телефон: '.$this->phone,null, null, config( 'custom.TELEGRAM_BOT_ORDER_TOKEN' ) );
        Msg::sendTelegramm('Заказ манника'.PHP_EOL.'телефон: '.$this->phone,null, 2, config( 'custom.TELEGRAM_BOT_ORDER_TOKEN' ) );

        // Выведем сообщение об успехе
        $this->successMessage = '<b>Спасибо за заказ!
<br/>
' . htmlspecialchars($this->phone) . '
</b><br/>Скоро позвоним (с 10:00 до 20:00), чтобы уточнить детали.';

        // Очистим поле телефона
        $this->phone = '';
    }

    public function render()
    {
        return view('livewire.mannik.order-form');
    }
}
