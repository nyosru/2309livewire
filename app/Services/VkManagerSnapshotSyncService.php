<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class VkManagerSnapshotSyncService
{
    private const PROFILE_FIELDS = [
        'first_name_nom', 'first_name_gen', 'first_name_dat', 'first_name_acc', 'first_name_ins', 'first_name_abl',
        'last_name_nom', 'last_name_gen', 'last_name_dat', 'last_name_acc', 'last_name_ins', 'last_name_abl',
        'nickname', 'screen_name', 'domain', 'maiden_name', 'verified', 'is_verified', 'photo_id', 'has_photo',
        'photo', 'photo_rec', 'photo_50', 'photo_100', 'photo_200_orig', 'photo_200', 'photo_400', 'photo_400_orig',
        'photo_big', 'photo_medium', 'photo_medium_rec', 'photo_max', 'photo_max_orig', 'photo_max_size', 'crop_photo',
        'sex', 'bdate', 'bdate_visibility', 'city', 'country', 'home_town', 'timezone', 'language',
        'education', 'universities', 'schools', 'career', 'military', 'work',
        'contacts', 'has_mobile', 'site', 'connections', 'exports',
    ];

    private float $lastRequestAt = 0;

    public function __construct(private readonly VkManagerHistoryService $history) {}

    /** @return array{account_id: int, observed: int, changed: int, staled: int, complete_snapshot: bool, friends: int, followers: int} */
    public function sync(User $owner, string $source = 'full_snapshot'): array
    {
        if (! filled($owner->vk_id) || ! filled($owner->vk_token)) {
            throw new RuntimeException('У аккаунта не найден действующий токен VK. Переподключите VK.');
        }

        $friends = $this->fetchCompleteList($owner, 'friends.get', [
            'user_id' => $owner->vk_id,
            'order' => 'hints',
            'fields' => implode(',', self::PROFILE_FIELDS),
        ]);
        $followers = $this->fetchCompleteList($owner, 'users.getFollowers', [
            'user_id' => $owner->vk_id,
            'fields' => implode(',', self::PROFILE_FIELDS),
        ]);
        $outgoingRequests = $this->fetchCompleteList($owner, 'friends.getRequests', [
            'out' => 1,
            'extended' => 1,
            'fields' => implode(',', self::PROFILE_FIELDS),
        ]);

        $result = $this->history->reconcileSnapshot($owner, $friends, $followers, $source, $outgoingRequests);

        return $result + [
            'friends' => count($friends),
            'followers' => count($followers),
            'outgoing_requests' => count($outgoingRequests),
        ];
    }

    private function fetchCompleteList(User $owner, string $method, array $parameters): array
    {
        $all = [];
        $offset = 0;
        $total = null;
        $pageSize = 1000;

        do {
            $this->waitBetweenRequests();
            $response = Http::asForm()
                ->acceptJson()
                ->timeout(20)
                ->post("https://api.vk.com/method/{$method}", array_merge($parameters, [
                    'count' => $pageSize,
                    'offset' => $offset,
                    'access_token' => $owner->vk_token,
                    'v' => config('services.vk.api_version', '5.199'),
                ]));

            if (! $response->successful()) {
                throw new RuntimeException("VK вернул HTTP {$response->status()} при загрузке списка.");
            }

            $payload = $response->json();
            if (isset($payload['error'])) {
                $code = data_get($payload, 'error.error_code', 'unknown');
                $message = data_get($payload, 'error.error_msg', 'ошибка VK API');
                throw new RuntimeException("VK API {$code}: {$message}");
            }

            $items = data_get($payload, 'response.items');
            $pageTotal = data_get($payload, 'response.count');
            if (! is_array($items) || ! is_numeric($pageTotal)) {
                throw new RuntimeException('VK вернул неполный список. История не обновлена.');
            }
            $total ??= (int) $pageTotal;

            if ($items === [] && $offset < $total) {
                throw new RuntimeException('VK вернул неполную страницу списка. История не обновлена.');
            }

            $all = array_merge($all, $items);
            $offset += count($items);
        } while ($offset < $total);

        if (count($all) !== $total) {
            throw new RuntimeException('VK вернул неполный список. История не обновлена.');
        }

        return $all;
    }

    private function waitBetweenRequests(): void
    {
        if ($this->lastRequestAt > 0) {
            $waitMicroseconds = max(0, 1_000_000 - (int) ((microtime(true) - $this->lastRequestAt) * 1_000_000));
            if ($waitMicroseconds > 0) {
                usleep($waitMicroseconds);
            }
        }

        $this->lastRequestAt = microtime(true);
    }
}
