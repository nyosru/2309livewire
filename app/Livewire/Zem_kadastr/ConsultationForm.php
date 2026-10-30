<?php

namespace App\Livewire\Zem_kadastr;

use App\Services\VkNotifierService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ConsultationForm extends Component
{
    public string $name = '';

    public string $phone = '';

    public string $contactMethod = 'call';

    public string $service = 'Не знаю, нужна консультация';

    public string $question = '';

    public string $website = '';

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'min:10', 'max:25', 'regex:/^[0-9+()\-\s]+$/'],
            'contactMethod' => ['required', 'in:call,telegram,whatsapp'],
            'service' => ['required', 'string', 'max:100'],
            'question' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'max:0'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Укажите, как к вам обращаться.',
            'name.min' => 'Имя должно содержать хотя бы 2 символа.',
            'phone.required' => 'Укажите номер телефона.',
            'phone.min' => 'Проверьте номер телефона.',
            'phone.max' => 'Номер телефона слишком длинный.',
            'phone.regex' => 'В номере можно использовать только цифры, пробелы, +, -, (, ).',
            'contactMethod.in' => 'Выберите способ связи.',
            'question.max' => 'Вопрос не должен превышать 2000 символов.',
        ];
    }

    public function submit(VkNotifierService $vkNotifier): void
    {
        $this->validate();

        $contactMethod = match ($this->contactMethod) {
            'telegram' => 'Написать в Telegram',
            'whatsapp' => 'Написать в WhatsApp',
            default => 'Позвонить по телефону',
        };

        $message = "Заявка с сайта земельныйкадастр.рф\n"
            ."Имя: {$this->name}\n"
            ."Телефон: {$this->phone}\n"
            ."Способ связи: {$contactMethod}\n"
            ."Услуга: {$this->service}\n"
            .'Ситуация: '.($this->question ?: 'Не указана');

        try {
            Log::info('zem-kadastr - notification', [
                'name' => $this->name,
                'phone' => $this->phone,
                'contact_method' => $this->contactMethod,
                'service' => $this->service,
                'question' => $this->question,
            ]);

            //            Msg::sendTelegramm('Заказ манника', null, 2, config('custom.TELEGRAM_BOT_ORDER_TOKEN'));
            //            $result = Msg::sendVkFromGroup($message, '5903492', 'order');

            $vkNotifier->send($message);
        } catch (\Throwable $exception) {
            report($exception);
            $this->addError('form', 'Не получилось отправить вопрос. Пожалуйста, попробуйте ещё раз.');

            return;
        }

        $this->reset(['name', 'phone', 'question', 'website']);
        $this->contactMethod = 'call';
        $this->service = 'Не знаю, нужна консультация';
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.zem_kadastr.consultation-form');
    }
}
