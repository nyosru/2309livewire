<?php

namespace App\Services;

use App\Models\User;
use App\Models\VkManagerAccount;
use App\Models\VkManagerContact;
use App\Models\VkManagerMembership;
use App\Models\VkManagerPerson;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class VkManagerHistoryService
{
    public function ensureAccount(User $owner): VkManagerAccount
    {
        $vkId = $this->normalizeVkId((string) $owner->vk_id);

        return VkManagerAccount::query()->updateOrCreate(
            ['user_id' => $owner->getKey()],
            ['vk_id' => $vkId, 'name' => $owner->name],
        );
    }

    /**
     * Record one confirmed relationship change. A null status means the person
     * is no longer in either list; it closes the current record without adding one.
     *
     * @return array{changed: bool, account_id: int, person_id: int, previous_status: string|null, status: string|null, membership_id: int|null}
     */
    public function recordChange(
        User $owner,
        string|int $vkId,
        ?string $status,
        array $profile = [],
        string $source = 'agent',
    ): array {
        $vkId = $this->normalizeVkId((string) $vkId);
        $status = $this->normalizeStatus($status);
        $source = $this->normalizeSource($source);
        $account = $this->ensureAccount($owner);
        $now = now();

        return DB::transaction(function () use ($account, $vkId, $status, $profile, $source, $now): array {
            $account = VkManagerAccount::query()->whereKey($account->getKey())->lockForUpdate()->firstOrFail();
            $person = $this->savePerson($vkId, $profile, $now);
            $current = VkManagerMembership::query()
                ->where('account_id', $account->getKey())
                ->where('person_id', $person->getKey())
                ->where('is_current', true)
                ->lockForUpdate()
                ->get();
            $previousStatuses = $current->pluck('status')->unique()->values();
            $previousStatus = $previousStatuses->count() === 1 ? $previousStatuses->first() : null;

            $account->forceFill(['last_observed_at' => $now])->save();

            if ($status === null) {
                if ($current->isNotEmpty()) {
                    VkManagerMembership::query()->whereIn('id', $current->modelKeys())->update([
                        'is_current' => false,
                        'ended_at' => $now,
                    ]);
                }

                return [
                    'changed' => $current->isNotEmpty(),
                    'account_id' => (int) $account->getKey(),
                    'person_id' => (int) $person->getKey(),
                    'previous_status' => $previousStatus,
                    'status' => null,
                    'membership_id' => null,
                ];
            }

            if ($current->count() === 1 && $previousStatus === $status) {
                return [
                    'changed' => false,
                    'account_id' => (int) $account->getKey(),
                    'person_id' => (int) $person->getKey(),
                    'previous_status' => $previousStatus,
                    'status' => $status,
                    'membership_id' => (int) $current->first()->getKey(),
                ];
            }

            if ($current->isNotEmpty()) {
                VkManagerMembership::query()->whereIn('id', $current->modelKeys())->update([
                    'is_current' => false,
                    'ended_at' => $now,
                ]);
            }

            $membership = VkManagerMembership::query()->create([
                'account_id' => $account->getKey(),
                'person_id' => $person->getKey(),
                'status' => $status,
                'is_current' => true,
                'started_at' => $now,
                'source' => $source,
            ]);

            return [
                'changed' => true,
                'account_id' => (int) $account->getKey(),
                'person_id' => (int) $person->getKey(),
                'previous_status' => $previousStatus,
                'status' => $status,
                'membership_id' => (int) $membership->getKey(),
            ];
        });
    }

    /** Observe one or both partial pages. Missing people are never marked stale. */
    public function observeLists(User $owner, array $friends, array $followers, string $source = 'vk_api_page'): array
    {
        return $this->applyObservations($owner, $friends, $followers, $source, false);
    }

    /** Reconcile only when both arrays contain complete, untruncated VK lists. */
    public function reconcileSnapshot(User $owner, array $friends, array $followers, string $source = 'full_snapshot'): array
    {
        return $this->applyObservations($owner, $friends, $followers, $source, true);
    }

    public function summary(User $owner): array
    {
        $account = VkManagerAccount::query()->where('user_id', $owner->getKey())->first();
        $base = VkManagerMembership::query()->where('account_id', $account?->getKey());
        $contacts = VkManagerContact::query()->where('user_id', $owner->getKey());

        return [
            'vk_id' => (string) ($account?->vk_id ?? $owner->vk_id ?? ''),
            'name' => (string) ($account?->name ?? $owner->name),
            'unique_people' => $account ? (clone $base)->distinct('person_id')->count('person_id') : 0,
            'membership_records' => $account ? (clone $base)->count() : 0,
            'current_friends' => $account ? (clone $base)->where('status', VkManagerMembership::STATUS_FRIEND)->where('is_current', true)->count() : 0,
            'current_followers' => $account ? (clone $base)->where('status', VkManagerMembership::STATUS_FOLLOWER)->where('is_current', true)->count() : 0,
            'former_friend_periods' => $account ? (clone $base)->where('status', VkManagerMembership::STATUS_FRIEND)->where('is_current', false)->count() : 0,
            'former_follower_periods' => $account ? (clone $base)->where('status', VkManagerMembership::STATUS_FOLLOWER)->where('is_current', false)->count() : 0,
            'favorites' => (clone $contacts)->where('is_favorite', true)->count(),
            'comments' => (clone $contacts)->whereNotNull('comment')->where('comment', '<>', '')->count(),
            'last_observed_at' => $account?->last_observed_at,
            'last_full_sync_at' => $account?->last_full_sync_at,
        ];
    }

    private function applyObservations(User $owner, array $friends, array $followers, string $source, bool $complete): array
    {
        $source = $this->normalizeSource($source);
        $observations = [];

        foreach ($followers as $person) {
            $observation = $this->normalizePerson($person, VkManagerMembership::STATUS_FOLLOWER);
            if ($observation) {
                $observations[$observation['vk_id']] = $observation;
            }
        }

        // Friends take precedence if VK includes the same account in both lists.
        foreach ($friends as $person) {
            $observation = $this->normalizePerson($person, VkManagerMembership::STATUS_FRIEND);
            if ($observation) {
                $observations[$observation['vk_id']] = $observation;
            }
        }

        $account = $this->ensureAccount($owner);
        $now = now();

        return DB::transaction(function () use ($account, $observations, $source, $complete, $now): array {
            $account = VkManagerAccount::query()->whereKey($account->getKey())->lockForUpdate()->firstOrFail();
            $peopleRows = [];
            foreach ($observations as $observation) {
                $profile = $this->profileAttributes($observation['profile']);
                $peopleRows[] = array_merge([
                    'vk_id' => $observation['vk_id'],
                    'first_name' => null,
                    'last_name' => null,
                    'display_name' => null,
                    'domain' => null,
                    'photo_url' => null,
                    'created_at' => $now,
                ], $profile, [
                    'last_profile_sync_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            if ($peopleRows !== []) {
                VkManagerPerson::query()->upsert(
                    $peopleRows,
                    ['vk_id'],
                    ['first_name', 'last_name', 'display_name', 'domain', 'photo_url', 'last_profile_sync_at', 'updated_at'],
                );
            }

            $people = VkManagerPerson::query()
                ->whereIn('vk_id', array_keys($observations))
                ->get()
                ->keyBy('vk_id');
            $personIds = $people->pluck('id')->map(fn ($id) => (int) $id)->all();
            $currentByPerson = $personIds === []
                ? collect()
                : VkManagerMembership::query()
                    ->where('account_id', $account->getKey())
                    ->where('is_current', true)
                    ->whereIn('person_id', $personIds)
                    ->lockForUpdate()
                    ->get()
                    ->groupBy('person_id');

            $membershipIdsToClose = [];
            $membershipsToInsert = [];
            $changed = 0;
            foreach ($observations as $vkId => $observation) {
                $person = $people->get($vkId);
                if (! $person) {
                    continue;
                }
                $current = $currentByPerson->get($person->getKey(), collect());
                if ($current->count() === 1 && $current->first()->status === $observation['status']) {
                    continue;
                }

                foreach ($current as $membership) {
                    $membershipIdsToClose[] = $membership->getKey();
                }
                $membershipsToInsert[] = [
                    'account_id' => $account->getKey(),
                    'person_id' => $person->getKey(),
                    'status' => $observation['status'],
                    'is_current' => true,
                    'started_at' => $now,
                    'ended_at' => null,
                    'source' => $source,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                $changed++;
            }

            if ($membershipIdsToClose !== []) {
                VkManagerMembership::query()->whereIn('id', $membershipIdsToClose)->update([
                    'is_current' => false,
                    'ended_at' => $now,
                ]);
            }
            if ($membershipsToInsert !== []) {
                VkManagerMembership::query()->insert($membershipsToInsert);
            }

            $staled = 0;
            if ($complete) {
                $missing = VkManagerMembership::query()
                    ->where('account_id', $account->getKey())
                    ->where('is_current', true);
                if ($personIds !== []) {
                    $missing->whereNotIn('person_id', $personIds);
                }
                $staled = $missing->update(['is_current' => false, 'ended_at' => $now]);
            }

            $accountTimestamps = ['last_observed_at' => $now];
            if ($complete) {
                $accountTimestamps['last_full_sync_at'] = $now;
            }
            $account->forceFill($accountTimestamps)->save();

            return [
                'account_id' => (int) $account->getKey(),
                'observed' => count($observations),
                'changed' => $changed,
                'staled' => $staled,
                'complete_snapshot' => $complete,
            ];
        });
    }

    private function savePerson(string $vkId, array $profile, Carbon $now): VkManagerPerson
    {
        $person = VkManagerPerson::query()->firstOrCreate(['vk_id' => $vkId]);
        $attributes = $this->profileAttributes($profile);
        if ($attributes !== []) {
            $person->fill($attributes);
            $person->last_profile_sync_at = $now;
            $person->save();
        }

        return $person;
    }

    private function normalizePerson(mixed $person, string $status): ?array
    {
        if (is_object($person)) {
            $person = (array) $person;
        }
        if (! is_array($person)) {
            return null;
        }

        $id = $person['vk_id'] ?? $person['id'] ?? null;
        if (! is_string($id) && ! is_int($id)) {
            return null;
        }

        try {
            $id = $this->normalizeVkId((string) $id);
        } catch (InvalidArgumentException) {
            return null;
        }

        return ['vk_id' => $id, 'status' => $status, 'profile' => $person];
    }

    private function profileAttributes(array $profile): array
    {
        $attributes = [];
        foreach (['first_name', 'last_name', 'domain'] as $key) {
            if (array_key_exists($key, $profile) && is_string($profile[$key])) {
                $attributes[$key] = mb_substr(trim($profile[$key]), 0, $key === 'domain' ? 100 : 100);
            }
        }

        $photo = $profile['photo_url'] ?? $profile['photo_100'] ?? null;
        if (is_string($photo) && $photo !== '') {
            $attributes['photo_url'] = mb_substr($photo, 0, 4000);
        }

        $displayName = $profile['display_name'] ?? trim(($attributes['first_name'] ?? '').' '.($attributes['last_name'] ?? ''));
        if (is_string($displayName) && $displayName !== '') {
            $attributes['display_name'] = mb_substr($displayName, 0, 255);
        }

        return $attributes;
    }

    private function normalizeVkId(string $vkId): string
    {
        if (! preg_match('/^[1-9][0-9]{0,19}$/', $vkId)) {
            throw new InvalidArgumentException('VK ID must be a positive numeric string of up to 20 digits.');
        }

        return $vkId;
    }

    private function normalizeStatus(?string $status): ?string
    {
        if ($status === null) {
            return null;
        }
        if (! in_array($status, [VkManagerMembership::STATUS_FRIEND, VkManagerMembership::STATUS_FOLLOWER], true)) {
            throw new InvalidArgumentException('Status must be friend, follower, or null.');
        }

        return $status;
    }

    private function normalizeSource(string $source): string
    {
        $source = trim($source);

        return $source === '' ? 'agent' : mb_substr($source, 0, 50);
    }
}
