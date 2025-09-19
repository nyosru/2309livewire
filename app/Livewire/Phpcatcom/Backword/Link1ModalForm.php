<?php

namespace App\Livewire\Phpcatcom\Backword;

use Livewire\Component;
use Nyos\Msg;

class Link1ModalForm extends Component
{
    public bool $isOpen = false;
    public string $phone = '';

    protected $rules = [
        'phone' => 'required|string|min:10|max:20',
    ];

    public function openModal()
    {
        $this->resetValidation();
        $this->phone = '';
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function submit()
    {
        $this->validate();

        // Логика для обработки формы (сохранение, отправка уведомления и т.д.)
        // Например: store phone in DB or send SMS notification


        // Логика отправки письма или сохранения
        $msg = 'Заявка на консультацию: Телефон: ' . $this->phone ;

        $token = config('telegram.TELEGRAM_BOT_TOKEN_FOR_BACKWORD','');
        $userIds = config('telegram.user_ids',[]);

//        dd([$msg,$token,$userIds]);

        foreach ($userIds as $user_id) {
            if (!empty($user_id)) {
                Msg::sendTelegramm($msg, $user_id, null, $token);
            }
        }

//        $this->closeModal();

        session()->flash('send_tel_message', 'Спасибо! Ваша заявка на консультацию принята ('.htmlspecialchars($this->phone).'), позвоним в ближайшее рабочее время.');
//        $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.phpcatcom.backword.link1-modal-form');
    }
}
