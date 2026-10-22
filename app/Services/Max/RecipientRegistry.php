<?php

namespace App\Services\Max;

use App\Models\Max\Recipient;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RecipientRegistry
{
    public function __construct(private MaxService $max) {}

    public function register(string $phone, string $maxUserId): Recipient
    {
        $phone = PhoneNumber::normalize($phone);
        try {
            $this->max->validateUserId($maxUserId);
        } catch (\InvalidArgumentException) {
            throw ValidationException::withMessages(['max_user_id' => 'Введите числовой MAX ID, который пользователь получил у бота.']);
        }

        return DB::transaction(function () use ($phone, $maxUserId) {
            $existing = Recipient::where('phone', $phone)->orWhere('max_user_id', $maxUserId)->lockForUpdate()->first();
            if ($existing) {
                if ($existing->phone !== $phone || $existing->max_user_id !== $maxUserId) {
                    throw ValidationException::withMessages(['phone' => 'Этот телефон или MAX ID уже связан с другим получателем. Проверьте привязку.']);
                }

                return $existing;
            }

            return Recipient::create(['phone' => $phone, 'max_user_id' => $maxUserId]);
        });
    }
}
