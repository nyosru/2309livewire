<?php

return [
    'bot_token' => env('MAX_BOT_TOKEN'),
    'ca_bundle' => env('MAX_CA_BUNDLE'),
    'bot_username' => env('MAX_BOT_USERNAME'),
    'webhook_secret' => env('MAX_WEBHOOK_SECRET'),
    'webhook_url' => env('MAX_WEBHOOK_URL'),
    // Enable only when authorization messages are covered by your agreement with MAX.
    'auth_driver' => env('MAX_AUTH_DRIVER', 'disabled'),
    'code_ttl_seconds' => 300,
    'max_attempts' => 5,
    'resend_seconds' => 60,
    'phone_requests_per_hour' => 5,
    'ip_requests_per_minute' => 10,
    // Optional server-to-server clients: {"project-name":"a-long-random-secret"}.
    'service_clients' => json_decode(env('MAX_AUTH_SERVICE_CLIENTS', '{}'), true) ?: [],
];
