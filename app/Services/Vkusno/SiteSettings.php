<?php

namespace App\Services\Vkusno;

use App\Models\ApplicationSetting;

class SiteSettings
{
    public const KEYS = ['phone', 'address', 'hours', 'timezone', 'map_url', 'directions_url', 'photos_url', 'seats', 'demo_menu', 'delivery_fee', 'cake_lead_days', 'fillings'];

    public function all(): array
    {
        return ApplicationSetting::findOrFail('vkusno')->values;
    }

    public function get(string $key): mixed
    {
        return $this->all()[$key] ?? null;
    }
}
