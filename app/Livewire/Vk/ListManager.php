<?php

namespace App\Livewire\Vk;

use App\Models\VkManagerAccount;
use App\Models\VkManagerContact;
use App\Models\VkManagerMembership;
use App\Services\VkManagerHistoryService;
use App\Services\VkManagerSnapshotSyncService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class ListManager extends Component
{
    private const PER_PAGE = 200;

    private const TABS = ['friends', 'followers', 'requests', 'database'];

    public string $activeTab = 'friends';

    public int $friendsPage = 1;

    public int $followersPage = 1;

    public int $requestsPage = 1;

    public bool $hideFavorites = false;

    public bool $showOnlyFavorites = false;

    public bool $showOnlyNameAndId = false;

    /** @var array<int, string> */
    public array $selectedFriends = [];

    /** @var array<string, string> */
    public array $commentDrafts = [];

    /** @var array<string, bool> */
    public array $savedComments = [];

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

        $this->seedActiveCommentDrafts();
    }

    public function switchTab(string $tab): void
    {
        if (in_array($tab, self::TABS, true)) {
            $this->activeTab = $tab;
            $this->seedActiveCommentDrafts();
            $this->dispatch('vk-list-manager-updated');
        }
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

    public function updatedCommentDrafts(mixed $value, string $vkId): void
    {
        unset($this->savedComments[$vkId]);
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
        $this->seedActiveCommentDrafts();
        $this->dispatch('vk-list-manager-updated');
    }

    public function toggleSelectPage(): void
    {
        if ($this->activeTab !== 'friends') {
            return;
        }

        $page = $this->pageData(VkManagerMembership::STATUS_FRIEND, $this->friendsPage);
        $ids = array_map(fn (array $person) => (string) $person['id'], $page['people']);
        $selected = array_map('strval', $this->selectedFriends);
        $allSelected = $ids !== [] && count(array_intersect($ids, $selected)) === count($ids);

        $this->selectedFriends = $allSelected
            ? array_values(array_diff($selected, $ids))
            : array_values(array_unique(array_merge($selected, $ids)));
    }

    public function toggleFavorite(string $vkId): void
    {
        $this->assertCurrentContact($vkId);
        $owner = Auth::user();
        $contact = VkManagerContact::query()->firstOrNew([
            'user_id' => $owner->getKey(),
            'vk_friend_id' => $vkId,
        ]);
        $contact->is_favorite = ! (bool) $contact->is_favorite;
        $contact->save();

        $this->statusMessage = $contact->is_favorite ? 'Контакт добавлен в избранное.' : 'Контакт убран из избранного.';
        $this->statusIsError = false;
    }

    public function saveComment(string $vkId): void
    {
        $this->assertCurrentContact($vkId);
        $validated = $this->validate([
            'commentDrafts.'.$vkId => ['nullable', 'string', 'max:2000'],
        ]);

        $comment = trim((string) ($validated['commentDrafts'][$vkId] ?? ''));
        VkManagerContact::query()->updateOrCreate(
            ['user_id' => Auth::id(), 'vk_friend_id' => $vkId],
            ['comment' => $comment === '' ? null : $comment],
        );
        $this->commentDrafts[$vkId] = $comment;
        $this->savedComments[$vkId] = true;
        $this->statusMessage = 'Комментарий сохранён.';
        $this->statusIsError = false;
    }

    public function refreshState(VkManagerSnapshotSyncService $snapshotSync): void
    {
        try {
            $result = $snapshotSync->sync(Auth::user(), 'manual_full_sync');
            $this->statusMessage = sprintf(
                'Состояние обновлено: друзей %d, подписчиков %d, исходящих заявок %d.',
                $result['friends'],
                $result['followers'],
                $result['outgoing_requests'],
            );
            $this->statusIsError = false;
            $this->seedActiveCommentDrafts();
        } catch (Throwable $exception) {
            $this->statusMessage = 'Не удалось обновить данные: '.$exception->getMessage();
            $this->statusIsError = true;
        }
    }

    public function render()
    {
        $owner = Auth::user();
        $dbStats = app(VkManagerHistoryService::class)->summary($owner);
        $counts = [
            'friends' => $this->listQuery(VkManagerMembership::STATUS_FRIEND)->count(),
            'followers' => $this->listQuery(VkManagerMembership::STATUS_FOLLOWER)->count(),
            'requests' => $this->listQuery(VkManagerMembership::STATUS_OUTGOING_REQUEST)->count(),
        ];
        $activeList = match ($this->activeTab) {
            'friends' => $this->pageData(VkManagerMembership::STATUS_FRIEND, $this->friendsPage),
            'followers' => $this->pageData(VkManagerMembership::STATUS_FOLLOWER, $this->followersPage),
            'requests' => $this->pageData(VkManagerMembership::STATUS_OUTGOING_REQUEST, $this->requestsPage),
            default => null,
        };

        return view('livewire.vk.list-manager', [
            'dbStats' => $dbStats,
            'counts' => $counts,
            'activeList' => $activeList,
            'pageFriendIds' => $this->activeTab === 'friends'
                ? array_map(fn (array $person) => (string) $person['id'], $activeList['people'])
                : [],
        ]);
    }

    private function pageData(string $status, int $page): array
    {
        $query = $this->listQuery($status);
        $count = (clone $query)->count();
        $pages = max(1, (int) ceil($count / self::PER_PAGE));
        $page = min(max(1, $page), $pages);
        $memberships = $query->with('person')
            ->orderBy('id')
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
        $people = $memberships->map(function (VkManagerMembership $membership) use ($metadata): array {
            $person = $membership->person;
            $id = (string) $person?->vk_id;
            $contact = $metadata->get($id);

            return [
                'id' => $id,
                'first_name' => $person?->first_name ?? $person?->display_name ?? 'Пользователь',
                'last_name' => $person?->last_name ?? '',
                'domain' => $person?->domain,
                'photo_100' => $person?->photo_url,
                'manager_comment' => $contact?->comment,
                'manager_favorite' => (bool) ($contact?->is_favorite ?? false),
            ];
        })->filter(fn (array $person) => $person['id'] !== '')->values()->all();

        return ['people' => $people, 'count' => $count, 'page' => $page, 'pages' => $pages];
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

    private function assertCurrentContact(string $vkId): void
    {
        abort_unless(preg_match('/^[1-9][0-9]{0,19}$/', $vkId), 404);
        $accountId = VkManagerAccount::query()->where('user_id', Auth::id())->value('id');
        abort_unless(VkManagerMembership::query()
            ->where('account_id', $accountId)
            ->where('is_current', true)
            ->whereHas('person', fn (Builder $query) => $query->where('vk_id', $vkId))
            ->exists(), 404);
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
        $this->seedActiveCommentDrafts();
    }

    private function seedActiveCommentDrafts(): void
    {
        $list = match ($this->activeTab) {
            'friends' => $this->pageData(VkManagerMembership::STATUS_FRIEND, $this->friendsPage),
            'followers' => $this->pageData(VkManagerMembership::STATUS_FOLLOWER, $this->followersPage),
            'requests' => $this->pageData(VkManagerMembership::STATUS_OUTGOING_REQUEST, $this->requestsPage),
            default => null,
        };

        foreach ($list['people'] ?? [] as $person) {
            $vkId = (string) $person['id'];
            if (! array_key_exists($vkId, $this->commentDrafts)) {
                $this->commentDrafts[$vkId] = (string) ($person['manager_comment'] ?? '');
            }
        }
    }
}
