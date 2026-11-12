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

        $user = Auth::user();
        $history = app(VkManagerHistoryService::class);
        $dbStats = $history->summary($user);
        if (! $user->vk_token || ! $user->vk_id) {
            return view('vk_manager.index', [
                'friends' => [], 'followers' => [], 'requests' => [],
                'friendCount' => 0, 'followerCount' => 0, 'requestCount' => 0,
                'apiError' => 'Для загрузки друзей и подписчиков нужно заново войти через VK и выдать доступ.',
                'needsVkReconnect' => true,
                'friendPage' => 1, 'friendPages' => 1, 'followerPage' => 1, 'followerPages' => 1,
                'requestPage' => 1, 'requestPages' => 1,
                'requestApiError' => null,
                'dbStats' => $dbStats,
            ]);
        }

        $perPage = 200;
        $friendPage = max(1, min(50000, (int) $request->query('friends_page', 1)));
        $followerPage = max(1, min(50000, (int) $request->query('followers_page', 1)));
        $requestPage = max(1, min(50000, (int) $request->query('requests_page', 1)));
        $friendsResponse = $this->vk($user->vk_token, 'friends.get', [
            'user_id' => $user->vk_id,
            'order' => 'hints',
            'count' => $perPage,
            'offset' => ($friendPage - 1) * $perPage,
            'fields' => 'photo_100,domain',
        ]);
        $followersResponse = $this->vk($user->vk_token, 'users.getFollowers', [
            'user_id' => $user->vk_id,
            'count' => $perPage,
            'offset' => ($followerPage - 1) * $perPage,
            'fields' => 'photo_100,domain',
        ]);
        $requestsResponse = $this->vk($user->vk_token, 'friends.getRequests', [
            'out' => 1,
            'extended' => 1,
            'count' => $perPage,
            'offset' => ($requestPage - 1) * $perPage,
            'fields' => 'photo_100,domain',
        ]);

        $friends = data_get($friendsResponse, 'response.items', []);
        $followers = data_get($followersResponse, 'response.items', []);
        $requests = data_get($requestsResponse, 'response.items', []);
        if (! is_array($requests)) {
            $requests = [];
        }
        $requests = array_values(array_filter(array_map(static function ($person) {
            if (is_int($person) || is_string($person)) {
                return ['id' => $person, 'first_name' => 'Пользователь', 'last_name' => ''];
            }
            if (! is_array($person)) {
                return null;
            }
            if (! isset($person['id']) && isset($person['user_id'])) {
                $person['id'] = $person['user_id'];
            }

            return $person;
        }, $requests)));
        $requestApiError = data_get($requestsResponse, 'error.error_msg');
        if (! is_array($friends) || ! is_array($followers)) {
            return view('vk_manager.index', [
                'friends' => [], 'followers' => [], 'requests' => [],
                'friendCount' => 0, 'followerCount' => 0, 'requestCount' => 0,
                'comments' => [], 'favorites' => [], 'apiError' => 'VK не разрешил получить списки. Переподключите аккаунт и разрешите доступ к друзьям.',
                'needsVkReconnect' => false,
                'friendPage' => $friendPage, 'friendPages' => 1, 'followerPage' => $followerPage, 'followerPages' => 1,
                'requestPage' => $requestPage, 'requestPages' => 1,
                'requestApiError' => $requestApiError,
                'dbStats' => $dbStats,
            ]);
        }

        $history->observeLists($user, $friends, $followers, 'vk_api_page', $requests);
        $dbStats = $history->summary($user);

        $ids = collect($friends)->merge($followers)->merge($requests)->pluck('id')->map(fn ($id) => (int) $id)->unique();
        $metadata = VkManagerContact::query()->where('user_id', $user->id)->whereIn('vk_friend_id', $ids)->get()->keyBy('vk_friend_id');
        foreach (['friends', 'followers', 'requests'] as $listName) {
            foreach ($$listName as &$person) {
                $contact = $metadata->get($person['id']);
                $person['manager_comment'] = $contact?->comment;
                $person['manager_favorite'] = $contact?->is_favorite ?? false;
            }
            unset($person);
        }

        $friendCount = (int) data_get($friendsResponse, 'response.count', count($friends));
        $followerCount = (int) data_get($followersResponse, 'response.count', count($followers));
        $requestCount = (int) data_get($requestsResponse, 'response.count', count($requests));

        return view('vk_manager.index', [
            'friends' => $friends,
            'followers' => $followers,
            'requests' => $requests,
            'friendCount' => $friendCount,
            'followerCount' => $followerCount,
            'requestCount' => $requestCount,
            'friendPage' => $friendPage,
            'friendPages' => max(1, (int) ceil($friendCount / $perPage)),
            'followerPage' => $followerPage,
            'followerPages' => max(1, (int) ceil($followerCount / $perPage)),
            'requestPage' => $requestPage,
            'requestPages' => max(1, (int) ceil($requestCount / $perPage)),
            'apiError' => data_get($friendsResponse, 'error.error_msg') ?? data_get($followersResponse, 'error.error_msg'),
            'requestApiError' => $requestApiError ?: null,
            'needsVkReconnect' => false,
            'dbStats' => $dbStats,
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
