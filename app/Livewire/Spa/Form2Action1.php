<?php

namespace App\Livewire\Spa;

use Livewire\Component;
use Nyos\Msg;

class Form2Action1 extends Component
{


    public $phone;
    public $telegram_bot_token_config;
    public $telegram_bot_token;

    public function getTelegramToken()
    {

        if (!empty($this->telegram_bot_token_config))
            $this->telegram_bot_token = config($this->telegram_bot_token_config);

    }

    public function sendMsg()
    {
//        Msg::sendTelegramm('Заказ '.PHP_EOL.'указали телефон: '.$this->phone,null, 2, config( 'custom.BOT_TELEGA_ORDER' ) );

        $text = 'Заказ ' . PHP_EOL . 'указали телефон: ' . $this->phone;

//        $this->getTelegramToken();
//        if (empty($this->telegram_bot_token)) {
//            $this->telegram_bot_token = env('BOT_TELEGA_TOKEN_URALWEBINFO');
//            $text .= PHP_EOL . '**не указан токен телеграм**';
//        }

//        Msg::sendTelegramm($text ,null, 2, $this->telegram_bot_token );
//        Msg::sendTelegramm($text ,null, 2, $this->telegram_bot_token );
//        Msg::sendTelegramm($text ,null, 2, $this->telegram_bot_token );
//        Msg::sendTelegramm($text ,360209578, null, $this->telegram_bot_token );
//        Msg::sendTelegramm($text ,null, 1 );
        Msg::sendTelegramm($text, null, 2, env('TOKEN_WARN_TELEGA'));
//        Msg::sendTelegramm($text ,'360209578', 2, $this->telegram_bot_token );

//        dd(__FILE__,__LINE__, $text, $this->telegram_bot_token ?? 'x' );

        // Устанавливаем флаг в сессию
        session()->flash('message_ok', 'Сообщение отправлено');
    }

    public function render()
    {
        return view('livewire.spa.form2-action1');
    }
}
