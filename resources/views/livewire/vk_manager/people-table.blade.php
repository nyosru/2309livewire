<section id="{{ $activeTab }}" class="tab-content {{ $activeTab === 'friends' && $showOnlyNameAndId ? 'only-name-id' : '' }}">
    @if($activeTab === 'friends')
        <div class="friend-list-actions">
            <button type="button" class="button secondary" wire:click="toggleSelectPage">
                {{ $allPageSelected ? 'Снять выбор' : 'Выбрать все' }}
            </button>
            <button id="start-friend-removal" type="button" class="button danger">Удалить выбранных</button>
        </div>
        <div id="removal-status" class="message" role="status" aria-live="polite" wire:ignore hidden></div>
        <div class="friend-columns" aria-label="Сортировка списка друзей">
            <span class="check-col" title="Выбор">✓</span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('name')">Имя {{ $sortField === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('vk_id')">VK ID {{ $sortField === 'vk_id' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('favorite')">Избранное {{ $sortField === 'favorite' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('comment')">Комментарий {{ $sortField === 'comment' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('friend_days')">Дней в друзьях {{ $sortField === 'friend_days' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
        </div>
    @else
        <p class="muted" style="margin-top:14px">
            {{ $activeTab === 'followers' ? 'Комментарии и отметки избранного доступны так же, как в списке друзей.' : 'Заявки в друзья, которые вы отправили и которые ещё не приняты.' }}
        </p>
        <div class="contact-columns" aria-label="Сортировка контактов">
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('name')">Имя {{ $sortField === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('vk_id')">VK ID {{ $sortField === 'vk_id' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('favorite')">Избранное {{ $sortField === 'favorite' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
            <span><button type="button" class="sort-button" wire:click="$parent.sortBy('comment')">Комментарий {{ $sortField === 'comment' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}</button></span>
        </div>
    @endif

    <div class="list contact-list {{ $activeTab === 'friends' ? 'friend-list' : '' }}" @if($activeTab === 'friends') id="friends-list" @endif>
        @forelse($people as $person)
            <livewire:vk-manager.person-row
                :person="$person"
                :active-tab="$activeTab"
                :selected="in_array((string) $person['id'], $selectedIds, true)"
                :key="'row-'.$activeTab.'-'.$person['id']"
            />
        @empty
            <p class="muted">@if($showOnlyFavorites)Избранных контактов в этом списке нет.@elseif($hideFavorites)После скрытия избранных список пуст.@elseif(!$hasSyncedData){{ $listTitle }} пока не загружены в историю. Откройте «Данные в БД» и нажмите «Обновить состояние».@else{{ $listTitle }} нет.@endif</p>
        @endforelse
    </div>

    <nav class="pagination" aria-label="Страницы: {{ $listTitle }}">
        @if($page > 1)<button type="button" wire:click="$parent.goToPage('{{ $activeTab }}', {{ $page - 1 }})">Назад</button>@endif
        <span>{{ $listTitle }}: страница {{ $page }} из {{ $pages }} · по 200</span>
        @if($page < $pages)<button type="button" wire:click="$parent.goToPage('{{ $activeTab }}', {{ $page + 1 }})">Дальше</button>@endif
    </nav>
</section>
