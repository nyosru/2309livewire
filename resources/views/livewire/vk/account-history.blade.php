<div class="account-history">
    @php
        $fieldLabels = [
            'first_name' => 'Имя', 'last_name' => 'Фамилия', 'first_name_nom' => 'Имя (именительный падеж)',
            'first_name_gen' => 'Имя (родительный падеж)', 'first_name_dat' => 'Имя (дательный падеж)',
            'first_name_acc' => 'Имя (винительный падеж)', 'first_name_ins' => 'Имя (творительный падеж)',
            'first_name_abl' => 'Имя (предложный падеж)', 'last_name_nom' => 'Фамилия (именительный падеж)',
            'last_name_gen' => 'Фамилия (родительный падеж)', 'last_name_dat' => 'Фамилия (дательный падеж)',
            'last_name_acc' => 'Фамилия (винительный падеж)', 'last_name_ins' => 'Фамилия (творительный падеж)',
            'last_name_abl' => 'Фамилия (предложный падеж)', 'nickname' => 'Короткое имя',
            'screen_name' => 'Короткий адрес', 'domain' => 'Домен страницы', 'maiden_name' => 'Девичья фамилия',
            'verified' => 'Верифицирован', 'is_verified' => 'Подтверждённый профиль', 'photo_id' => 'ID фотографии',
            'has_photo' => 'Есть фотография', 'photo' => 'Фото', 'photo_rec' => 'Рекомендуемое фото',
            'photo_50' => 'Фото 50 px', 'photo_100' => 'Фото 100 px', 'photo_200_orig' => 'Фото 200 px (оригинал)',
            'photo_200' => 'Фото 200 px', 'photo_400' => 'Фото 400 px', 'photo_400_orig' => 'Фото 400 px (оригинал)',
            'photo_big' => 'Большое фото', 'photo_medium' => 'Среднее фото', 'photo_medium_rec' => 'Рекомендуемое среднее фото',
            'photo_max' => 'Максимальное фото', 'photo_max_orig' => 'Максимальное фото (оригинал)',
            'photo_max_size' => 'Размер максимального фото', 'crop_photo' => 'Фрагмент обложки',
            'sex' => 'Пол', 'bdate' => 'Дата рождения', 'bdate_visibility' => 'Видимость даты рождения',
            'city' => 'Город', 'country' => 'Страна', 'home_town' => 'Родной город', 'timezone' => 'Часовой пояс',
            'language' => 'Язык', 'education' => 'Образование', 'universities' => 'Вузы', 'schools' => 'Школы',
            'career' => 'Карьера', 'military' => 'Военная служба', 'work' => 'Работа', 'contacts' => 'Контактные данные',
            'has_mobile' => 'Указан мобильный телефон', 'mobile_phone' => 'Мобильный телефон',
            'home_phone' => 'Дополнительный телефон', 'site' => 'Сайт', 'connections' => 'Внешние подключения',
            'exports' => 'Экспорты',
        ];
    @endphp

    <section class="panel history-search">
        <h2>Найти контакт</h2>
        <p class="muted">Поиск охватывает только контакты, которые были в друзьях, подписчиках или исходящих заявках вашего аккаунта.</p>
        <div class="search-row">
            <div class="search-field">
                <label for="history-contact-search">Имя или VK ID</label>
                <input id="history-contact-search" type="search" wire:model.live.debounce.250ms="searchTerm" autocomplete="off" placeholder="Начните вводить имя или ID">
                @if($suggestions !== [])
                    <div class="suggestions" role="listbox" aria-label="Контакты из истории вашего аккаунта">
                        @foreach($suggestions as $suggestion)
                            <button type="button" role="option" wire:key="history-suggestion-{{ $suggestion['id'] }}" wire:click="selectPerson({{ $suggestion['id'] }})">
                                @if($suggestion['photo_url'])<img src="{{ $suggestion['photo_url'] }}" alt="">@endif
                                <span><strong>{{ $suggestion['name'] }}</strong><small>VK ID {{ $suggestion['vk_id'] }}</small></span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
            <button type="button" class="button" wire:click="showSelected">Показать</button>
        </div>
        @if($searchError)<p class="message error" role="alert">{{ $searchError }}</p>@endif
        @if($selectedPersonId && ! $showHistory)<p class="muted selected-hint">Выбрано: {{ $searchTerm }}</p>@endif
    </section>

    @if($history)
        <section class="panel selected-person">
            <div class="person-heading">
                @if($history['person']->photo_url)<img src="{{ $history['person']->photo_url }}" alt="">@endif
                <div>
                    <h2>{{ $history['person']->display_name ?: 'Пользователь VK' }}</h2>
                    <p class="muted">VK ID {{ $history['person']->vk_id }}
                        @if($history['person']->domain) · <a href="https://vk.com/{{ $history['person']->domain }}" target="_blank" rel="noopener">vk.com/{{ $history['person']->domain }}</a>@endif
                    </p>
                </div>
            </div>

            <h3>Текущие сохранённые данные</h3>
            @forelse($history['current_data'] as $category)
                <article class="data-card">
                    <h4>{{ $category['label'] }}</h4>
                    <dl>
                        @foreach($category['data'] as $key => $value)
                            <div class="data-item">
                                <dt>{{ $fieldLabels[$key] ?? str($key)->replace('_', ' ')->ucfirst() }}</dt>
                                <dd>
                                    @if(is_array($value) || is_object($value))
                                        <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                                    @elseif(is_bool($value))
                                        {{ $value ? 'Да' : 'Нет' }}
                                    @elseif($value === null || $value === '')
                                        <span class="muted">Не указано</span>
                                    @else
                                        {{ $value }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </article>
            @empty
                <p class="muted">Расширенные данные профиля ещё не сохранены. Список статусов ниже может быть доступен.</p>
            @endforelse
        </section>

        <section class="panel timeline-panel">
            <h3>История изменений</h3>
            <p class="muted">Сверху новые события, ниже старые.</p>
            @forelse($history['events'] as $event)
                <article class="timeline-event {{ $event['kind'] }}" wire:key="history-event-{{ $loop->index }}">
                    <time datetime="{{ $event['at']->toIso8601String() }}">{{ $event['at']->format('d.m.Y H:i:s') }}</time>
                    <div class="event-content">
                        <strong>{{ $event['title'] }}</strong>
                        @if(!empty($event['source']))<span class="event-source">Источник: {{ $event['source'] }}</span>@endif
                        @if($event['kind'] === 'data')
                            @if($event['obsolete_at'])<span class="event-obsolete">Эта версия устарела {{ $event['obsolete_at']->format('d.m.Y H:i:s') }}</span>@else<span class="event-current">Текущая версия</span>@endif
                            <details class="event-data">
                                <summary>Поля этой версии ({{ count($event['data']) }})</summary>
                                <dl>
                                    @foreach($event['data'] as $key => $value)
                                        <div class="data-item">
                                            <dt>{{ $fieldLabels[$key] ?? str($key)->replace('_', ' ')->ucfirst() }}</dt>
                                            <dd>@if(is_array($value) || is_object($value))<pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>@elseif(is_bool($value)){{ $value ? 'Да' : 'Нет' }}@elseif($value === null || $value === '')<span class="muted">Не указано</span>@else{{ $value }}@endif</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </details>
                        @endif
                    </div>
                </article>
            @empty
                <p class="muted">Для этого контакта пока нет записей истории.</p>
            @endforelse
        </section>
    @endif
</div>
