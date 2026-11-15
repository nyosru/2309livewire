<?php

namespace App\Services;

use App\Models\User;
use App\Models\VkManagerAccount;
use App\Models\VkManagerMembership;
use App\Models\VkManagerPerson;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Read-only access to one VK Manager account for external agents.
 *
 * The public token is a long random string stored on the account. It lets an
 * unauthenticated client read the current VK access token and the current
 * relationship lists, and it can be reissued by the account owner at any time.
 */
class VkManagerPublicAccessService
{
    private const LISTS = [
        VkManagerMembership::STATUS_FRIEND => 'friends',
        VkManagerMembership::STATUS_FOLLOWER => 'followers',
        VkManagerMembership::STATUS_OUTGOING_REQUEST => 'outgoing_requests',
    ];

    public function __construct(private readonly VkManagerHistoryService $history) {}

    public function url(User $owner): ?string
    {
        $token = $this->tokenFor($owner);

        return $token === null ? null : url('/db/'.$token);
    }

    public function tokenFor(User $owner): ?string
    {
        $account = $this->accountFor($owner);
        if ($account === null) {
            return null;
        }

        if (! filled($account->public_token)) {
            $account->forceFill(['public_token' => $this->newToken()])->save();
        }

        return (string) $account->public_token;
    }

    public function regenerate(User $owner): ?string
    {
        $account = $this->accountFor($owner);
        if ($account === null) {
            return null;
        }

        $account->forceFill(['public_token' => $this->newToken()])->save();

        return (string) $account->public_token;
    }

    public function payload(string $token): ?array
    {
        $account = VkManagerAccount::query()
            ->where('public_token', $token)
            ->first();

        $owner = $account?->user;
        if (! $account || ! $owner) {
            return null;
        }

        $lists = [];
        $counts = [];
        foreach (self::LISTS as $status => $key) {
            $people = $this->people($account, $status);
            $lists[$key] = [
                'title' => $this->listTitle($key),
                'total' => count($people),
                'ids' => array_map(fn (array $person) => $person['id'], $people),
                'people' => $people,
            ];
            $counts[$key] = count($people);
        }

        return [
            'ok' => true,
            'description' => 'Текущий вход VK Manager: VK ID и access token аккаунта, а также все ID и ники в трёх списках — друзья, подписчики и исходящие заявки.',
            'generated_at' => now()->toIso8601String(),
            'account' => [
                'vk_id' => (string) $account->vk_id,
                'name' => (string) $account->name,
                'access_token' => (string) ($owner->vk_token ?? ''),
                'last_observed_at' => $account->last_observed_at?->toIso8601String(),
                'last_full_sync_at' => $account->last_full_sync_at?->toIso8601String(),
            ],
            'counts' => $counts,
            'lists' => $lists,
        ];
    }

    /**
     * Plain-text rendering of the payload for clients that do not parse JSON.
     */
    public function toText(array $payload): string
    {
        $lines = [
            'VK Manager — данные текущего входа',
            'VK ID: '.$payload['account']['vk_id'],
            'Имя: '.$payload['account']['name'],
            'Токен VK: '.$payload['account']['access_token'],
            'Обновлено: '.$payload['generated_at'],
        ];

        foreach ($payload['lists'] as $list) {
            $lines[] = '';
            $lines[] = $list['title'].' ('.$list['total'].'):';
            foreach ($list['people'] as $person) {
                $lines[] = $person['id'].($person['nickname'] ? ' '.$person['nickname'] : '');
            }
        }

        return implode("\n", $lines)."\n";
    }

    private function accountFor(User $owner): ?VkManagerAccount
    {
        $account = VkManagerAccount::query()->where('user_id', $owner->getKey())->first();
        if ($account) {
            return $account;
        }

        try {
            return $this->history->ensureAccount($owner);
        } catch (InvalidArgumentException) {
            return null;
        }
    }

    /**
     * @return array<int, array{id: string, nickname: string|null, name: string, url: string}>
     */
    private function people(VkManagerAccount $account, string $status): array
    {
        return VkManagerPerson::query()
            ->join('vk_manager_memberships', 'vk_manager_memberships.person_id', '=', 'vk_manager_people.id')
            ->where('vk_manager_memberships.account_id', $account->getKey())
            ->where('vk_manager_memberships.status', $status)
            ->where('vk_manager_memberships.is_current', true)
            ->orderByRaw('LENGTH(vk_manager_people.vk_id), vk_manager_people.vk_id')
            ->get(['vk_manager_people.*'])
            ->map(function (VkManagerPerson $person): array {
                $id = (string) $person->vk_id;
                $name = trim((string) $person->first_name.' '.(string) $person->last_name);
                $nickname = filled($person->domain) ? (string) $person->domain : null;

                return [
                    'id' => $id,
                    'nickname' => $nickname,
                    'name' => $name !== '' ? $name : (string) ($person->display_name ?? ''),
                    'url' => $nickname !== null ? 'https://vk.com/'.$nickname : 'https://vk.com/id'.$id,
                ];
            })
            ->all();
    }

    private function listTitle(string $key): string
    {
        return match ($key) {
            'friends' => 'Друзья',
            'followers' => 'Подписчики',
            'outgoing_requests' => 'Исходящие заявки',
            default => $key,
        };
    }

    private function newToken(): string
    {
        do {
            $token = Str::random(48);
        } while (VkManagerAccount::query()->where('public_token', $token)->exists());

        return $token;
    }
}
