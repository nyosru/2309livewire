<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VkManagerContact;
use App\Services\VkManagerHistoryService;
use App\Services\VkManagerSnapshotSyncService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class VkManagerController extends Controller
{
    public function login(): View|RedirectResponse
    {
        return Auth::check() ? redirect('/') : view('vk_manager.login');
    }

    public function startAuth(Request $request): RedirectResponse
    {
        $secret = config('services.vk_external_auth.secret');
        if (! is_string($secret) || $secret === '') {
            return redirect('/login')->with('error', 'Авторизация через ПроцессМастер.рф не настроена.');
        }

        $state = bin2hex(random_bytes(32));
        // The Master API requires an HTTPS callback.
        $returnUrl = secure_url('/auth/master/callback');
        $request->session()->put('vk_manager_master_auth_state', $state);
        $request->session()->put('vk_manager_master_auth_return_url', $returnUrl);

        try {
            $response = Http::acceptJson()
                ->withHeaders(['X-VK-Auth-Secret' => $secret])
                ->timeout(10)
                ->post(rtrim(config('services.vk_external_auth.base_url'), '/').'/api/vk/auth/requests', [
                    'return_url' => $returnUrl,
                    'state' => $state,
                    'include_vk_token' => true,
                ]);
        } catch (ConnectionException) {
            return redirect('/login')->with('error', 'Сервис ПроцессМастер.рф временно недоступен. Попробуйте позже.');
        }

        if (! $response->successful() || ! is_string($response->json('authorization_url'))) {
            return redirect('/login')->with('error', 'Не удалось начать вход через ПроцессМастер.рф. Попробуйте ещё раз.');
        }

        return redirect()->away($response->json('authorization_url'));
    }

    public function callback(
        Request $request,
        VkManagerHistoryService $history,
        VkManagerSnapshotSyncService $snapshotSync,
    ): RedirectResponse {
        $expectedState = $request->session()->pull('vk_manager_master_auth_state');
        $returnUrl = $request->session()->pull('vk_manager_master_auth_return_url');
        $state = $request->query('state');

        if (! is_string($expectedState) || ! is_string($returnUrl) || ! is_string($state) || ! hash_equals($expectedState, $state)) {
            return redirect('/login')->with('error', 'Сеанс входа истёк или не прошёл проверку. Начните вход заново.');
        }

        if ($request->filled('error')) {
            return redirect('/login')->with('error', 'Вход через ВКонтакте был отменён или завершился ошибкой.');
        }

        $code = $request->query('code');
        $secret = config('services.vk_external_auth.secret');
        if (! is_string($code) || ! is_string($secret) || $secret === '') {
            return redirect('/login')->with('error', 'Не удалось подтвердить вход. Начните его заново.');
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
            return redirect('/login')->with('error', 'Сервис ПроцессМастер.рф временно недоступен. Начните вход заново позже.');
        }

        if (! $response->successful()) {
            logger()->warning('VK external auth exchange failed', ['status' => $response->status()]);

            $message = match ($response->status()) {
                403 => 'Мастер отклонил серверную авторизацию. Проверьте общий VK_EXTERNAL_AUTH_SECRET в настройках сайтов.',
                410 => 'Ссылка входа истекла или уже использована. Запустите вход через VK заново.',
                429 => 'Слишком много попыток входа. Подождите немного и начните заново.',
                default => 'Мастер не подтвердил вход (ошибка '.$response->status().'). Запустите вход через VK заново.',
            };

            return redirect('/login')->with('error', $message);
        }

        $identity = $response->json('user');
        if (! is_array($identity) || ! filled($identity['vk_id'] ?? null)) {
            logger()->warning('VK external auth exchange returned no user identity');

            return redirect('/login')->with('error', 'Мастер не вернул данные аккаунта. Начните вход заново.');
        }

        if (! filled($identity['access_token'] ?? null)) {
            logger()->warning('VK external auth exchange returned no VK access token');

            return redirect('/login')->with('error', 'Мастер не вернул токен VK. Запустите новую авторизацию и подтвердите доступ к друзьям.');
        }

        $vkId = (string) $identity['vk_id'];
        $user = User::query()->where('vk_id', $vkId)->first();
        if (! $user) {
            $user = User::create([
                'name' => (string) ($identity['name'] ?? 'Пользователь ВКонтакте'),
                'email' => 'vk-'.$vkId.'@external.processmaster.local',
                'password' => Str::password(40),
                'vk_id' => $vkId,
                'vk_token' => $identity['access_token'],
            ]);
        } else {
            $user->update([
                'name' => (string) ($identity['name'] ?? $user->name),
                'vk_token' => $identity['access_token'],
            ]);
        }

        $historyMessage = null;
        $historyError = null;
        $account = $history->ensureAccount($user);
        if (! $account->last_full_sync_at) {
            try {
                $snapshot = $snapshotSync->sync($user, 'initial_authorization');
                $historyMessage = sprintf(
                    'Первичная история VK загружена: %d друзей и %d подписчиков.',
                    $snapshot['friends'],
                    $snapshot['followers'],
                );
            } catch (Throwable $exception) {
                logger()->warning('Initial VK history synchronization failed', [
                    'user_id' => $user->getKey(),
                    'exception' => $exception::class,
                ]);
                $historyError = 'Вход выполнен, но полную историю списков VK загрузить не удалось. Попробуйте кнопку «Обновить состояние» в разделе «Данные в БД».';
            }
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        $redirect = redirect('/');
        if ($historyMessage) {
            $redirect->with('status', $historyMessage);
        }
        if ($historyError) {
            $redirect->with('error', $historyError);
        }

        return $redirect;
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function index(Request $request): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        return view('vk_manager.index', [
            'apiError' => null,
            'needsVkReconnect' => false,
        ]);
    }

    public function favorite(Request $request, int $vkFriendId): RedirectResponse|JsonResponse
    {
        $isFavorite = $request->boolean('is_favorite');
        $this->saveContact($vkFriendId, ['is_favorite' => $isFavorite]);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'is_favorite' => $isFavorite]);
        }

        return back()->with('status', 'Отметка избранного сохранена.');
    }

    public function comment(Request $request, int $vkFriendId): RedirectResponse
    {
        $data = $request->validate(['comment' => ['nullable', 'string', 'max:2000']]);
        $this->saveContact($vkFriendId, ['comment' => $data['comment'] ?? null]);

        return back()->with('status', 'Комментарий сохранён.');
    }

    private function saveContact(int $vkFriendId, array $attributes): VkManagerContact
    {
        return VkManagerContact::query()->updateOrCreate(
            ['user_id' => Auth::id(), 'vk_friend_id' => $vkFriendId],
            $attributes,
        );
    }

    private function vk(string $token, string $method, array $parameters = []): array
    {
        $response = Http::asForm()->post("https://api.vk.com/method/{$method}", array_merge($parameters, [
            'access_token' => $token,
            'v' => config('services.vk.api_version', '5.199'),
        ]));

        return $response->json() ?? ['error' => ['error_msg' => 'VK API недоступен']];
    }
}
