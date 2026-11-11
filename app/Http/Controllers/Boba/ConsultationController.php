<?php

namespace App\Http\Controllers\Boba;

use App\Http\Controllers\Controller;
use App\Services\VkNotifierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ConsultationController extends Controller
{
    public function store(Request $request, VkNotifierService $notifier)
    {
        if (is_string($request->input('phone'))) {
            $request->merge(['phone' => preg_replace('/[^+0-9]/u', '', $request->input('phone'))]);
        }

        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
            'request' => ['required', 'string', 'min:10', 'max:2000'],
            'service' => ['required', Rule::in([
                'Бесплатная консультация', 'Страхи и фобии', 'Тревога и стресс',
                'Эмоции и напряжение', 'Самооценка и личные стратегии', 'Психосоматические запросы',
                'Потери и незавершённые истории', 'Навязчивые мысли и действия', 'Личный и бизнес-коучинг',
            ])],
            'consent' => ['accepted'],
            'discount' => ['nullable', Rule::in(['1'])],
            'video_consent' => ['nullable', 'required_if:discount,1', 'accepted'],
            'website' => ['nullable', 'max:0'],
        ], [
            'phone.required' => 'Укажите номер телефона.',
            'phone.regex' => 'Проверьте номер телефона.',
            'request.required' => 'Кратко опишите ваш запрос.',
            'request.min' => 'Добавьте несколько слов о запросе.',
            'consent.accepted' => 'Нужно согласие на связь по заявке.',
            'video_consent.accepted' => 'Для участия в розыгрыше нужно разрешить использование видеозаписи.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $data = $validator->validated();
        $phone = preg_replace('/\s/u', '', $data['phone']);
        $requestText = trim($data['request']);
        $message = "Новая заявка на бесплатную консультацию — боба.рф\n"
            ."Направление: {$data['service']}\n"
            ."Телефон: {$phone}\n"
            ."Запрос: {$requestText}\n"
            .'Участие в розыгрыше скидки 50%: '.(isset($data['discount']) ? 'да' : 'нет')."\n"
            .'Разрешение на использование видеозаписи: '.(isset($data['video_consent']) ? 'да' : 'нет');

        try {
            $notifier->send($message, timeout: 8);
        } catch (\Throwable $exception) {
            Log::warning('Не удалось доставить заявку гипнолога во ВКонтакте.', [
                'exception' => $exception::class,
            ]);

            return back()->with('boba_error', 'Не получилось отправить заявку. Попробуйте ещё раз позже.');
        }

        return back()->with('boba_sent', true);
    }
}
