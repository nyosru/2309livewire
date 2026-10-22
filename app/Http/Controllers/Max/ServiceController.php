<?php

namespace App\Http\Controllers\Max;

use App\Http\Controllers\Controller;
use App\Services\Max\MaxAuthException;
use App\Services\Max\MaxAuthService;
use App\Services\Max\MaxService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function message(Request $request, MaxService $max)
    {
        $data = $request->validate([
            'user_id' => ['required_without:chat_id', 'prohibits:chat_id', 'string', 'max:19'],
            'chat_id' => ['required_without:user_id', 'prohibits:user_id', 'string', 'max:20'],
            'text' => ['required', 'string', 'max:4000'],
        ]);
        try {
            if (isset($data['user_id'])) {
                $max->sendToUser($data['user_id'], $data['text']);
            } else {
                $max->sendToChat($data['chat_id'], $data['text']);
            }
        } catch (MaxAuthException|\InvalidArgumentException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }

        return response()->json(['sent' => true]);
    }

    public function start(Request $request, MaxAuthService $max)
    {
        $data = $request->validate([
            'phone' => ['required', 'string', 'max:32'],
            'context' => ['required', 'string', 'min:32', 'max:200'],
            'label' => ['required', 'string', 'max:100'],
        ]);
        try {
            $verification = $max->begin($data['phone'], $this->purpose($request), $data['context'], $request->ip(), true, $data['label']);
        } catch (MaxAuthException $exception) {
            return response()->json(['message' => $exception->getMessage()], 503);
        }

        return response()->json(['verification_id' => $verification->id, 'code_length' => $verification->code_length, 'expires_at' => $verification->expires_at->toIso8601String()], 201);
    }

    public function check(Request $request, MaxAuthService $max)
    {
        $data = $request->validate([
            'verification_id' => ['required', 'uuid'],
            'context' => ['required', 'string', 'min:32', 'max:200'],
            'code' => ['required', 'string', 'regex:/^[0-9]{6}$/D'],
        ]);
        $phone = $max->confirm($data['verification_id'], $this->purpose($request), $data['context'], $data['code']);
        if (! $phone) {
            return response()->json(['verified' => false, 'message' => 'Код неверен, истёк или уже использован.'], 422);
        }

        return response()->json(['verified' => true, 'phone' => $phone]);
    }

    private function purpose(Request $request): string
    {
        return 'service.'.$request->attributes->get('max_service_client');
    }
}
