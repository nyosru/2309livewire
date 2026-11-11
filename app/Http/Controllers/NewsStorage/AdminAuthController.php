<?php

namespace App\Http\Controllers\NewsStorage;

use App\Http\Controllers\Controller;
use App\Models\NewsStorageAdministrator;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function login()
    {
        $access = Auth::check()
            ? NewsStorageAdministrator::query()->where('user_id', Auth::id())->first()
            : null;

        if ($access?->canModerate()) {
            return redirect('/admin');
        }

        return view('news_storage.admin.login', [
            'access' => $access,
        ]);
    }

    public function redirect(Request $request): RedirectResponse
    {
        $secret = config('services.vk_external_auth.secret');
        if (! is_string($secret) || $secret === '') {
            return redirect('/admin/login')->with('error', 'Внешняя авторизация через Процесс Мастер не настроена.');
        }

        $state = bin2hex(random_bytes(32));
        $returnUrl = url('/admin/auth/master/callback');
        $request->session()->put('news_storage_master_auth_state', $state);
        $request->session()->put('news_storage_master_auth_return_url', $returnUrl);

        try {
            $response = Http::acceptJson()
                ->withHeaders(['X-VK-Auth-Secret' => $secret])
                ->timeout(10)
                ->post(rtrim(config('services.vk_external_auth.base_url'), '/').'/api/vk/auth/requests', [
                    'return_url' => $returnUrl,
                    'state' => $state,
                ]);
        } catch (ConnectionException) {
            return redirect('/admin/login')->with('error', 'Сервис авторизации временно недоступен. Попробуйте позже.');
        }

        if (! $response->successful() || ! is_string($response->json('authorization_url'))) {
            return redirect('/admin/login')->with('error', 'Не удалось начать вход через ВКонтакте. Попробуйте ещё раз.');
        }

        return redirect()->away($response->json('authorization_url'));
    }

    public function callback(Request $request): RedirectResponse
    {
        $expectedState = $request->session()->pull('news_storage_master_auth_state');
        $returnUrl = $request->session()->pull('news_storage_master_auth_return_url');
        $state = $request->query('state');

        if (! is_string($expectedState) || ! is_string($returnUrl) || ! is_string($state) || ! hash_equals($expectedState, $state)) {
            return redirect('/admin/login')->with('error', 'Сеанс входа истёк или не прошёл проверку. Начните вход заново.');
        }

        if ($request->filled('error')) {
            return redirect('/admin/login')->with('error', 'Вход через ВКонтакте был отменён или завершился ошибкой.');
        }

        $code = $request->query('code');
        $secret = config('services.vk_external_auth.secret');
        if (! is_string($code) || ! is_string($secret) || $secret === '') {
            return redirect('/admin/login')->with('error', 'Не удалось подтвердить вход. Начните его заново.');
        }

        try {
            $response = Http::acceptJson()
                ->withHeaders(['X-VK-Auth-Secret' => $secret])
                ->timeout(10)
                ->post(rtrim(config('services.vk_external_auth.base_url'), '/').'/api/vk/auth/exchange', [
                    'code' => $code,
                    'return_url' => $returnUrl,
                ]);
        } catch (ConnectionException) {
            return redirect('/admin/login')->with('error', 'Сервис авторизации временно недоступен. Начните вход заново позже.');
        }

        $identity = $response->json('user');
        if (! $response->successful() || ! is_array($identity) || ! filled($identity['vk_id'] ?? null)) {
            return redirect('/admin/login')->with('error', 'Ссылка входа истекла или уже использована. Начните вход заново.');
        }

        $vkId = (string) $identity['vk_id'];
        $user = User::query()->where('vk_id', $vkId)->first();
        if (! $user) {
            // Не связываем чужой существующий аккаунт по email: доверяем только vk_id от Мастера.
            $user = User::create([
                'name' => (string) ($identity['name'] ?? 'Пользователь ВКонтакте'),
                'email' => 'vk-'.$vkId.'@external.processmaster.local',
                'password' => Str::password(40),
                'vk_id' => $vkId,
            ]);
        } else {
            $user->update(['name' => (string) ($identity['name'] ?? $user->name)]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        NewsStorageAdministrator::registerLogin($user);

        return redirect('/admin');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

}
