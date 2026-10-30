<?php

namespace App\Http\Controllers\Dzudo;

use App\Http\Controllers\Controller;
use App\Services\VkNotifierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{
    public function store(Request $request, VkNotifierService $notifier)
    {
        if (is_string($request->input('phone'))) {
            $request->merge(['phone' => preg_replace('/[\s()\-]/u', '', $request->input('phone'))]);
        }

        $data = $request->validate([
            'phone' => ['required', 'string', 'regex:/^\+?[0-9]{10,15}$/'],
            'source' => ['required', Rule::in(['hero', 'closing'])],
            'consent' => ['accepted'],
            'website' => ['nullable', 'max:0'],
        ], [
            'phone.required' => 'Укажите номер телефона.',
            'phone.regex' => 'Проверьте номер телефона.',
            'consent.accepted' => 'Нужно согласие на обработку номера для связи по заявке.',
        ]);

        $reference = (string) Str::uuid();
        $applicationId = DB::table('dzudo_applications')->insertGetId([
            'reference' => $reference,
            'phone' => encrypt($data['phone']),
            'source' => $data['source'],
            'notified_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try {
            $notifier->send("Новая заявка на занятия дзюдо\nТелефон: {$data['phone']}\nИсточник: {$data['source']}\nЗаявка №{$reference}");
            DB::table('dzudo_applications')->where('id', $applicationId)->update([
                'notified_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            Log::warning('Не удалось отправить уведомление о заявке центра дзюдо.', [
                'application_id' => $applicationId,
                'exception' => $exception::class,
            ]);
        }

        return back()->with('dzudo_application_sent', true);
    }
}
