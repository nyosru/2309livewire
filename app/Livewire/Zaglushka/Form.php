<?php

namespace App\Livewire\Zaglushka;

use Livewire\Component;
use Nyos\Msg;

class Form extends Component
{
    public $show_form = false;
    public $domain = '';

    public $inputName = '';
    public $inputPhone = '';
    public $inputPrice = '10000';
    public $loading = false;
    public $sentSuccessfully = false;


    /**
     * отправляем
     * @return void
     */
    public function mount(){
        $this->domain =
            strpos( $_SERVER['HTTP_HOST'], 'xn--') !== false ? idn_to_utf8($_SERVER['HTTP_HOST']) : $_SERVER['HTTP_HOST']
        ;
    }

    public function switchShowForm()
    {
        $this->show_form = !$this->show_form;
    }

    public function render()
    {
        return view('livewire.zaglushka.form');
    }


    public function submitForm()
    {
        $this->loading = true;

        try {
//            $this->validate();

            // Логика отправки данных
            $msg = 'хочит взять в аренду домен';
            $msg .= PHP_EOL;
            $msg .= 'name: ' . $this->inputName;
            $msg .= PHP_EOL;
            $msg .= 'phone: ' . $this->inputPhone;
            $msg .= PHP_EOL;
            $msg .= 'Price: ' . $this->inputPrice;

            Msg::sendTelegramm($msg, 360209578, 2, env('TOKEN_WARN_TELEGA'));

            // Сброс значений полей
            $this->reset(['inputName', 'inputPhone', 'inputPrice']);

            // Успешная отправка
            $this->sentSuccessfully = true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->loading = false;
            throw $e;
        } catch (\Exception $e) {
            $this->loading = false;
            session()->flash('error', 'Произошла ошибка при отправке сообщения.');
        }

        $this->loading = false;
    }

}
