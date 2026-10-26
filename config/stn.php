<?php

return [

    /*
    |--------------------------------------------------------------------------
    | STN API
    |--------------------------------------------------------------------------
    |
    | Ключ защищает mutating-эндпоинты (store/update/destroy/media). Если ключ
    | не задан — записи разрешены (удобно для локальной разработки). В продакшне
    | ОБЯЗАТЕЛЬНО задайте STN_API_KEY в .env.
    |
    */
    'api_key' => env('STN_API_KEY'),

    /*
    | Диск для хранения загруженных фото/обложек видео.
    */
    'media_disk' => env('STN_MEDIA_DISK', 'public'),

    /*
    | Пагинация списка новостей.
    */
    'default_per_page' => (int) env('STN_API_PER_PAGE', 20),
    'max_per_page' => (int) env('STN_API_MAX_PER_PAGE', 100),

    /*
    | Допустимые типы медиа и провайдеры видео.
    */
    'media' => [
        'types' => ['photo', 'video'],
        'providers' => ['youtube', 'vk', 'vimeo', 'rutube', 'dzen', 'tiktok', 'other'],
    ],

];
