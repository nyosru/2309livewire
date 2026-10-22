<?php

namespace App\Http\Controllers\Max;

use App\Http\Controllers\Controller;
use App\Services\Max\MaxAuthException;
use App\Services\Max\MaxService;
use App\Services\Max\RecipientRegistry;
use App\Services\Max\SignedContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class WebhookController extends Controller
{
    public function __invoke(Request $request, MaxService $max, SignedContact $contacts, RecipientRegistry $recipients)
    {
        $secret = config('max.webhook_secret');
        abort_unless(is_string($secret) && strlen($secret) >= 5 && hash_equals($secret, (string) $request->header('X-Max-Bot-Api-Secret')), 403);
        abort_if(strlen($request->getContent()) > 65536, 413);
        $user = null;
        $attachments = [];
        if ($request->input('update_type') === 'bot_started') {
            $user = $request->input('user');
        } elseif ($request->input('update_type') === 'message_created'
            && $request->input('message.recipient.chat_type') === 'dialog'
            && ! $request->input('message.link')) {
            $user = $request->input('message.sender');
            // TrimStrings changes the signed vCard's trailing CRLF. Verify original JSON bytes.
            $attachments = data_get(json_decode($request->getContent(), true), 'message.body.attachments', []);
            if (! is_array($attachments)) {
                return response()->json(['ok' => true]);
            }
            if (! collect($attachments)->contains(fn ($item) => is_array($item) && ($item['type'] ?? null) === 'contact')
                && (! is_string($request->input('message.body.text'))
                    || ! in_array(trim($request->input('message.body.text')), ['/start', '/id', '/phone'], true))) {
                return response()->json(['ok' => true]);
            }
        }
        if (! is_array($user) || ! isset($user['user_id']) || ! is_scalar($user['user_id']) || ($user['is_bot'] ?? false)) {
            return response()->json(['ok' => true]);
        }
        try {
            $id = (string) $user['user_id'];
            $max->validateUserId($id);
        } catch (\InvalidArgumentException) {
            return response()->json(['ok' => true]);
        }
        $key = 'max:webhook:'.hash('sha256', $request->getContent());
        if (! Cache::add($key, true, 3600)) {
            return response()->json(['ok' => true]);
        }
        try {
            $phone = null;
            foreach ($attachments as $attachment) {
                if (is_array($attachment) && ($attachment['type'] ?? null) === 'contact' && is_array($attachment['payload'] ?? null)) {
                    $phone = $contacts->phone($attachment['payload'], $id);
                    if ($phone) {
                        break;
                    }
                }
            }
            if ($phone) {
                try {
                    $recipients->register($phone, $id);
                    $max->sendToUser($id, 'Телефон подтверждён. Вернитесь на сайт и запросите код входа. Доступ к панели выдаёт суперадминистратор.');
                } catch (ValidationException) {
                    $max->sendToUser($id, 'Телефон уже связан с другим аккаунтом. Обратитесь к администратору для проверки привязки.');
                }
            } else {
                $prefix = $request->input('message.body.text') === '/id' ? 'Ваш MAX ID: '.$id."\n" : '';
                $max->requestContact($id, $prefix.'Для входа на сайт нажмите «Поделиться телефоном». Нужен ваш собственный номер из MAX; контакт из адресной книги не подходит.');
            }
        } catch (MaxAuthException) {
            Cache::forget($key);

            return response()->json(['ok' => false], 503);
        }

        return response()->json(['ok' => true]);
    }
}
