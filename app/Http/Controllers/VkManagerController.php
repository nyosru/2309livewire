<?php

namespace App\Http\Controllers;

use App\Models\VkManagerContact;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;

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

    public function callback(Request $request): RedirectResponse
    {
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

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect('/');
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
        if (! $user->vk_token || ! $user->vk_id) {
            return view('vk_manager.index', [
                'friends' => [], 'followers' => [], 'friendCount' => 0, 'followerCount' => 0,
                'apiError' => 'Для загрузки друзей и подписчиков нужно заново войти через VK и выдать доступ.',
                'needsVkReconnect' => true,
                'friendPage' => 1, 'friendPages' => 1, 'followerPage' => 1, 'followerPages' => 1,
            ]);
        }

        $perPage = 200;
        $friendPage = max(1, min(50000, (int) $request->query('friends_page', 1)));
        $followerPage = max(1, min(50000, (int) $request->query('followers_page', 1)));
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

        $friends = data_get($friendsResponse, 'response.items', []);
        $followers = data_get($followersResponse, 'response.items', []);
        if (! is_array($friends) || ! is_array($followers)) {
            return view('vk_manager.index', [
                'friends' => [], 'followers' => [], 'friendCount' => 0, 'followerCount' => 0,
                'comments' => [], 'favorites' => [], 'apiError' => 'VK не разрешил получить списки. Переподключите аккаунт и разрешите доступ к друзьям.',
                'needsVkReconnect' => false,
                'friendPage' => $friendPage, 'friendPages' => 1, 'followerPage' => $followerPage, 'followerPages' => 1,
            ]);
        }

        $ids = collect($friends)->merge($followers)->pluck('id')->map(fn ($id) => (int) $id)->unique();
        $metadata = VkManagerContact::query()->where('user_id', $user->id)->whereIn('vk_friend_id', $ids)->get()->keyBy('vk_friend_id');
        foreach (['friends', 'followers'] as $listName) {
            foreach ($$listName as &$person) {
                $contact = $metadata->get($person['id']);
                $person['manager_comment'] = $contact?->comment;
                $person['manager_favorite'] = $contact?->is_favorite ?? false;
            }
            unset($person);
        }

        $friendCount = (int) data_get($friendsResponse, 'response.count', count($friends));
        $followerCount = (int) data_get($followersResponse, 'response.count', count($followers));

        return view('vk_manager.index', [
            'friends' => $friends,
            'followers' => $followers,
            'friendCount' => $friendCount,
            'followerCount' => $followerCount,
            'friendPage' => $friendPage,
            'friendPages' => max(1, (int) ceil($friendCount / $perPage)),
            'followerPage' => $followerPage,
            'followerPages' => max(1, (int) ceil($followerCount / $perPage)),
            'apiError' => data_get($friendsResponse, 'error.error_msg') ?? data_get($followersResponse, 'error.error_msg'),
            'needsVkReconnect' => false,
        ]);
    }

    public function favorite(int $vkFriendId): RedirectResponse
    {
        $this->saveContact($vkFriendId, ['is_favorite' => request()->boolean('is_favorite')]);

        return back()->with('status', 'Отметка избранного сохранена.');
    }

    public function comment(Request $request, int $vkFriendId): RedirectResponse
    {
        $data = $request->validate(['comment' => ['nullable', 'string', 'max:2000']]);
        $this->saveContact($vkFriendId, ['comment' => $data['comment'] ?? null]);

        return back()->with('status', 'Комментарий сохранён.');
    }

    public function removeFriends(Request $request): RedirectResponse
    {
        $data = $request->validate(['friends' => ['required', 'array', 'min:1'], 'friends.*' => ['required', 'integer', 'min:1']]);
        $user = Auth::user();
        $wantedIds = array_values(array_unique(array_map('intval', $data['friends'])));
        $currentIds = [];
        $offset = 0;
        $totalFriends = 0;

        do {
            $current = $this->vk($user->vk_token, 'friends.get', [
                'user_id' => $user->vk_id,
                'count' => 1000,
                'offset' => $offset,
            ]);
            if (isset($current['error'])) {
                return back()->with('error', data_get($current, 'error.error_msg', 'VK не разрешил проверить список друзей.'));
            }

            $items = data_get($current, 'response.items', []);
            $totalFriends = (int) data_get($current, 'response.count', 0);
            $pageIds = collect($items)->map(fn ($friend) => is_array($friend) ? ($friend['id'] ?? null) : $friend)
                ->filter(fn ($id) => is_numeric($id))
                ->map(fn ($id) => (int) $id)
                ->all();
            $currentIds = array_merge($currentIds, $pageIds);
            $offset += count($pageIds);
        } while ($pageIds !== [] && $offset < $totalFriends && count(array_intersect($wantedIds, $currentIds)) < count($wantedIds));

        $selectedIds = array_values(array_intersect($wantedIds, $currentIds));
        if ($selectedIds === []) {
            return back()->with('error', 'Выбранные аккаунты не найдены в текущем списке друзей.');
        }
        $removed = 0;
        $errors = [];
        $firstVkError = null;
        foreach ($selectedIds as $id) {
            $response = $this->vk($user->vk_token, 'friends.delete', ['user_id' => $id]);
            if (isset($response['error'])) {
                $errorCode = data_get($response, 'error.error_code');
                $errorMessage = (string) data_get($response, 'error.error_msg', 'VK отклонил удаление.');
                $errors[] = $errorCode ? "VK API {$errorCode}: {$errorMessage}" : $errorMessage;
                if ($firstVkError === null) {
                    $requestParameters = collect(data_get($response, 'error.request_params', []))
                        ->reject(fn ($parameter) => in_array(data_get($parameter, 'key'), ['access_token', 'client_secret', 'code', 'state'], true))
                        ->values()
                        ->all();
                    $firstVkError = [
                        'method' => 'friends.delete',
                        'api_version' => config('services.vk.api_version', '5.199'),
                        'error_code' => $errorCode,
                        'error_message' => $errorMessage,
                        'request_parameters' => $requestParameters,
                    ];
                }
                continue;
            }

            $result = data_get($response, 'response');
            $friendDeleted = is_array($result)
                ? filter_var($result['friend_deleted'] ?? false, FILTER_VALIDATE_BOOLEAN)
                : (int) $result === 1;
            if ($friendDeleted) {
                $removed++;
            }
        }

        if ($removed > 0) {
            $message = "VK удалил из друзей: {$removed}. Удалённые аккаунты обычно становятся подписчиками.";
            if ($errors !== []) {
                $message .= ' Не удалось удалить ещё '.(count($selectedIds) - $removed).': '.implode(' ', array_unique($errors));
            }

            return back()->with('status', $message)->with('vk_error', $firstVkError);
        }

        return back()->with('error', $errors !== []
            ? implode(' ', array_unique($errors))
            : 'VK не подтвердил удаление. Возможно, выбранные аккаунты уже удалены из друзей.')
            ->with('vk_error', $firstVkError);
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
