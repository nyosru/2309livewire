<div class="vk-list-manager" id="vk-list-manager">
    <div class="stats">
        <div class="stat"><span class="muted">Друзья</span><strong>{{ $dbStats['current_friends'] }}</strong></div>
        <div class="stat"><span class="muted">Подписчики</span><strong>{{ $dbStats['current_followers'] }}</strong></div>
        <div class="stat"><span class="muted">Всего контактов</span><strong>{{ $dbStats['current_friends'] + $dbStats['current_followers'] }}</strong></div>
        <div class="stat"><span class="muted">Исходящие заявки</span><strong>{{ $dbStats['current_outgoing_requests'] }}</strong></div>
    </div>

    <div class="panel">
        <div class="vk-list-filters">
            <label><input type="checkbox" wire:model.live="hideFavorites"> Скрыть избранных</label>
            <label><input type="checkbox" wire:model.live="showOnlyFavorites"> Показывать только избранных</label>
            @if($activeTab === 'friends')
                <label><input type="checkbox" wire:model.live="showOnlyNameAndId"> Показывать только название и ID</label>
            @endif
        </div>

        <div class="tabs" role="tablist" aria-label="Списки VK">
            <button type="button" class="{{ $activeTab === 'friends' ? 'active' : '' }}" wire:click="switchTab('friends')">Друзья ({{ $counts['friends'] }})</button>
            <button type="button" class="{{ $activeTab === 'followers' ? 'active' : '' }}" wire:click="switchTab('followers')">Подписчики ({{ $counts['followers'] }})</button>
            <button type="button" class="{{ $activeTab === 'requests' ? 'active' : '' }}" wire:click="switchTab('requests')">Исходящие заявки ({{ $counts['requests'] }})</button>
            <button type="button" class="{{ $activeTab === 'database' ? 'active' : '' }}" wire:click="switchTab('database')">Данные в БД</button>
        </div>

        @if($statusMessage)
            <div class="message {{ $statusIsError ? 'error' : '' }}" role="status" aria-live="polite">{{ $statusMessage }}</div>
        @endif

        @if($activeTab === 'database')
            <section id="database" class="tab-content">
                <h2>История аккаунта</h2>
                <p class="muted">{{ $dbStats['name'] }} · VK ID {{ $dbStats['vk_id'] }}</p>
                <div class="stats">
                    <div class="stat"><span class="muted">Уникальных контактов</span><strong>{{ $dbStats['unique_people'] }}</strong></div>
                    <div class="stat"><span class="muted">Записей истории</span><strong>{{ $dbStats['membership_records'] }}</strong></div>
                    <div class="stat"><span class="muted">Сейчас в друзьях</span><strong>{{ $dbStats['current_friends'] }}</strong></div>
                    <div class="stat"><span class="muted">Сейчас подписчики</span><strong>{{ $dbStats['current_followers'] }}</strong></div>
                    <div class="stat"><span class="muted">Мои исходящие заявки</span><strong>{{ $dbStats['current_outgoing_requests'] }}</strong></div>
                    <div class="stat"><span class="muted">Завершённых периодов дружбы</span><strong>{{ $dbStats['former_friend_periods'] }}</strong></div>
                    <div class="stat"><span class="muted">Завершённых периодов подписки</span><strong>{{ $dbStats['former_follower_periods'] }}</strong></div>
                    <div class="stat"><span class="muted">Завершённых заявок</span><strong>{{ $dbStats['former_outgoing_request_periods'] }}</strong></div>
                    <div class="stat"><span class="muted">Избранных</span><strong>{{ $dbStats['favorites'] }}</strong></div>
                    <div class="stat"><span class="muted">Контактов с комментарием</span><strong>{{ $dbStats['comments'] }}</strong></div>
                </div>
                <p class="muted">Последнее наблюдение: {{ $dbStats['last_observed_at']?->format('d.m.Y H:i:s') ?? 'ещё не было' }}<br>
                    Последняя полная сверка: {{ $dbStats['last_full_sync_at']?->format('d.m.Y H:i:s') ?? 'ещё не было' }}</p>
                <button type="button" class="button" wire:click="refreshState" wire:loading.attr="disabled" wire:target="refreshState">Обновить состояние</button>
                <span class="muted" wire:loading wire:target="refreshState">Получаю полные списки VK…</span>
            </section>
        @elseif($activeList)
            @php
                $listTitle = ['friends' => 'Друзья', 'followers' => 'Подписчики', 'requests' => 'Исходящие заявки'][$activeTab];
            @endphp
            <section id="{{ $activeTab }}" class="tab-content {{ $activeTab === 'friends' && $showOnlyNameAndId ? 'only-name-id' : '' }}">
                @if($activeTab === 'friends')
                    <div class="friend-list-actions">
                        <button type="button" class="button secondary" wire:click="toggleSelectPage">
                            {{ $pageFriendIds !== [] && count(array_intersect($pageFriendIds, array_map('strval', $selectedFriends))) === count($pageFriendIds) ? 'Снять выбор' : 'Выбрать все' }}
                        </button>
                        <button id="start-friend-removal" type="button" class="button danger">Удалить выбранных</button>
                    </div>
                    <div id="removal-status" class="message" role="status" aria-live="polite" wire:ignore hidden></div>
                    <div class="friend-columns" aria-hidden="true"><span>Выбор</span><span>Аккаунт VK</span><span>Избранное</span><span>Комментарий</span></div>
                @else
                    <p class="muted" style="margin-top:14px">
                        {{ $activeTab === 'followers' ? 'Комментарии и отметки избранного доступны так же, как в списке друзей.' : 'Заявки в друзья, которые вы отправили и которые ещё не приняты.' }}
                    </p>
                    <div class="contact-columns" aria-hidden="true"><span>Аккаунт VK</span><span>Избранное</span><span>Комментарий</span></div>
                @endif

                <div class="list contact-list {{ $activeTab === 'friends' ? 'friend-list' : '' }}" id="{{ $activeTab === 'friends' ? 'friends-list' : '' }}">
                    @forelse($activeList['people'] as $person)
                        @php($vkId = (string) $person['id'])
                        <article class="person friend-row contact-row" data-favorite="{{ $person['manager_favorite'] ? '1' : '0' }}" wire:key="{{ $activeTab }}-{{ $vkId }}">
                            @if($activeTab === 'friends')
                                <div class="friend-row-select"><label class="friend-select"><input class="check" type="checkbox" name="friends[]" value="{{ $vkId }}" wire:model.live="selectedFriends" aria-label="Выбрать {{ $person['first_name'] }}"></label></div>
                            @endif
                            <div class="friend-row-account">
                                @if($person['photo_100'])<img src="{{ $person['photo_100'] }}" alt="">@endif
                                <div><div class="name">@if($person['domain'])<a href="https://vk.com/{{ $person['domain'] }}" target="_blank" rel="noopener">{{ $person['first_name'] }} {{ $person['last_name'] }}</a>@else{{ $person['first_name'] }} {{ $person['last_name'] }}@endif</div><div class="muted tiny">VK ID {{ $vkId }}</div></div>
                            </div>
                            <div class="friend-row-favorite">
                                <button type="button" class="favorite" wire:click="toggleFavorite('{{ $vkId }}')" wire:loading.attr="disabled" wire:target="toggleFavorite('{{ $vkId }}')">{{ $person['manager_favorite'] ? '★ Убрать' : '☆ В избранное' }}</button>
                                @if($person['manager_favorite'])<span class="star" title="Избранный">★</span>@endif
                            </div>
                            <div class="friend-row-comment">
                                @if(filled($person['manager_comment']))<div class="comment">{{ $person['manager_comment'] }}</div>@endif
                                <form class="comment-form" wire:submit="saveComment('{{ $vkId }}')">
                                    <input type="text" maxlength="2000" wire:model.blur="commentDrafts.{{ $vkId }}" value="{{ $person['manager_comment'] }}" placeholder="Комментарий">
                                    <button type="submit" class="button secondary tiny" wire:loading.attr="disabled" wire:target="saveComment('{{ $vkId }}')">Сохранить</button>
                                </form>
                                @error('commentDrafts.'.$vkId)<span class="favorite-error tiny">{{ $message }}</span>@enderror
                                @if($savedComments[$vkId] ?? false)<span class="muted tiny">Сохранено</span>@endif
                            </div>
                        </article>
                    @empty
                        <p class="muted">@if($showOnlyFavorites)Избранных контактов в этом списке нет.@elseif($hideFavorites)После скрытия избранных список пуст.@elseif(!$dbStats['last_full_sync_at']){{ $listTitle }} пока не загружены в историю. Откройте «Данные в БД» и нажмите «Обновить состояние».@else{{ $listTitle }} нет.@endif</p>
                    @endforelse
                </div>

                <nav class="pagination" aria-label="Страницы: {{ $listTitle }}">
                    @if($activeList['page'] > 1)<button type="button" wire:click="goToPage('{{ $activeTab }}', {{ $activeList['page'] - 1 }})">Назад</button>@endif
                    <span>{{ $listTitle }}: страница {{ $activeList['page'] }} из {{ $activeList['pages'] }} · по 200</span>
                    @if($activeList['page'] < $activeList['pages'])<button type="button" wire:click="goToPage('{{ $activeTab }}', {{ $activeList['page'] + 1 }})">Дальше</button>@endif
                </nav>
            </section>
        @endif
    </div>
</div>
