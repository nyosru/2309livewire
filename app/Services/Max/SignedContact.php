<?php

namespace App\Services\Max;

use Illuminate\Validation\ValidationException;

class SignedContact
{
    public function phone(array $payload, string $senderId): ?string
    {
        $vcf = $payload['vcf_info'] ?? null;
        $signature = $payload['hash'] ?? null;
        $token = app(MaxSettings::class)->get('bot_token');
        $contactId = data_get($payload, 'max_info.user_id');
        if (! is_string($vcf) || strlen($vcf) > 16384 || ! is_string($signature)
            || ! is_string($token) || $token === '' || ! is_scalar($contactId) || (string) $contactId !== $senderId) {
            return null;
        }
        // MAX may encode CRLF as literal escape sequences inside the vCard.
        $vcf = str_replace('\\r\\n', "\r\n", $vcf);
        $expected = hash_hmac('sha256', $vcf, $token, true);
        if (! hash_equals(bin2hex($expected), strtolower($signature)) && ! hash_equals(base64_encode($expected), $signature)) {
            return null;
        }
        preg_match_all('/^TEL(?:;[^:\r\n]*)?:([^\r\n]+)\r?$/mi', $vcf, $matches);
        if (count($matches[1]) !== 1) {
            return null;
        }
        try {
            return PhoneNumber::normalize(trim($matches[1][0]));
        } catch (ValidationException) {
            return null;
        }
    }
}
