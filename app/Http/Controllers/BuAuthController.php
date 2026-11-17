<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BuAuthController extends Controller
{
    public function login(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $error = $request->session()->get('error');

        return view('bu.auth.vk-login', compact('error'));
    }

    public function startAuth(Request $request): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect('/');
        }

        $host = strtolower($request->getHost());
        $expectedHost = app()->environment('local', 'testing') ? 'bu.local' : 'bu72.ru';
        if ($host !== $expectedHost) {
            abort(400, 'Не удалось подтвердить домен сайта для входа.');
        }

        $error = null;
        $secret = config('services.vk_external_auth.secret');
        $baseUrl = config('services.vk_external_auth.base_url');

        if (! is_string($secret) || $secret === '' || ! is_string($baseUrl) || $baseUrl === '') {
            $error = 'Авторизация через ПроцессМастер.рф не настроена.';
        } else {
            $state = bin2hex(random_bytes(32));
            $returnUrl = 'https://'.$host.'/auth/master/callback';
            $request->session()->put('bu_master_auth_state', $state);
            $request->session()->put('bu_master_auth_return_url', $returnUrl);

            try {
                $response = Http::acceptJson()
                    ->asJson()
                    ->withHeaders(['X-VK-Auth-Secret' => $secret])
                    ->timeout(10)
                    ->post(rtrim($baseUrl, '/').'/api/vk/auth/requests', [
                        'return_url' => $returnUrl,
                        'state' => $state,
                    ]);

                $candidateUrl = $response->json('authorization_url');
                $candidate = is_string($candidateUrl) ? parse_url($candidateUrl) : false;
                $master = parse_url($baseUrl);

                if ($response->successful()
                    && is_array($candidate)
                    && strtolower($candidate['scheme'] ?? '') === 'https'
                    && strtolower($candidate['host'] ?? '') === strtolower($master['host'] ?? '')
                    && ! isset($candidate['user'])
                    && ! isset($candidate['pass'])) {
                    return redirect()->away($candidateUrl);
                } else {
                    $error = 'Не удалось начать вход через ПроцессМастер.рф. Обновите страницу и попробуйте ещё раз.';
                }
            } catch (ConnectionException) {
                $error = 'Сервис ПроцессМастер.рф временно недоступен. Попробуйте позже.';
            }
        }

        return view('bu.auth.vk-login', compact('error'));
    }

    public function callback(Request $request): RedirectResponse
    {
        $expectedState = $request->session()->pull('bu_master_auth_state');
        $returnUrl = $request->session()->pull('bu_master_auth_return_url');
        $host = strtolower($request->getHost());
        $expectedHost = app()->environment('local', 'testing') ? 'bu.local' : 'bu72.ru';
        $expectedReturnUrl = 'https://'.$host.'/auth/master/callback';

        if ($host !== $expectedHost
            || ! is_string($expectedState)
            || ! is_string($returnUrl)
            || ! hash_equals($expectedReturnUrl, $returnUrl)
            || ! is_string($request->query('state'))
            || ! hash_equals($expectedState, $request->query('state'))) {
            return redirect('/login')->with('error', 'Сеанс входа истёк или вернулся на другой домен. Начните вход заново.');
        }

        if ($request->filled('error')) {
            return redirect('/login')->with('error', 'Вход через ВКонтакте был отменён или завершился ошибкой.');
        }

        $code = $request->query('code');
        $secret = config('services.vk_external_auth.secret');
        $baseUrl = config('services.vk_external_auth.base_url');
        if (! is_string($code) || $code === '' || ! is_string($secret) || $secret === '' || ! is_string($baseUrl)) {
            return redirect('/login')->with('error', 'Не удалось подтвердить вход. Начните его заново.');
        }

        try {
            $response = Http::acceptJson()
                ->asJson()
                ->withHeaders(['X-VK-Auth-Secret' => $secret])
                ->timeout(10)
                ->post(rtrim($baseUrl, '/').'/api/vk/auth/exchange', [
                    'code' => $code,
                    'return_url' => $returnUrl,
                ]);
        } catch (ConnectionException) {
            return redirect('/login')->with('error', 'Сервис ПроцессМастер.рф временно недоступен. Начните вход заново позже.');
        }

        $identity = $response->json('user');
        if (! $response->successful()) {
            $message = match ($response->status()) {
                403 => 'Сервис авторизации отклонил запрос. Проверьте серверную настройку секрета.',
                410 => 'Ссылка входа истекла или уже использована. Начните вход заново.',
                422 => 'Сервис авторизации отклонил параметры запроса. Начните вход заново.',
                429 => 'Слишком много попыток входа. Подождите немного и попробуйте снова.',
                default => 'Не удалось подтвердить вход. Начните его заново.',
            };

            return redirect('/login')->with('error', $message);
        }

        if (! is_array($identity)
            || ! is_string($identity['vk_id'] ?? null)
            || ! preg_match('/\\A[0-9]{1,20}\\z/', $identity['vk_id'])) {
            return redirect('/login')->with('error', 'Ссылка входа истекла или уже использована. Начните вход заново.');
        }

        $vkId = (string) $identity['vk_id'];
        $user = User::query()->where('vk_id', $vkId)->first();
        if (! $user) {
            $user = User::create([
                'name' => is_string($identity['name'] ?? null) && $identity['name'] !== ''
                    ? $identity['name']
                    : 'Пользователь ВКонтакте',
                'email' => 'vk-'.$vkId.'@external.processmaster.local',
                'password' => Str::password(40),
                'vk_id' => $vkId,
            ]);
        } elseif (is_string($identity['name'] ?? null) && $identity['name'] !== '') {
            $user->update(['name' => $identity['name']]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect('/cabinet');
    }
}
