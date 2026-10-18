<div class="clubs-admin">
    <header class="clubs-admin__header">
        <div>
            <p>ТТТ72 · управление сайтом</p>
            <h1>Бильярдные клубы</h1>
        </div>
        <nav aria-label="Действия администратора">
            <a href="{{ route('ttt.index') }}" target="_blank">Открыть сайт ↗</a>
            <button type="button" wire:click="logout">Выйти</button>
        </nav>
    </header>

    <main class="clubs-admin__main">
        @if (session()->has('success'))
            <div class="clubs-admin__notice" role="status">{{ session('success') }}</div>
        @endif

        <section class="club-editor" aria-labelledby="club-editor-title">
            <div class="club-editor__heading">
                <div>
                    <p>{{ $editId ? 'Запись #'.$editId : 'Новая запись' }}</p>
                    <h2 id="club-editor-title">{{ $editId ? 'Редактировать клуб' : 'Добавить клуб' }}</h2>
                </div>
                @if ($editId)
                    <button type="button" class="button button--secondary" wire:click="cancelEdit">Отменить редактирование</button>
                @endif
            </div>

            <form wire:submit="save" class="club-form">
                <div class="club-form__grid">
                    <label>
                        <span>Название *</span>
                        <input type="text" wire:model="name" placeholder="Шаровня">
                        @error('name') <small>{{ $message }}</small> @enderror
                    </label>
                    <label>
                        <span>Формат клуба</span>
                        <input type="text" wire:model="type" placeholder="Русский бильярд · пул">
                        @error('type') <small>{{ $message }}</small> @enderror
                    </label>
                    <label>
                        <span>Адрес *</span>
                        <input type="text" wire:model="address" placeholder="ул. Название, 1">
                        @error('address') <small>{{ $message }}</small> @enderror
                    </label>
                    <label>
                        <span>Часы работы *</span>
                        <input type="text" wire:model="hours" placeholder="ежедневно 12:00–02:00">
                        @error('hours') <small>{{ $message }}</small> @enderror
                    </label>
                    <label class="club-form__wide">
                        <span>Ссылка на 2ГИС *</span>
                        <input type="url" wire:model="mapUrl" placeholder="https://2gis.ru/tyumen/firm/...">
                        @error('mapUrl') <small>{{ $message }}</small> @enderror
                    </label>
                    <label>
                        <span>Порядок</span>
                        <input type="number" min="0" max="9999" wire:model="sortOrder">
                        @error('sortOrder') <small>{{ $message }}</small> @enderror
                    </label>
                    <label class="club-form__toggle">
                        <input type="checkbox" wire:model="isActive">
                        <span>Показывать на сайте</span>
                    </label>
                </div>

                <div class="club-photo-editor">
                    <label>
                        <span>Фотография клуба</span>
                        <input type="file" wire:model="image" accept="image/jpeg,image/png,image/webp">
                        <small class="club-form__hint">JPG, PNG или WebP, до 5 МБ. Файлы сохраняются в <code>storage/app/public/ttt/clubs</code>.</small>
                        @error('image') <small>{{ $message }}</small> @enderror
                    </label>
                    <div class="club-photo-editor__preview" wire:loading.class="is-loading" wire:target="image">
                        @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" alt="Предпросмотр новой фотографии">
                        @elseif ($currentImagePath)
                            <img src="{{ $this->imageUrl($currentImagePath) }}" alt="Текущая фотография">
                        @else
                            <span>Фото не выбрано</span>
                        @endif
                    </div>
                </div>

                <button type="submit" class="button button--primary" wire:loading.attr="disabled" wire:target="save,image">
                    {{ $editId ? 'Сохранить изменения' : 'Добавить клуб' }}
                </button>
            </form>
        </section>

        <section class="club-list" aria-labelledby="club-list-title">
            <div class="club-list__heading">
                <div>
                    <p>Каталог</p>
                    <h2 id="club-list-title">Все клубы</h2>
                </div>
                <b>{{ $clubs->count() }}</b>
            </div>

            @forelse ($clubs as $club)
                <article class="club-admin-card" wire:key="club-{{ $club->id }}">
                    <img src="{{ $club->image_url }}" alt="">
                    <div class="club-admin-card__content">
                        <div class="club-admin-card__title">
                            <span>#{{ str_pad($club->sort_order, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3>{{ $club->name }}</h3>
                        </div>
                        <p>{{ $club->type ?: 'Формат не указан' }}</p>
                        <dl>
                            <div><dt>Адрес</dt><dd>{{ $club->address }}</dd></div>
                            <div><dt>Часы</dt><dd>{{ $club->hours }}</dd></div>
                        </dl>
                        <a href="{{ $club->map_url }}" target="_blank" rel="noopener noreferrer">Проверить в 2ГИС ↗</a>
                    </div>
                    <div class="club-admin-card__actions">
                        <button type="button" class="status {{ $club->is_active ? 'status--active' : '' }}" wire:click="toggleVisibility({{ $club->id }})">
                            {{ $club->is_active ? 'Опубликован' : 'Скрыт' }}
                        </button>
                        <button type="button" class="button button--edit" wire:click="edit({{ $club->id }})">Редактировать</button>
                        <button type="button" class="button button--danger" wire:click="delete({{ $club->id }})" wire:confirm="Удалить клуб «{{ $club->name }}»?">Удалить</button>
                    </div>
                </article>
            @empty
                <p class="club-list__empty">Клубов пока нет. Добавьте первую запись через форму выше.</p>
            @endforelse
        </section>
    </main>
</div>
