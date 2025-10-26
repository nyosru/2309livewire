<?php

namespace App\Livewire\Spa;

use Livewire\Component;
use Nyos\Msg;

class Form2Action1 extends Component
{


    public $phone;

    public function sendMsg(){
        Msg::sendTelegramm('Заказ '.PHP_EOL.'указали телефон: '.$this->phone,null, 2, config( 'custom.BOT_TELEGA_ORDER' ) );
        // Устанавливаем флаг в сессию
        session()->flash('message_ok', 'Сообщение отправлено');
    }

    public function render()
    {
        return view('livewire.spa.form2-action1');
    }
}
