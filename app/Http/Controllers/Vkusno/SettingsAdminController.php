<?php

namespace App\Http\Controllers\Vkusno;

use App\Http\Controllers\Controller;
use App\Models\ApplicationSetting;
use App\Services\Max\MaxSettings;
use App\Services\Vkusno\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SettingsAdminController extends Controller
{
    public function edit(SiteSettings $site, MaxSettings $max)
    {
        $bot = $max->all();

        return view('vkusno.admin.settings', [
            'settings' => $site->all(),
            'bot' => collect($bot)->except(['bot_token', 'webhook_secret'])->all(),
            'tokenConfigured' => filled($bot['bot_token']),
            'secretConfigured' => filled($bot['webhook_secret']),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:500'],
            'hours' => ['required', 'string', 'max:200'],
            'timezone' => ['required', 'timezone'],
            'map_url' => ['nullable', 'url:http,https', 'max:2048'],
            'directions_url' => ['nullable', 'url:http,https', 'max:2048'],
            'photos_url' => ['nullable', 'url:http,https', 'max:2048'],
            'seats' => ['required', 'integer', 'min:1', 'max:10000'],
            'demo_menu' => ['required', 'boolean'],
            'delivery_fee' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'cake_lead_days' => ['required', 'integer', 'min:0', 'max:365'],
            'fillings_text' => ['required', 'string', 'max:5000'],
            'max_bot_username' => ['nullable', 'string', 'regex:/^[A-Za-z0-9_]+$/D', 'max:100'],
            'max_bot_token' => ['nullable', 'string', 'max:1024'],
            'max_webhook_secret' => ['nullable', 'string', 'regex:/^[A-Za-z0-9_-]{5,256}$/D'],
            'max_webhook_url' => ['nullable', 'url:https', 'max:2048'],
            'max_auth_driver' => ['required', Rule::in(['disabled', 'bot'])],
        ]);
        $fillings = array_values(array_unique(array_filter(array_map('trim', preg_split('/\R/u', $data['fillings_text'])))));
        if (! $fillings || count($fillings) > 50 || collect($fillings)->contains(fn ($value) => mb_strlen($value) > 100)) {
            throw ValidationException::withMessages(['fillings_text' => 'Укажите от 1 до 50 начинок, каждую с новой строки, не длиннее 100 символов.']);
        }
        DB::transaction(function () use ($data, $fillings) {
            $site = ApplicationSetting::whereKey('vkusno')->lockForUpdate()->firstOrFail();
            $max = ApplicationSetting::whereKey('max')->lockForUpdate()->firstOrFail();
            $bot = array_replace($max->values, [
                'bot_username' => $data['max_bot_username'] ?? null,
                'webhook_url' => $data['max_webhook_url'] ?? null,
                'auth_driver' => $data['max_auth_driver'],
            ]);
            foreach (['bot_token', 'webhook_secret'] as $key) {
                if (filled($data['max_'.$key] ?? null)) {
                    $bot[$key] = $data['max_'.$key];
                }
            }
            if ($bot['auth_driver'] === 'bot' && (! filled($bot['bot_token']) || ! filled($bot['bot_username']))) {
                throw ValidationException::withMessages(['max_auth_driver' => 'Для входа через MAX укажите имя бота и токен.']);
            }
            $values = array_replace(array_fill_keys(SiteSettings::KEYS, null), collect($data)->only(SiteSettings::KEYS)->all());
            foreach (['seats', 'cake_lead_days'] as $key) {
                $values[$key] = (int) $values[$key];
            }
            $values['delivery_fee'] = isset($values['delivery_fee']) ? (int) $values['delivery_fee'] : null;
            $values['demo_menu'] = (bool) $values['demo_menu'];
            $values['fillings'] = $fillings;
            $site->update(['values' => $values]);
            $max->update(['values' => $bot]);
        });

        return redirect('/admin/settings')->with('status', 'Настройки сохранены.');
    }
}
