<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'vkontakte' => [
        'client_id' => env('VKONTAKTE_CLIENT_ID'),
        'client_secret' => env('VKONTAKTE_CLIENT_SECRET'),
        'redirect' => env('VKONTAKTE_REDIRECT_URI'),
    ],

    'vk' => [
        'client_id' => env('VK_CLIENT_ID'),
        'client_secret' => env('VK_CLIENT_SECRET'),
        'redirect' => env('VK_REDIRECT_URI'),

        'api_version' => env('VK_API_VERSION', '5.199'),
        'token_order' => env('VK_BOT_TOKEN_ORDER'),
        'vk_admin_id' => env('VK_ADMIN_ID'),

        'bot_token' => env('VK_BOT_TOKEN'),
        'confirmation_code' => env('VK_CONFIRMATION_CODE', ''),
        'group_tokens' => (static function (): array {
            $raw = env('VK_GROUP_TOKENS', '{}');
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : [];
        })(),

    ],

    'gigachat' => [
        'client_id' => env('GIGACHAT_CLIENT_ID'),
        'client_secret' => env('GIGACHAT_CLIENT_SECRET'),
        'auth_url' => 'https://ngw.devices.sberbank.ru:9443/api/v2/oauth',
        //        'api_url' => 'https://gigachat.devices.sberbank.ru/api/v1/chat/completions',
        'api_url' => 'https://gigachat.devices.sberbank.ru/api/v1/models',
    ],

    'nominatim' => [
        'url' => env('NOMINATIM_URL', 'https://nominatim.openstreetmap.org'),
    ],

];
