<?php

namespace App\Http\Controllers\Boba;

use App\Http\Controllers\Controller;
use App\Services\VkNotifierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request, VkNotifierService $notifier)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:254', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:30', 'required_without:email'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ], [
            'email.required_without' => 'Укажите телефон или электронную почту для ответа.',
            'phone.required_without' => 'Укажите телефон или электронную почту для ответа.',
            'message.required' => 'Напишите сообщение.',
            'message.min' => 'Добавьте несколько слов в сообщение.',
            'consent.accepted' => 'Нужно согласие на передачу сообщения в рабочий аккаунт ВКонтакте.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $text = "Сообщение со страницы контактов — боба.рф\n"
            .'Имя: '.(($data['name'] ?? null) ?: 'не указано')."\n"
            .'Телефон: '.(($data['phone'] ?? null) ?: 'не указан')."\n"
            .'Электронная почта: '.(($data['email'] ?? null) ?: 'не указана')."\n"
            ."Сообщение:\n".trim($data['message']);

        try {
            $notifier->send($text, timeout: 8);
        } catch (\Throwable $exception) {
            Log::warning('Не удалось доставить сообщение со страницы контактов боба.рф во ВКонтакте.', [
                'exception' => $exception::class,
            ]);

            return back()->withInput()->with('contact_error', 'Не получилось отправить сообщение. Попробуйте ещё раз позже.');
        }

        return back()->with('contact_sent', true);
    }
}
