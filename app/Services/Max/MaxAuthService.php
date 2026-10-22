<?php

namespace App\Services\Max;

use App\Models\Max\Recipient;
use App\Models\Max\Verification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class MaxAuthService
{
    public function __construct(private MaxService $max) {}

    public function configured(): bool
    {
        return config('max.auth_driver') === 'bot' && $this->max->configured();
    }

    public function begin(string $phone, string $purpose, string $browserToken, string $ip, bool $deliver = true, string $displayName = 'сервис'): Verification
    {
        $phone = PhoneNumber::normalize($phone);
        $this->validateContext($purpose, $browserToken);
        if (! $this->configured()) {
            throw new MaxAuthException('Вход через MAX пока не настроен.');
        }
        $phoneHash = hash('sha256', $phone);
        $lock = Cache::lock('max-auth:send-lock:'.$phoneHash, 30);
        if (! $lock->get()) {
            throw new TooManyRequestsHttpException(60, 'Код уже запрашивается. Повторите через минуту.');
        }
        try {
            $this->throttle('max-auth:phone:'.$phoneHash, 1, config('max.resend_seconds'));
            $this->throttle('max-auth:hour:'.$phoneHash, config('max.phone_requests_per_hour'), 3600);
            $this->throttle('max-auth:ip:'.hash('sha256', $ip), config('max.ip_requests_per_minute'), 60);
            $recipient = $deliver ? Recipient::where('phone', $phone)->first() : null;
            if ($deliver && ! $recipient) {
                throw new MaxAuthException('Откройте бота MAX, нажмите «Начать», затем «Поделиться телефоном». После подтверждения номера запросите код ещё раз.');
            }
            $code = (string) random_int(100000, 999999);
            $browserHash = hash('sha256', $browserToken);
            $expires = now()->addSeconds(config('max.code_ttl_seconds'));
            if ($recipient) {
                $this->max->sendToUser($recipient->max_user_id, 'Код входа в '.mb_substr($displayName, 0, 100).': '.$code."\nКод действует 5 минут. Никому его не сообщайте.");
            }

            return DB::transaction(function () use ($phone, $purpose, $browserHash, $recipient, $code, $expires) {
                Verification::where('phone', $phone)->where('purpose', $purpose)->where('status', 'pending')->update(['status' => 'superseded']);

                return Verification::create([
                    'id' => (string) Str::uuid(), 'phone' => $phone, 'purpose' => $purpose,
                    'browser_hash' => $browserHash, 'code_hash' => $recipient ? Hash::make($code) : null,
                    'code_length' => 6, 'expires_at' => $expires,
                ]);
            });
        } finally {
            $lock->release();
        }
    }

    /** Returns the verified phone once, or null for an invalid/expired/reused code. */
    public function confirm(string $id, string $purpose, string $browserToken, string $code): ?string
    {
        $this->validateContext($purpose, $browserToken);

        return DB::transaction(function () use ($id, $purpose, $browserToken, $code) {
            $verification = Verification::whereKey($id)->lockForUpdate()->first();
            if (! $verification || $verification->purpose !== $purpose
                || ! hash_equals($verification->browser_hash, hash('sha256', $browserToken))
                || $verification->status !== 'pending' || $verification->consumed_at) {
                return null;
            }
            if ($verification->expires_at->isPast() || $verification->attempts >= config('max.max_attempts')) {
                $verification->update(['status' => 'expired']);

                return null;
            }
            $verification->attempts++;
            $valid = preg_match('/^[0-9]{'.$verification->code_length.'}$/D', $code)
                && $verification->code_hash
                && Hash::check($code, $verification->code_hash);
            if (! $valid) {
                if ($verification->attempts >= config('max.max_attempts')) {
                    $verification->status = 'failed';
                }
                $verification->save();

                return null;
            }
            $verification->status = 'verified';
            $verification->consumed_at = now();
            $verification->save();

            return $verification->phone;
        });
    }

    private function throttle(string $key, int $limit, int $seconds): void
    {
        if (RateLimiter::tooManyAttempts($key, $limit)) {
            throw new TooManyRequestsHttpException(RateLimiter::availableIn($key), 'Слишком много запросов кода. Попробуйте позже.');
        }
        RateLimiter::hit($key, $seconds);
    }

    private function validateContext(string $purpose, string $browserToken): void
    {
        if (! preg_match('/^[a-zA-Z0-9_.:-]{1,100}$/D', $purpose) || strlen($browserToken) < 32 || strlen($browserToken) > 256) {
            throw new \InvalidArgumentException('MAX authentication requires a purpose and a random browser context of 32–256 characters.');
        }
    }
}
