<div class="mx-auto w-full max-w-none px-2 py-6 sm:px-4 lg:px-6">
    <div class="mb-4 flex justify-end">
        @can('manage-stn-news')
            <button type="button" wire:click="$toggle('showCreateForm')" class="mr-2 rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                {{ $showCreateForm ? 'Скрыть форму' : 'Добавить новость' }}
            </button>
        @endcan
        <a href="{{ route('news-storage.admin.topics') }}" wire:navigate class="rounded bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100">Темы новостей</a>
    </div>

    @can('manage-stn-news')
        @if($showCreateForm)
            <form wire:submit="createNews" class="mb-6 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Новая новость</h2>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="lg:col-span-2">
                        <label for="create-title" class="mb-1 block text-sm font-medium text-gray-700">Заголовок</label>
                        <input id="create-title" type="text" wire:model="createTitle" required maxlength="255" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('createTitle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="lg:col-span-2">
                        <label for="create-summary" class="mb-1 block text-sm font-medium text-gray-700">Краткое описание</label>
                        <textarea id="create-summary" wire:model="createSummary" rows="2" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('createSummary') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="lg:col-span-2">
                        <label for="create-content" class="mb-1 block text-sm font-medium text-gray-700">Текст новости</label>
                        <textarea id="create-content" wire:model="createContent" rows="8" required class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('createContent') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="create-source-url" class="mb-1 block text-sm font-medium text-gray-700">Ссылка на источник</label>
                        <input id="create-source-url" type="url" wire:model="createSourceUrl" placeholder="https://…" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('createSourceUrl') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="create-news-date" class="mb-1 block text-sm font-medium text-gray-700">Дата новости</label>
                            <input id="create-news-date" type="date" wire:model="createNewsDate" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('createNewsDate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="create-status" class="mb-1 block text-sm font-medium text-gray-700">Статус</label>
                            <select id="create-status" wire:model="createStatus" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('createStatus') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    @if($topics->where('is_active', true)->isNotEmpty())
                        <fieldset class="lg:col-span-2">
                            <legend class="mb-2 text-sm font-medium text-gray-700">Темы</legend>
                            <div class="flex flex-wrap gap-x-4 gap-y-2">
                                @foreach($topics->where('is_active', true) as $topic)
                                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                        <input type="checkbox" wire:model="createTopicIds" value="{{ $topic->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        {{ $topic->name_ru }}
                                    </label>
                                @endforeach
                            </div>
                            @error('createTopicIds.*') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </fieldset>
                    @endif
                </div>
                <div class="mt-5 flex items-center gap-3">
                    <button type="submit" wire:loading.attr="disabled" class="rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50">Сохранить новость</button>
                    <span wire:loading class="text-sm text-gray-500">Сохраняем…</span>
                </div>
            </form>
        @endif
    @endcan

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по заголовку, тексту, ссылке..."
                   class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <select wire:model.live="statusFilter" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Все статусы</option>
                @foreach(\App\Livewire\NewsStorage\Index::STATUSES as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select wire:model.live="statusShowFilter" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Все статусы показа</option>
                @foreach(\App\Livewire\NewsStorage\Index::STATUSES_SHOW as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="video-blog-read-date-filter" class="mb-1 block text-sm font-medium text-gray-700">Дата видеоблога</label>
            <div class="flex gap-2">
                <input id="video-blog-read-date-filter" type="date" wire:model.live="videoBlogReadDateFilter"
                       class="min-w-0 flex-1 rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @if($videoBlogReadDateFilter)
                    <button type="button" wire:click="$set('videoBlogReadDateFilter', '')" title="Сбросить фильтр даты видеоблога"
                            class="rounded px-3 text-lg text-gray-500 hover:bg-gray-100 hover:text-red-600" aria-label="Сбросить фильтр даты">×</button>
                @endif
            </div>
            @if($videoBlogReadDateFilter)
                <p class="mt-1 text-xs text-gray-500">Результаты отсортированы по номеру новости по возрастанию.</p>
            @endif
        </div>
    </div>

    @if($toastMessage)
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 3000)"
             x-show="show"
             x-transition
             @toast-hide.window="show = false"
             class="mb-4 px-4 py-3 rounded bg-green-500 text-white text-sm shadow">
            {{ $toastMessage }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-x-auto">
        <table class="w-full table-fixed divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Заголовок</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус / показа</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Темы новости</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Медиа</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        <button type="button" wire:click="sortByDate" class="hover:text-indigo-600">
                            Дата {{ $this->dateSortDirection === 'desc' ? '↓' : '↑' }}
                        </button>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата / № видеоблога</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($newsList as $news)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $news->id }}</td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">
                                <a href="{{ route('news-storage.show', $news->id) }}" wire:navigate class="hover:text-indigo-600">{{ $news->title }}</a>
                            </div>
                            @if($news->storageSource)
                                <div class="text-xs mt-0.5">
                                    <a href="{{ $news->storageSource->url }}" target="_blank" rel="noopener noreferrer" class="text-indigo-500 hover:text-indigo-700 underline">{{ $news->storageSource->name }}</a>
                                </div>
                            @endif
                            @if(!$news->storageSource && $news->source)
                                <div class="text-xs mt-0.5"><a href="{{ $news->source }}" target="_blank" rel="noopener noreferrer" class="text-indigo-500 hover:text-indigo-700 underline">Источник</a></div>
                            @endif
                            @if($news->summary)
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $news->summary }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @can('manage-stn-news')
                            <div class="space-y-2">
                                <select wire:change="updateStatus({{ $news->id }}, $event.target.value)"
                                        aria-label="Статус новости"
                                        class="w-full max-w-40 text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                    {{ $news->status === 'published' ? 'border-green-300 text-green-800 bg-green-50' : '' }}
                                    {{ $news->status === 'new' ? 'border-blue-300 text-blue-800 bg-blue-50' : '' }}
                                    {{ $news->status === 'archived' ? 'border-gray-300 text-gray-800 bg-gray-50' : '' }}
                                    {{ !in_array($news->status, ['published', 'new', 'archived']) ? 'border-yellow-300 text-yellow-800 bg-yellow-50' : '' }}">
                                    @foreach(\App\Livewire\NewsStorage\Index::STATUSES as $value => $label)
                                        <option value="{{ $value }}" {{ $news->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <select wire:change="updateStatusShow({{ $news->id }}, $event.target.value)"
                                        aria-label="Статус показа новости"
                                        class="w-full max-w-40 text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                    {{ $news->status_show === 'надо рассказать' ? 'border-yellow-300 text-yellow-800 bg-yellow-50' : '' }}
                                    {{ $news->status_show === 'рассказал' ? 'border-purple-300 text-purple-800 bg-purple-50' : '' }}">
                                    <option value="">—</option>
                                    @foreach(\App\Livewire\NewsStorage\Index::STATUSES_SHOW as $value => $label)
                                        <option value="{{ $value }}" {{ $news->status_show === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                                <div class="space-y-1 text-sm">
                                    <div>{{ $statuses[$news->status] ?? $news->status }}</div>
                                    <div class="text-gray-500">{{ $statusesShow[$news->status_show] ?? $news->status_show ?? '—' }}</div>
                                </div>
                            @endcan
                        </td>
                        <td class="px-4 py-3 align-top">
                            <div class="max-h-28 min-w-60 space-y-1 overflow-y-auto rounded border border-gray-200 bg-gray-50 p-2">
                                @forelse($topics as $topic)
                                    @php($isSelected = $news->topics->contains('id', $topic->id))
                                    @if($topic->is_active || $isSelected)
                                        <div class="flex items-center justify-between gap-2">
                                            <label class="flex min-w-0 items-start gap-2 text-sm text-gray-700" title="{{ $topic->name_en }}">
                                                <input type="checkbox" @checked($isSelected)
                                                       @disabled(!$topic->is_active)
                                                       wire:change="toggleTopic({{ $news->id }}, {{ $topic->id }}, $event.target.checked)"
                                                       class="mt-0.5 rounded border-gray-300 text-indigo-600">
                                                <span class="truncate">{{ $topic->name_ru }} <span class="text-gray-400">({{ $topic->name_en }})</span></span>
                                            </label>
                                        </div>
                                    @endif
                                @empty
                                    <a href="{{ route('news-storage.admin.topics') }}" class="text-sm text-indigo-600">Добавить темы</a>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            @foreach($news->storageMedia as $media)
                                <span class="inline-block mr-1 text-xs px-1.5 py-0.5 bg-gray-100 rounded">{{ $media->type }}</span>
                            @endforeach
                            @foreach($news->media as $media)
                                <span class="inline-block mr-1 text-xs px-1.5 py-0.5 bg-gray-100 rounded">{{ $media->media_type }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">{{ ($news->news_date ?? $news->created_at)?->format('d.m.Y H:i') }}</td>
                        <td class="px-4 py-3">
                            @can('manage-stn-news')
                                <div class="flex flex-col items-start gap-2">
                                    <input type="date" value="{{ $news->videoBlogRead?->read_at?->format('Y-m-d') }}"
                                           wire:change="updateVideoBlogRead({{ $news->id }}, $event.target.value, {{ $news->videoBlogRead?->number ?? 'null' }})"
                                           aria-label="Дата прочтения новости в видеоблоге"
                                           class="w-full max-w-40 rounded border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <div class="flex items-center gap-1">
                                    <input type="number" min="1" max="9999" step="1" maxlength="4" value="{{ $news->videoBlogRead?->number }}"
                                           wire:change="updateVideoBlogRead({{ $news->id }}, '{{ $news->videoBlogRead?->read_at?->format('Y-m-d') ?? '' }}', $event.target.value)"
                                           aria-label="Номер прочитанной новости в видеоблоге"
                                           class="w-16 rounded border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @if($news->videoBlogRead)
                                        <button type="button" wire:click="updateVideoBlogRead({{ $news->id }}, '', '')"
                                                aria-label="Очистить дату и номер прочитанной новости"
                                                title="Очистить дату и номер" class="px-2 py-1 text-gray-500 hover:text-red-600">×</button>
                                    @endif
                                    </div>
                                </div>
                            @else
                                <div>{{ $news->videoBlogRead?->read_at?->format('d.m.Y') ?? '—' }}</div>
                                <div class="text-gray-500">№ {{ $news->videoBlogRead?->number ?? '—' }}</div>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">Нет записей</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $newsList->links() }}
    </div>

    <div class="mt-2 text-sm text-gray-400">
        Всего записей: {{ $newsList->total() }}
    </div>
</div>
