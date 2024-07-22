<?php

namespace App\Livewire\StNews;

use Livewire\Component;
use Nyos\Msg;

class Backword extends Component
{
    public $showAdditionalFields = false;
    public $inputMsg = '';
    public $inputName = '';
    public $inputPhone = '';
    public $inputTelega = '';
    public $inputPromo = '';

    public function showFields()
    {
        $this->showAdditionalFields = true;
    }

    public function submit()
    {
        // Логика отправки данных
        $msg = 'msg: '.$this->inputMsg;
        $msg .= PHP_EOL;
        $msg .= 'name: '.$this->inputName;
        $msg .= PHP_EOL;
        $msg .=  'phone: '.$this->inputPhone;
        $msg .= PHP_EOL;
        $msg .= 'Telega: '.$this->inputTelega;
        $msg .= PHP_EOL;
        $msg .= 'Promo: '.$this->inputPromo;

        Msg::sendTelegramm($msg, null,1);

        // Сброс значений полей
        $this->inputMsg = '';
        $this->inputName = '';
        $this->inputPhone = '';
        $this->inputTelega = '';
		$this->inputPromo = '';
        $this->showAdditionalFields = false;
    }

    public function render()
    {
        return view('livewire.st-news.backword');
    }
}
