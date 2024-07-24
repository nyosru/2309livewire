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
    public $showBlock = false;
    public $loading = false;
    public $sentSuccessfully = false;

    protected $rules = [
        'inputMsg' => 'required|string|min:5',
        'inputName' => 'required|string|min:2',
    ];

    protected $messages = [
        'inputMsg.required' => 'Поле "Сообщение" обязательно для заполнения.',
        'inputMsg.min' => 'Поле "Сообщение" должно содержать минимум :min символов.',
        'inputName.required' => 'Поле "Как Вас зовут" обязательно для заполнения.',
        'inputName.min' => 'Поле "Как Вас зовут" должно содержать минимум :min символов.',
    ];

    public function mount()
    {
        if (request()->query('ss') == 1) {
            $this->showBlock = true;
        }
    }

    public function render()
    {
        return view('livewire.st-news.backword');
    }

    public function showFields()
    {
        $this->showAdditionalFields = true;
    }

    public function submit()
    {
        $this->loading = true;

        try {
            $this->validate();

            // Логика отправки данных
            $msg = 'msg: ' . $this->inputMsg;
            $msg .= PHP_EOL;
            $msg .= 'name: ' . $this->inputName;
            $msg .= PHP_EOL;
            $msg .= 'phone: ' . $this->inputPhone;
            $msg .= PHP_EOL;
            $msg .= 'Telega: ' . $this->inputTelega;
            $msg .= PHP_EOL;
            $msg .= 'Promo: ' . $this->inputPromo;

            Msg::sendTelegramm($msg, null, 1);

            // Сброс значений полей
            $this->reset(['inputMsg', 'inputName', 'inputPhone', 'inputTelega', 'inputPromo', 'showAdditionalFields']);

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

    public function resetForm()
    {
        $this->sentSuccessfully = false;
        $this->showAdditionalFields = false;
        $this->inputMsg = '';
        $this->inputName = '';
        $this->inputPhone = '';
        $this->inputTelega = '';
        $this->inputPromo = '';
    }
}
