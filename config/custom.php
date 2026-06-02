<?php

$e = [

    'BOT_TELEGA_ORDER' => env('BOT_TELEGA_ORDER'),
    'TELEGRAM_BOT_ORDER_TOKEN' => env('TELEGRAM_BOT_ORDER_TOKEN'),
    'BOT_TELEGA_TOKEN_URALWEBINFO' => env('BOT_TELEGA_TOKEN_URALWEBINFO'),

    'order_info' => env('ORDER_INFO'),
    'mf_client_info' => env('sea500MF_CLIENT_INFO'),
    'AI_HUGFACE_TOKEN' => env('AI_HUGFACE_TOKEN'),
    'YANDEX_OAUTH' => env('YANDEX_OAUTH'),
    'YANDEX_IAM' => env('YANDEX_IAM'),
    'BLOG_API_KEY' => env('BLOG_API_KEY'),

];

for ($i = 1; $i <= 10; $i++) {
    $e['REDIRECT_DOMAIN' . $i] = env('REDIRECT_DOMAIN' . $i , '' );
    $e['REDIRECT_DOMAIN' . $i . '_TO'] = env('REDIRECT_DOMAIN' . $i . '_TO' , '');
}

return $e;
