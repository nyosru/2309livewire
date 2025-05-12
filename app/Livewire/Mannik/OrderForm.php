<?php

namespace App\Livewire\Mannik;

use Livewire\Component;

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

        // Очистим поле телефона
        $this->phone = '';

        // Выведем сообщение об успехе
        $this->successMessage = 'Спасибо за заказ! Скоро позвоним (с 10:00 до 20:00), чтобы уточнить детали.';
    }

    public function render()
    {
        return view('livewire.mannik.order-form');
    }
}
