<?php

namespace App\Livewire\Catcom;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            Log::info('catcom - notification', [
                'phone' => $this->phone,
                'contact_method' => $this->contactMethod,
                'question' => $this->question,
            ]);

//            Msg::sendTelegramm('Заказ манника', null, 2, config('custom.TELEGRAM_BOT_ORDER_TOKEN'));
//            $result = Msg::sendVkFromGroup($message, '5903492', 'order');

            $token = (string) config('services.vk.token_order');
            $userId = (string) config('services.vk.vk_admin_id');
            $version = (string) config('services.vk.api_version', '5.199');

            $result = Http::asForm()->post('https://api.vk.com/method/messages.send', [
                'access_token' => $token,
                'v' => $version,
                'user_id' => $userId,
                'message' => $message,
                'random_id' => random_int(1, PHP_INT_MAX),
            ])->throw();

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
