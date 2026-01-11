<?php

namespace App\Livewire\Spa;

use Livewire\Component;
use Nyos\Msg;

class Form1 extends Component
{

    public $phone;

    public function sendMsg(){

        $msg = 'Заказ '.PHP_EOL.'указали телефон: '.$this->phone;

//        Msg::sendTelegramm('Заказ '.PHP_EOL.'указали телефон: '.$this->phone,null, 2, config( 'custom.BOT_TELEGA_ORDER' ) );
//        Msg::sendTelegramm('Заказ '.PHP_EOL.'указали телефон: '.$this->phone,null, 1, config( 'custom.BOT_TELEGA_ORDER' ) );
        Msg::sendTelegramm($msg,null, 2, env('BOT_TELEGA_ORDER') );
//        Msg::sendTelegramm('Заказ '.PHP_EOL.'указали телефон: '.$this->phone,null, 1, env( 'BOT_TELEGA_ORDER' ) );
//        Msg::sendTelegramm('Заказ '.PHP_EOL.'указали телефон: '.$this->phone,null, 1, env( 'BOT_TELEGA_ORDER' ) );


//        Msg::sendTelegramm($msg, 360209578, 2, env('TOKEN_WARN_TELEGA'));

        // Устанавливаем флаг в сессию
        session()->flash('message_ok', 'Сообщение отправлено');
    }
    public function render()
    {
        return view('livewire.spa.form1');
    }
}
