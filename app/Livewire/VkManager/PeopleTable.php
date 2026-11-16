<?php

namespace App\Livewire\VkManager;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PeopleTable extends Component
{
    /** @var array<int, array<string, mixed>> */
    #[Reactive]
    public array $people = [];

    #[Reactive]
    public string $activeTab = 'friends';

    #[Reactive]
    public int $page = 1;

    #[Reactive]
    public int $pages = 1;

    #[Reactive]
    public int $count = 0;

    #[Reactive]
    public bool $showOnlyFavorites = false;

    #[Reactive]
    public bool $hideFavorites = false;

    #[Reactive]
    public bool $showOnlyNameAndId = false;

    #[Reactive]
    public string $sortField = 'name';

    #[Reactive]
    public string $sortDirection = 'asc';

    #[Reactive]
    public bool $hasSyncedData = false;

    /** @var array<int, string> */
    #[Reactive]
    public array $pageFriendIds = [];

    /** @var array<int, string> */
    public array $selectedFriends = [];

    #[On('vk-row-selected')]
    public function selectRow(string $id, bool $checked): void
    {
        $selected = array_map('strval', $this->selectedFriends);

        if ($checked) {
            $selected[] = $id;
        } else {
            $selected = array_diff($selected, [$id]);
        }

        $this->selectedFriends = array_values(array_unique($selected));
    }

    public function toggleSelectPage(): void
    {
        if ($this->activeTab !== 'friends') {
            return;
        }

        $ids = array_map('strval', $this->pageFriendIds);
        $selected = array_map('strval', $this->selectedFriends);
        $allSelected = $ids !== [] && count(array_intersect($ids, $selected)) === count($ids);

        $this->selectedFriends = $allSelected
            ? array_values(array_diff($selected, $ids))
            : array_values(array_unique(array_merge($selected, $ids)));
    }

    public function render(): View
    {
        $selectedIds = array_map('strval', $this->selectedFriends);
        $pageIds = array_map('strval', $this->pageFriendIds);

        return view('livewire.vk_manager.people-table', [
            'selectedIds' => $selectedIds,
            'allPageSelected' => $pageIds !== []
                && count(array_intersect($pageIds, $selectedIds)) === count($pageIds),
            'listTitle' => [
                'friends' => 'Друзья',
                'followers' => 'Подписчики',
                'requests' => 'Исходящие заявки',
            ][$this->activeTab] ?? '',
        ]);
    }
}
