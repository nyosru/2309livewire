<?php

namespace App\Services;

use App\Models\User;
use App\Models\VkManagerAccount;
use App\Models\VkManagerContact;
use App\Models\VkManagerInvitationAttempt;
use App\Models\VkManagerInvitationAttempt;
use App\Models\VkManagerMembership;
use App\Models\VkManagerPerson;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class VkManagerInvitationService
{
    public function __construct(private readonly VkManagerHistoryService $history) {}

    /** @return array<int, array<string, mixed>> */
    public function findCandidates(User $owner, array $filters): array
    {
        $token = $this->token($owner);
        $cityId = filled($filters['city'] ?? null) ? $this->findCityId($token, trim($filters['city'])) : null;
        if (filled($filters['city'] ?? null) && $cityId === null) {
            throw new RuntimeException('VK не нашёл город «'.trim($filters['city']).'».');
        }

        $account = $this->history->ensureAccount($owner);
        $personIds = VkManagerMembership::query()
            ->where('account_id', $account->getKey())
            ->where('is_current', true)
            ->pluck('person_id');
        $excludedIds = $personIds->isEmpty()
            ? []
            : VkManagerPerson::query()->whereIn('id', $personIds)->pluck('vk_id')->map(fn ($id) => (string) $id)->all();
        $knownContactIds = VkManagerContact::query()
            ->where('user_id', $owner->getKey())
            ->pluck('vk_friend_id')
            ->map(fn ($id) => (string) $id)
            ->all();
        $pendingAttemptIds = VkManagerInvitationAttempt::query()
            ->where('user_id', $owner->getKey())
            ->whereNull('resolved_at')
            ->pluck('vk_id')
            ->map(fn ($id) => (string) $id)
            ->all();
        $excludedIds = array_fill_keys(array_merge($excludedIds, $knownContactIds, $pendingAttemptIds, [(string) $owner->vk_id]), true);
        $found = [];

        for ($offset = 0; $offset < 1000 && count($found) < 50; $offset += 100) {
            $params = [
                'count' => 100,
                'offset' => $offset,
                'fields' => 'photo_100,sex,bdate,city,domain,screen_name',
                'sort' => 0,
            ];
            if ($cityId !== null) $params['city'] = $cityId;
            if (filled($filters['sex'] ?? null)) $params['sex'] = (int) $filters['sex'];
            if (filled($filters['age_from'] ?? null)) $params['age_from'] = (int) $filters['age_from'];
            if (filled($filters['age_to'] ?? null)) $params['age_to'] = (int) $filters['age_to'];

            $payload = $this->api($token, 'users.search', $params);
            $items = data_get($payload, 'response.items', []);
            foreach ($items as $person) {
                $id = (string) ($person['id'] ?? '');
                if ($id === '' || isset($excludedIds[$id])) continue;
                $found[$id] = $person;
                if (count($found) >= 50) break;
            }
            if (count($items) < 100 || (int) data_get($payload, 'response.count', 0) <= $offset + 100) break;
        }

        return array_values($found);
    }

    public function invite(User $owner, string $vkId, array $profile = []): string
    {
        $id = filter_var($vkId, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (! $id) throw new RuntimeException('Некорректный VK ID.');
        $token = $this->token($owner);
        $account = $this->history->ensureAccount($owner);
        $personId = VkManagerPerson::query()->where('vk_id', $vkId)->value('id');
        $alreadyInCurrentList = $personId && VkManagerMembership::query()
            ->where('account_id', $account->getKey())
            ->where('person_id', $personId)
            ->where('is_current', true)
            ->exists();
        $alreadyKnownForOwner = VkManagerContact::query()
            ->where('user_id', $owner->getKey())
            ->where('vk_friend_id', $vkId)
            ->exists();
        if ($alreadyInCurrentList || $alreadyKnownForOwner) {
            throw new RuntimeException('Этот аккаунт уже числится в одном из ваших списков.');
        }

        $result = (int) data_get($this->api($token, 'friends.add', [
            'user_id' => $id,
            'source' => 'friends_search',
        ]), 'response', 0);
        if ($result === 4) throw new RuntimeException('VK сообщил, что пользователь отклонил заявку.');
        $status = $result === 2 ? VkManagerMembership::STATUS_FRIEND : VkManagerMembership::STATUS_OUTGOING_REQUEST;
        $this->history->recordChange($owner, $vkId, $status, $profile, 'outgoing_invitation');
        VkManagerInvitationAttempt::query()
            ->where('user_id', $owner->getKey())
            ->where('vk_id', $vkId)
            ->whereNull('resolved_at')
            ->update(['resolved_at' => now()]);

        return $status;
    }

    private function findCityId(string $token, string $city): ?int
    {
        $payload = $this->api($token, 'database.getCities', ['country_id' => 1, 'q' => $city, 'count' => 1000]);
        $items = data_get($payload, 'response.items', []);
        foreach ($items as $item) {
            if (mb_strtolower(trim((string) ($item['title'] ?? ''))) === mb_strtolower($city)) return (int) $item['id'];
        }
        return isset($items[0]['id']) ? (int) $items[0]['id'] : null;
    }

    private function token(User $owner): string
    {
        if (! filled($owner->vk_token)) throw new RuntimeException('Не найден токен VK. Подключите аккаунт заново.');
        return (string) $owner->vk_token;
    }

    private function api(string $token, string $method, array $params): array
    {
        $url = 'https://api.vk.com/method/'.$method;
        if ($method === 'friends.add' && filled(config('services.vk.client_id'))) {
            $url .= '?client_id='.rawurlencode((string) config('services.vk.client_id'));
        }

        $response = Http::asForm()->timeout(20)->post($url, $params + [
            'access_token' => $token,
            'v' => config('services.vk.api_version', '5.199'),
        ]);
        if (! $response->successful()) throw new RuntimeException('VK временно недоступен (HTTP '.$response->status().').');
        $payload = $response->json();
        if (! is_array($payload)) throw new RuntimeException('VK вернул некорректный ответ.');
        if (isset($payload['error'])) {
            $code = (int) data_get($payload, 'error.error_code', 0);
            $message = (string) data_get($payload, 'error.error_msg', 'ошибка VK API');
            if (in_array($code, [5, 7], true)) $message = 'Токен VK не имеет нужного доступа или истёк. Подключите аккаунт заново.';
            if ($method === 'friends.add' && $code === 3) $message = 'VK отклонил метод отправки заявки для этого приложения или токена. Проверьте, что VK_CLIENT_ID совпадает с приложением, через которое получен токен; если совпадает, это ограничение VK API для данного токена.';
            throw new RuntimeException('VK API '.$code.': '.$message);
        }
        return $payload;
    }
}
