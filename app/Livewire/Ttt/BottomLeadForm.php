<?php

namespace App\Livewire\Ttt;

use App\Services\Ttt\TrainingRequestNotifier;
use Livewire\Component;

class BottomLeadForm extends Component
{
    public string $phone = '';

    public string $website = '';

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'min:10', 'max:25', 'regex:/^[0-9+()\-\s]+$/'],
            'website' => ['nullable', 'max:0'],
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.required' => 'Укажите номер телефона.',
            'phone.min' => 'Проверьте номер телефона.',
            'phone.max' => 'Номер телефона слишком длинный.',
            'phone.regex' => 'Используйте только цифры, пробелы, +, -, (, ).',
        ];
    }

    public function submit(TrainingRequestNotifier $notifier): void
    {
        $this->validate();

        try {
            $notifier->send($this->phone, 'нижняя форма');
        } catch (\Throwable $exception) {
            report($exception);
            $this->addError('form', 'Не получилось отправить заявку. Пожалуйста, попробуйте ещё раз.');

            return;
        }

        $this->reset(['phone', 'website']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.ttt.bottom-lead-form');
    }
}
