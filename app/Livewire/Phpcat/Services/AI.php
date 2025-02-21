<?php

namespace App\Livewire\Phpcat\Services;

use App\Http\Controllers\Service\AiController;
use Livewire\Component;
use Nyos\Msg as MsgAlias;

class AI extends Component
{
    public $msg;
    public $answer;
    public function send()
    {

//        MsgAlias::sendTelegramm('msg в AI:'.$this->msg , 5152088168, null, '5960307100:AAHshaEf6WXw4rKbDg-JCeAyOEsFoHqZmNA');
        MsgAlias::sendTelegramm('msg в AI:'.$this->msg );

//        $this->answer = 'загружаю..';
        $AI = new AiController();
        $r = $AI->sendMsg($this->msg);
//        dd($r);
        $this->answer = $r;
        MsgAlias::sendTelegramm('msg в AI: ответ: '.( $r['result']['alternatives'][0]['message']['text'] ?? serialize($r) ) );

    }
    public function render()
    {
        return view('livewire.phpcat.services.a-i');
    }
}
