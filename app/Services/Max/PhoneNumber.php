<?php

namespace App\Services\Max;

use Illuminate\Validation\ValidationException;

class PhoneNumber
{
    public static function normalize(string $phone): string
    {
        if (! preg_match('/^\+?[0-9\s()\-]{10,32}$/D', trim($phone))) {
            throw ValidationException::withMessages(['phone' => 'Введите российский мобильный номер, например +7 912 123-45-67.']);
        }
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) === 10) {
            $digits = '7'.$digits;
        } elseif (strlen($digits) === 11 && $digits[0] === '8') {
            $digits = '7'.substr($digits, 1);
        }
        if (! preg_match('/^79[0-9]{9}$/D', $digits)) {
            throw ValidationException::withMessages(['phone' => 'Поддерживаются российские мобильные номера +7 9XX XXX-XX-XX.']);
        }

        return '+'.$digits;
    }
}
