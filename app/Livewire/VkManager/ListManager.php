<?php

namespace App\Livewire\VkManager;

use App\Models\VkManagerAccount;
use App\Models\VkManagerContact;
use App\Models\VkManagerContactData;
use App\Models\VkManagerInvitationAttempt;
use App\Models\VkManagerMembership;
use App\Models\VkManagerPerson;
use App\Services\VkManagerHistoryService;
use App\Services\VkManagerPublicAccessService;
use App\Services\VkManagerSnapshotSyncService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class ListManager extends Component
{
    private const PER_PAGE = 200;

    private const TABS = ['friends', 'followers', 'requests', 'preparing', 'database'];

    public string $activeTab = 'friends';

    public int $friendsPage = 1;

    public int $followersPage = 1;

    public int $requestsPage = 1;

    public bool $hideFavorites = false;

    public bool $showOnlyFavorites = false;

    public bool $showOnlyNameAndId = false;

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public ?string $statusMessage = null;

    public bool $statusIsError = false;

    public function mount(): void
    {
        abort_unless(Auth::check(), 403);

        $tab = request()->query('tab', 'friends');
        $this->activeTab = in_array($tab, self::TABS, true) ? $tab : 'friends';
        $this->friendsPage = max(1, (int) request()->query('friends_page', 1));
        $this->followersPage = max(1, (int) request()->query('followers_page', 1));
        $this->requestsPage = max(1, (int) request()->query('requests_page', 1));
        $this->hideFavorites = (bool) session('vk_manager.hide_favorites', false);
        $this->showOnlyFavorites = (bool) session('vk_manager.only_favorites', false);
        $this->showOnlyNameAndId = (bool) session('vk_manager.name_id_only', false);

        if ($this->hideFavorites && $this->showOnlyFavorites) {
            $this->hideFavorites = false;
        }
    }

    public function switchTab(string $tab): void
    {
        if (in_array($tab, self::TABS, true)) {
            $this->activeTab = $tab;
            if ($tab !== 'friends' && $this->sortField === 'friend_days') {
                $this->sortField = 'name';
                $this->sortDirection = 'asc';
            }
            $this->dispatch('vk-list-manager-updated');
        }
    }

    public function sortBy(string $field): void
    {
        $allowedFields = ['name', 'vk_id', 'favorite', 'comment', 'friend_days'];
        if (! in_array($field, $allowedFields, true)) {
            return;
        }
        if ($field === 'friend_days' && $this->activeTab !== 'friends') {
            return;
        }

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPages();
    }

    public function updatedHideFavorites(bool $value): void
    {
        if ($value) {
            $this->showOnlyFavorites = false;
            session()->put('vk_manager.only_favorites', false);
        }

        session()->put('vk_manager.hide_favorites', $value);
        $this->resetPages();
    }

    public function updatedShowOnlyFavorites(bool $value): void
    {
        if ($value) {
            $this->hideFavorites = false;
            session()->put('vk_manager.hide_favorites', false);
        }

        session()->put('vk_manager.only_favorites', $value);
        $this->resetPages();
    }

    public function updatedShowOnlyNameAndId(bool $value): void
    {
        session()->put('vk_manager.name_id_only', $value);
    }

    public function updatedSortField(string $field): void
    {
        $allowedFields = ['name', 'vk_id', 'favorite', 'comment', 'friend_days'];
        if (! in_array($field, $allowedFields, true) || ($field === 'friend_days' && $this->activeTab !== 'friends')) {
            $this->sortField = 'name';
        }
        $this->sortDirection = 'asc';
        $this->resetPages();
    }

    public function toggleSortDirection(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->resetPages();
    }

    #[On('vk-contact-updated')]
    public function contactUpdated(string $message = '', bool $isError = false): void
    {
        $this->statusMessage = $message !== '' ? $message : null;
        $this->statusIsError = $isError;
    }

    public function goToPage(string $list, int $page): void
    {
        $pageProperty = match ($list) {
            'friends' => 'friendsPage',
            'followers' => 'followersPage',
            'requests' => 'requestsPage',
            default => null,
        };

        if ($pageProperty === null || $list !== $this->activeTab) {
            return;
        }

        $status = $this->statusForList($list);
        $lastPage = max(1, (int) ceil($this->listQuery($status)->count() / self::PER_PAGE));
        $this->{$pageProperty} = min(max(1, $page), $lastPage);
        $this->dispatch('vk-list-manager-updated');
    }

    public function regeneratePublicLink(VkManagerPublicAccessService $access): void
    {
        if ($access->regenerate(Auth::user()) === null) {
            $this->statusMessage = 'Не удалось создать ссылку: у аккаунта нет VK ID.';
            $this->statusIsError = true;

            return;
        }

        $this->statusMessage = 'Ссылка перевыпущена. Старая ссылка больше не работает.';
        $this->statusIsError = false;
    }

    public function startSnapshotSync(VkManagerSnapshotSyncService $snapshotSync): void
    {
        try {
            $snapshotSync->startRun(Auth::user());
            $this->statusMessage = 'Обновление запущено. Загружаю количества списков…';
            $this->statusIsError = false;
        } catch (Throwable $exception) {
            $this->statusMessage = 'Не удалось запустить обновление: '.$exception->getMessage();
            $this->statusIsError = true;
        }
    }

    public function advanceSnapshotSync(VkManagerSnapshotSyncService $snapshotSync): void
    {
        if ($this->activeTab !== 'database') {
            return;
        }

        $run = $snapshotSync->advanceRun(Auth::user());
        if ($run?->status === \App\Models\VkManagerSyncRun::STATUS_COMPLETED) {
            $this->statusMessage = 'Состояние обновлено. Временный снимок применён к истории аккаунта.';
            $this->statusIsError = false;
        } elseif ($run?->status === \App\Models\VkManagerSyncRun::STATUS_READY) {
            $this->statusMessage = 'Все страницы загружены без ошибок. Нажмите «Отправить полученные данные в базу данных», чтобы применить снимок к истории.';
            $this->statusIsError = false;
        } elseif ($run?->status === \App\Models\VkManagerSyncRun::STATUS_FINALIZING) {
            $completed = (int) data_get($run->progress, 'commit_completed', 0);
            $total = (int) data_get($run->progress, 'commit_total', 0);
            $this->statusMessage = $total > 0
                ? "Сохраняю данные в базу: {$completed} из {$total} контактов."
                : 'Подготавливаю данные для сохранения в базу…';
            $this->statusIsError = false;
        } elseif ($run?->status === \App\Models\VkManagerSyncRun::STATUS_FAILED) {
            $this->statusMessage = 'Загрузка остановлена. Повторите ошибочную страницу или подсчёт в соответствующей строке.';
            $this->statusIsError = true;
        }
    }

    public function retrySnapshotSync(VkManagerSnapshotSyncService $snapshotSync): void
    {
        $snapshotSync->retryRun(Auth::user());
        $this->statusMessage = 'Повторяю остановленный шаг. После успеха загрузка продолжится автоматически.';
        $this->statusIsError = false;
    }

    public function retrySnapshotPage(string $list, int $page, VkManagerSnapshotSyncService $snapshotSync): void
    {
        $run = $snapshotSync->retryPage(Auth::user(), $list, $page);
        if ($run?->status === \App\Models\VkManagerSyncRun::STATUS_RUNNING) {
            $this->statusMessage = 'Повторяю страницу '.$page.'. После успеха загрузка продолжится автоматически.';
            $this->statusIsError = false;
        } else {
            $this->statusMessage = 'Не удалось повторить загрузку страницы. Обновите список и попробуйте ещё раз.';
            $this->statusIsError = true;
        }
    }

    public function commitSnapshot(VkManagerSnapshotSyncService $snapshotSync): void
    {
        try {
            $run = $snapshotSync->commitSnapshot(Auth::user());
            if ($run?->status === \App\Models\VkManagerSyncRun::STATUS_COMPLETED) {
                $this->statusMessage = 'Снимок сохранён в истории аккаунта.';
                $this->statusIsError = false;
            } elseif ($run?->status === \App\Models\VkManagerSyncRun::STATUS_FAILED) {
                $this->statusMessage = 'Не удалось применить снимок: '.$run->error_message;
                $this->statusIsError = true;
            } elseif ($run?->status === \App\Models\VkManagerSyncRun::STATUS_FINALIZING) {
                $this->statusMessage = 'Сохранение запущено. Данные будут записываться небольшими шагами.';
                $this->statusIsError = false;
            } else {
                $this->statusMessage = 'Данные пока не готовы к отправке. Проверьте статусы страниц.';
                $this->statusIsError = true;
            }
        } catch (Throwable $exception) {
            $this->statusMessage = $exception->getMessage();
            $this->statusIsError = true;
        }
    }

    public function render()
    {
        $owner = Auth::user();
        $dbStats = app(VkManagerHistoryService::class)->summary($owner);
        $syncRun = app(VkManagerSnapshotSyncService::class)->latestRun($owner);
        $syncPages = $syncRun?->pages()->orderBy('list_name')->orderBy('page_number')->get()->groupBy('list_name') ?? collect();
        $activeList = match ($this->activeTab) {
            'friends' => $this->pageData(VkManagerMembership::STATUS_FRIEND, $this->friendsPage),
            'followers' => $this->pageData(VkManagerMembership::STATUS_FOLLOWER, $this->followersPage),
            'requests' => $this->pageData(VkManagerMembership::STATUS_OUTGOING_REQUEST, $this->requestsPage),
            default => null,
        };
        $accountId = VkManagerAccount::query()->where('user_id', $owner->getKey())->value('id');
        $currentPersonIds = $accountId
            ? VkManagerMembership::query()->where('account_id', $accountId)->where('is_current', true)->pluck('person_id')
            : collect();
        $currentVkIds = $currentPersonIds->isNotEmpty()
            ? VkManagerPerson::query()->whereIn('id', $currentPersonIds)->pluck('vk_id')->map(fn ($id) => (string) $id)
            : collect();
        $knownContactIds = VkManagerContact::query()->where('user_id', $owner->getKey())->pluck('vk_friend_id')->map(fn ($id) => (string) $id);
        $excludedIds = $currentVkIds->merge($knownContactIds)->unique()->values()->all();
        $preparingQuery = VkManagerInvitationAttempt::query()
            ->where('user_id', $owner->getKey())
            ->whereNull('resolved_at');
        if ($excludedIds !== []) {
            $preparingQuery->whereNotIn('vk_id', $excludedIds);
        }
        $preparingCount = (clone $preparingQuery)->count();
        $preparingAttempts = $preparingQuery->latest('started_at')->get();

        return view('livewire.vk_manager.list-manager', [
            'dbStats' => $dbStats,
            'publicUrl' => $this->activeTab === 'database'
                ? app(VkManagerPublicAccessService::class)->url($owner)
                : null,
            'syncRun' => $syncRun,
            'syncPages' => $syncPages,
            'activeList' => $activeList,
            'pageFriendIds' => $this->activeTab === 'friends'
                ? array_map(fn (array $person) => (string) $person['id'], $activeList['people'])
                : [],
            'preparingCount' => $preparingCount,
            'preparingAttempts' => $preparingAttempts,
        ]);
    }

    private function pageData(string $status, int $page): array
    {
        $query = $this->listQuery($status);
        $count = (clone $query)->count();
        $pages = max(1, (int) ceil($count / self::PER_PAGE));
        $page = min(max(1, $page), $pages);
        $sortedQuery = $query
            ->join('vk_manager_people as sort_people', 'sort_people.id', '=', 'vk_manager_memberships.person_id')
            ->leftJoin('vk_manager_contacts as sort_contacts', function (JoinClause $join): void {
                $join->on('sort_contacts.vk_friend_id', '=', 'sort_people.vk_id')
                    ->where('sort_contacts.user_id', '=', Auth::id());
            })
            ->select('vk_manager_memberships.*')
            ->with('person');
        $this->applySort($sortedQuery);
        $memberships = $sortedQuery
            ->orderBy('vk_manager_memberships.id')
            ->offset(($page - 1) * self::PER_PAGE)
            ->limit(self::PER_PAGE)
            ->get();
        $ids = $memberships->map(fn (VkManagerMembership $membership) => $membership->person?->vk_id)
            ->filter()
            ->values();
        $metadata = VkManagerContact::query()
            ->where('user_id', Auth::id())
            ->whereIn('vk_friend_id', $ids)
            ->get()
            ->keyBy(fn (VkManagerContact $contact) => (string) $contact->vk_friend_id);
        $personIds = $memberships->map(fn (VkManagerMembership $membership) => $membership->person?->getKey())
            ->filter()
            ->values();
        $phones = $this->phonesForPeople($personIds->all());
        $people = $memberships->map(function (VkManagerMembership $membership) use ($metadata, $phones): array {
            $person = $membership->person;
            $id = (string) $person?->vk_id;
            $contact = $metadata->get($id);

            return [
                'id' => $id,
                'first_name' => $person?->first_name ?? $person?->display_name ?? 'Пользователь',
                'last_name' => $person?->last_name ?? '',
                'domain' => $person?->domain,
                'photo_100' => $person?->photo_url,
                'phone' => $phones[$person?->getKey()] ?? null,
                'friend_days' => $membership->status === VkManagerMembership::STATUS_FRIEND
                    ? max(0, (int) $membership->started_at->diffInDays(now()))
                    : null,
                'friend_since' => $membership->started_at?->format('d.m.Y'),
                'manager_comment' => $contact?->comment,
                'manager_favorite' => (bool) ($contact?->is_favorite ?? false),
            ];
        })->filter(fn (array $person) => $person['id'] !== '')->values()->all();

        return ['people' => $people, 'count' => $count, 'page' => $page, 'pages' => $pages];
    }

    /** @param array<int, int> $personIds
     * @return array<int, string>
     */
    private function phonesForPeople(array $personIds): array
    {
        if ($personIds === []) {
            return [];
        }

        $accountId = VkManagerAccount::query()
            ->where('user_id', Auth::id())
            ->value('id');
        if (! $accountId) {
            return [];
        }

        $contactData = VkManagerContactData::query()
            ->where('account_id', $accountId)
            ->whereIn('person_id', $personIds)
            ->whereNull('obsolete_at')
            ->orderBy('id')
            ->get()
            ->keyBy('person_id');

        $phones = [];
        foreach ($contactData as $personId => $data) {
            $phone = $this->contactPhone($data->data ?? []);
            if ($phone !== null) {
                $phones[(int) $personId] = $phone;
            }
        }

        return $phones;
    }

    private function contactPhone(array $data): ?string
    {
        foreach (['mobile_phone', 'home_phone'] as $key) {
            $value = $data[$key] ?? null;
            if (! is_string($value)) {
                continue;
            }

            $value = trim($value);
            if (preg_match('/^\+?[\d\s()\-]{5,}$/', $value) === 1 && preg_match_all('/\d/', $value) >= 5) {
                return $value;
            }
        }

        return null;
    }

    private function applySort(Builder $query): void
    {
        $direction = $this->sortDirection === 'desc' ? 'desc' : 'asc';

        match ($this->sortField) {
            'vk_id' => $query->orderBy('sort_people.vk_id', $direction),
            'favorite' => $query->orderByRaw('COALESCE(sort_contacts.is_favorite, 0) '.$direction),
            'comment' => $query
                ->orderByRaw("CASE WHEN sort_contacts.comment IS NULL OR TRIM(sort_contacts.comment) = '' THEN 1 ELSE 0 END ASC")
                ->orderBy('sort_contacts.comment', $direction),
            'friend_days' => $query->orderBy(
                'vk_manager_memberships.started_at',
                $direction === 'asc' ? 'desc' : 'asc',
            ),
            default => $query
                ->orderByRaw("COALESCE(NULLIF(sort_people.first_name, ''), sort_people.display_name, '') {$direction}")
                ->orderBy('sort_people.last_name', $direction),
        };
    }

    private function listQuery(string $status): Builder
    {
        $accountId = VkManagerAccount::query()
            ->where('user_id', Auth::id())
            ->value('id');

        $query = VkManagerMembership::query()
            ->where('account_id', $accountId)
            ->where('status', $status)
            ->where('is_current', true);

        if ($this->showOnlyFavorites || $this->hideFavorites) {
            $favoriteIds = VkManagerContact::query()
                ->select('vk_friend_id')
                ->where('user_id', Auth::id())
                ->where('is_favorite', true);

            $query->whereHas('person', function (Builder $personQuery) use ($favoriteIds): void {
                if ($this->showOnlyFavorites) {
                    $personQuery->whereIn('vk_id', $favoriteIds);
                } elseif ($this->hideFavorites) {
                    $personQuery->whereNotIn('vk_id', $favoriteIds);
                }
            });
        }

        return $query;
    }

    private function statusForList(string $list): string
    {
        return match ($list) {
            'friends' => VkManagerMembership::STATUS_FRIEND,
            'followers' => VkManagerMembership::STATUS_FOLLOWER,
            'requests' => VkManagerMembership::STATUS_OUTGOING_REQUEST,
            default => throw new \InvalidArgumentException('Unknown VK relationship list.'),
        };
    }

    private function resetPages(): void
    {
        $this->friendsPage = 1;
        $this->followersPage = 1;
        $this->requestsPage = 1;
    }
}
