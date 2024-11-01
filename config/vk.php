<?php

return [
    'app_id' => env('VK_APP_ID'),
    'secret_key' => env('VK_SECRET_KEY'),
    'callback' => env('VK_REDIRECT_URI','https://stn.local/callback/vk'),
];
