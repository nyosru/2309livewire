<?php

namespace App\Services\Max;

use App\Models\ApplicationSetting;

class MaxSettings
{
    public const KEYS = ['bot_token', 'bot_username', 'webhook_secret', 'webhook_url', 'auth_driver'];

    public function all(): array
    {
        return ApplicationSetting::findOrFail('max')->values;
    }

    public function get(string $key): mixed
    {
        return $this->all()[$key] ?? null;
    }
}
