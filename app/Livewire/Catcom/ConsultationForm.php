<?php

namespace App\Livewire\Catcom;

use Livewire\Component;
use Nyos\Msg;

class ConsultationForm extends Component
{
    public string $phone = '';

    public string $contactMethod = 'call';

    public string $question = '';

    public string $website = '';

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'min:10', 'max:25', 'regex:/^[0-9+()\-\s]+$/'],
            'contactMethod' => ['required', 'in:call,max'],
            'question' => ['required', 'string', 'min:5', 'max:2000'],
            'website' => ['nullable', 'max:0'],
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.required' => 'Укажите номер телефона.',
            'phone.min' => 'Проверьте номер телефона.',
            'phone.max' => 'Номер телефона слишком длинный.',
            'phone.regex' => 'В номере можно использовать только цифры, пробелы, +, -, (, ).',
            'contactMethod.in' => 'Выберите способ связи.',
            'question.required' => 'Напишите первый вопрос.',
            'question.min' => 'Расскажите о вопросе немного подробнее.',
            'question.max' => 'Вопрос не должен превышать 2000 символов.',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        $contactMethod = $this->contactMethod === 'max'
            ? 'Написать в MAX'
            : 'Позвонить по телефону';

        $message = "Заявка на бесплатную консультацию с Катком.рф\n"
            ."Телефон: {$this->phone}\n"
            ."Способ связи: {$contactMethod}\n"
            ."Первый вопрос: {$this->question}";

        try {
            $result = Msg::sendVkFromGroup($message, '5903492', 'notification');
            $response = json_decode((string) $result, true);

            if (is_array($response) && array_key_exists('status', $response) && ! $response['status']) {
                throw new \RuntimeException($response['message'] ?? 'ВК не принял сообщение.');
            }
        } catch (\Throwable $exception) {
            report($exception);
            $this->addError('form', 'Не получилось отправить вопрос. Пожалуйста, попробуйте ещё раз.');

            return;
        }

        $this->reset(['phone', 'question', 'website']);
        $this->contactMethod = 'call';
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.catcom.consultation-form');
    }
}
