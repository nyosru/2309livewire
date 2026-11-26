<div class="vk-list-manager" id="vk-list-manager">
    <div class="stats" aria-label="Разделы списков VK">
        <button type="button" class="stat stat-button {{ $activeTab === 'friends' ? 'active' : '' }}" aria-pressed="{{ $activeTab === 'friends' ? 'true' : 'false' }}" wire:click="switchTab('friends')">
            <span class="muted">Друзья</span><strong>{{ $dbStats['current_friends'] }}</strong>
        </button>
        <button type="button" class="stat stat-button {{ $activeTab === 'followers' ? 'active' : '' }}" aria-pressed="{{ $activeTab === 'followers' ? 'true' : 'false' }}" wire:click="switchTab('followers')">
            <span class="muted">Подписчики</span><strong>{{ $dbStats['current_followers'] }}</strong>
        </button>
        <button type="button" class="stat stat-button {{ $activeTab === 'requests' ? 'active' : '' }}" aria-pressed="{{ $activeTab === 'requests' ? 'true' : 'false' }}" wire:click="switchTab('requests')">
            <span class="muted">Исходящие заявки</span><strong>{{ $dbStats['current_outgoing_requests'] }}</strong>
        </button>
        <button type="button" class="stat stat-button {{ $activeTab === 'preparing' ? 'active' : '' }}" aria-pressed="{{ $activeTab === 'preparing' ? 'true' : 'false' }}" wire:click="switchTab('preparing')">
            <span class="muted">Подготавливаем заявки</span><strong>{{ $preparingCount }}</strong>
        </button>
        <button type="button" class="stat stat-button {{ $activeTab === 'database' ? 'active' : '' }}" aria-pressed="{{ $activeTab === 'database' ? 'true' : 'false' }}" wire:click="switchTab('database')">
            <span class="muted">Данные в БД</span><span class="stat-note">Сводка и история</span>
        </button>
    </div>
    <p class="stats-total muted">Всего контактов: <strong>{{ $dbStats['current_friends'] + $dbStats['current_followers'] }}</strong></p>

    <div class="panel">
        @if(!in_array($activeTab, ['database', 'preparing'], true))
            <div class="vk-list-filters">
                <label><input type="checkbox" wire:model.live="hideFavorites"> Скрыть избранных</label>
                <label><input type="checkbox" wire:model.live="showOnlyFavorites"> Показывать только избранных</label>
                @if($activeTab === 'friends')
                    <label><input type="checkbox" wire:model.live="showOnlyNameAndId"> Показывать только название и ID</label>
                @endif
                <label class="sort-control">Сортировать:
                    <select wire:model.live="sortField">
                        <option value="name">Имя</option>
                        <option value="vk_id">VK ID</option>
                        <option value="favorite">Избранное</option>
                        <option value="comment">Комментарий</option>
                        @if($activeTab === 'friends')<option value="friend_days">Дней в друзьях</option>@endif
                    </select>
                </label>
                <button type="button" class="button secondary sort-direction" wire:click="toggleSortDirection">{{ $sortDirection === 'asc' ? 'По возрастанию ↑' : 'По убыванию ↓' }}</button>
            </div>
        @endif

        @if($statusMessage)
            <div class="message {{ $statusIsError ? 'error' : '' }}" role="status" aria-live="polite">{{ $statusMessage }}</div>
        @endif

        @if($activeTab === 'database')
            <section id="database" class="tab-content">
                <h2>Сводка данных в БД</h2>
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

                <div class="public-link">
                    <h3>Ссылка с данными для ИИ-агента</h3>
                    <p class="muted" style="margin:0 0 10px">Ссылка открывается без входа на сайт и отдаёт JSON: VK ID и токен текущего аккаунта, а также все ID и ники в трёх списках — друзья, подписчики и исходящие заявки. Для обычного текста добавьте <code>?format=txt</code>.</p>
                    @if($publicUrl)
                        <p class="public-link-url"><a href="{{ $publicUrl }}" target="_blank" rel="noopener noreferrer"><code>{{ $publicUrl }}</code></a></p>
                        <div class="public-link-actions">
                            <button type="button" class="button secondary" data-copy="{{ $publicUrl }}" onclick="navigator.clipboard.writeText(this.dataset.copy).then(() => { this.textContent = 'Скопировано'; });">Скопировать ссылку</button>
                            <button type="button" class="button secondary" wire:click="regeneratePublicLink" wire:confirm="Перевыпустить ссылку? Старая ссылка сразу перестанет работать." wire:loading.attr="disabled">Перевыпустить ссылку</button>
                        </div>
                        <p class="muted tiny" style="margin:10px 0 0">Ссылка даёт доступ к VK-токену без пароля. Передавайте её только тому агенту, которому доверяете; при утечке перевыпустите.</p>
                    @else
                        <p class="muted">Ссылку создать нельзя: у аккаунта нет VK ID.</p>
                    @endif
                </div>

                @if(!$syncRun)
                    <button type="button" class="button" wire:click="startSnapshotSync" wire:loading.attr="disabled" wire:target="startSnapshotSync">Обновить состояние</button>
                @elseif($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_FAILED && $syncRun->error_list !== 'authorization')
                    @if($syncRun->error_page === 0 && $syncRun->error_list !== 'finalizing')
                        <button type="button" class="button" wire:click="retrySnapshotSync" wire:loading.attr="disabled" wire:target="retrySnapshotSync">Повторить подсчёт</button>
                    @elseif($syncRun->error_list === 'finalizing')
                        <button type="button" class="button" wire:click="retrySnapshotSync" wire:loading.attr="disabled" wire:target="retrySnapshotSync">Повторить отправку</button>
                    @endif
                @elseif($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_FAILED && $syncRun->error_list === 'authorization')
                    <a class="button" href="/auth/master">Подключить VK заново</a>
                @endif

                @if($syncRun)
                    @php
                        $syncLists = ['friends' => 'Друзья', 'followers' => 'Подписчики', 'requests' => 'Исходящие заявки'];
                        $syncIsActive = in_array($syncRun->status, [
                            \App\Models\VkManagerSyncRun::STATUS_COUNTING,
                            \App\Models\VkManagerSyncRun::STATUS_RUNNING,
                            \App\Models\VkManagerSyncRun::STATUS_FINALIZING,
                        ], true);
                    @endphp
                    <div class="sync-progress" @if($syncIsActive) wire:poll.1s="advanceSnapshotSync" @endif>
                        <strong>
                            @if($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_COUNTING)
                                Считаю записи списков…
                            @elseif($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_RUNNING)
                                Загружаю страницы по 400 записей…
                            @elseif($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_FINALIZING)
                                Отправляю полученные данные в историю…
                            @elseif($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_READY)
                                Все страницы загружены. Проверьте статусы и отправьте снимок в базу данных.
                            @elseif($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_FAILED)
                                Загрузка остановлена
                            @endif
                        </strong>
                        @if($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_FINALIZING)
                            <div class="sync-commit-progress">
                                Сохранено в историю: {{ number_format((int) data_get($syncRun->progress, 'commit_completed', 0), 0, ',', ' ') }}
                                @if(data_get($syncRun->progress, 'commit_total'))
                                    из {{ number_format((int) data_get($syncRun->progress, 'commit_total'), 0, ',', ' ') }} контактов
                                @else
                                    контактов
                                @endif
                            </div>
                        @endif
                        @if($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_FAILED)
                            <div class="sync-error">
                                Ошибка: {{ $syncRun->error_message }}
                                @if($syncRun->error_list === 'finalizing')
                                    <br>Шаг: применение снимка к истории
                                @elseif($syncRun->error_list === 'authorization')
                                    <br>Проверьте подключение VK, затем повторите обновление.
                                @elseif($syncRun->error_page)
                                    <br>Шаг: {{ $syncLists[$syncRun->error_list] ?? $syncRun->error_list }}, страница {{ $syncRun->error_page }}
                                @else
                                    <br>Шаг: получение общего количества — {{ $syncLists[$syncRun->error_list] ?? $syncRun->error_list }}
                                @endif
                            </div>
                        @endif
                        <div class="sync-lists">
                            @foreach($syncLists as $listKey => $listLabel)
                                @php
                                    $listProgress = $syncRun->progress[$listKey];
                                @endphp
                                <div class="sync-list-group">
                                    <div class="sync-list-row">
                                        <strong>{{ $listLabel }}</strong>
                                    @if($listProgress['count'] === null)
                                        <span class="muted">общее количество ещё не получено</span>
                                    @else
                                        <span>{{ number_format($listProgress['count'], 0, ',', ' ') }} записей · {{ $listProgress['pages'] }} стр. по 400</span>
                                    @endif
                                    </div>
                                    @foreach(($syncPages[$listKey] ?? collect()) as $syncPage)
                                        <div class="sync-page-row sync-page-{{ $syncPage->status }}">
                                            <span>Страница {{ $syncPage->page_number }} · записи {{ (($syncPage->page_number - 1) * 400) + 1 }}–{{ min($syncPage->page_number * 400, $listProgress['count']) }}</span>
                                            <span class="sync-page-status">
                                                @if($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_RUNNING && $syncRun->current_list === $listKey && (int) $syncRun->current_page === (int) $syncPage->page_number)
                                                    <span wire:loading.remove wire:target="advanceSnapshotSync">
                                                        @if($syncPage->status === \App\Models\VkManagerSyncPage::STATUS_LOADING)
                                                            Данные загружаются…
                                                        @else
                                                            Новая
                                                        @endif
                                                    </span>
                                                    <span wire:loading wire:target="advanceSnapshotSync">Загружаю…</span>
                                                @elseif($syncPage->status === \App\Models\VkManagerSyncPage::STATUS_NEW)
                                                    Новая
                                                @elseif($syncPage->status === \App\Models\VkManagerSyncPage::STATUS_LOADING)
                                                    Данные загружаются…
                                                @elseif($syncPage->status === \App\Models\VkManagerSyncPage::STATUS_LOADED)
                                                    Данные загружены
                                                @else
                                                    Ошибка: {{ $syncPage->error_message }}
                                                @endif
                                            </span>
                                            @if($syncPage->status === \App\Models\VkManagerSyncPage::STATUS_ERROR && $syncRun->error_list !== 'authorization')
                                                <button type="button" class="button secondary sync-retry" wire:click="retrySnapshotPage('{{ $listKey }}', {{ $syncPage->page_number }})" wire:loading.attr="disabled" wire:target="retrySnapshotPage">Повторить загрузку</button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @if($syncRun->status === \App\Models\VkManagerSyncRun::STATUS_READY)
                            <div class="sync-submit">
                                <span>Изменения в истории пока не применены.</span>
                                <button type="button" class="button" wire:click="commitSnapshot" wire:loading.attr="disabled" wire:target="commitSnapshot">Отправить полученные данные в базу данных</button>
                            </div>
                        @endif
                    </div>
                @endif
            </section>
        @elseif($activeTab === 'preparing')
            <section id="preparing" class="tab-content">
                <h2>Подготавливаем заявки <span class="muted">({{ $preparingCount }})</span></h2>
                <p class="muted">Здесь отображаются профили, которые вы открыли для добавления в друзья, но которые ещё не появились среди исходящих заявок.</p>
                @if($preparingAttempts->isEmpty())
                    <p class="empty">Пока нет начатых заявок, ожидающих появления в списке исходящих.</p>
                @else
                    <div class="list">
                        @foreach($preparingAttempts as $attempt)
                            <article class="person" wire:key="preparing-{{ $attempt->vk_id }}">
                                @if($attempt->photo_url)<img src="{{ $attempt->photo_url }}" alt="">@else<div></div>@endif
                                <div>
                                    <div class="name">{{ trim(($attempt->first_name ?? '').' '.($attempt->last_name ?? '')) ?: 'Пользователь VK' }}</div>
                                    <div class="tiny muted">VK ID: <a href="https://m.vk.com/id{{ rawurlencode($attempt->vk_id) }}" target="_blank" rel="noopener noreferrer">{{ $attempt->vk_id }}</a></div>
                                    <div class="tiny muted">Начато: {{ $attempt->started_at?->format('d.m.Y H:i') }}</div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        @elseif($activeList)
            <livewire:vk-manager.people-table
                :people="$activeList['people']"
                :active-tab="$activeTab"
                :page="$activeList['page']"
                :pages="$activeList['pages']"
                :count="$activeList['count']"
                :show-only-favorites="$showOnlyFavorites"
                :hide-favorites="$hideFavorites"
                :show-only-name-and-id="$showOnlyNameAndId"
                :sort-field="$sortField"
                :sort-direction="$sortDirection"
                :has-synced-data="filled($dbStats['last_full_sync_at'])"
                :page-friend-ids="$pageFriendIds"
                :key="'people-table'"
            />
        @endif
    </div>
</div>
