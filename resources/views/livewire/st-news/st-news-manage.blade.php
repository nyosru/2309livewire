<div class="mx-auto mt-8 max-w-6xl pb-10">

    <div class="mb-5 flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="mb-1 text-sm font-semibold uppercase tracking-widest text-orange-500">Админка</p>
            <h1 class="text-3xl font-bold text-neutral-900">Управление новостями</h1>
        </div>

        <label class="block">
            <span class="sr-only">Поиск</span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по заголовку…"
                   class="w-64 rounded-lg border border-neutral-300 bg-white px-3 py-2 text-sm text-neutral-800 placeholder-neutral-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </label>
    </div>

    {{-- Фильтры + счётчики --}}
    <div class="mb-4 flex flex-wrap items-center gap-2">
        @php
            $total = \App\Models\StNews::count();
            $pub = \App\Models\StNews::whereNotNull('published_at')->count();
            $draft = $total - $pub;
        @endphp
        @foreach([['all','Все', $total],['published','Опубликованы', $pub],['draft','Черновики', $draft]] as $tab)
            <button wire:click="$set('filter','{{ $tab[0] }}')"
                    class="rounded-full px-3.5 py-1.5 text-sm font-medium transition-colors {{ $filter === $tab[0] ? 'bg-blue-600 text-white' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                {{ $tab[1] }} <span class="opacity-70">{{ $tab[2] }}</span>
            </button>
        @endforeach
    </div>

    @if($news->count())
        <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white">
            <table class="min-w-full divide-y divide-neutral-200 text-sm">
                <thead class="bg-neutral-50 text-left text-xs uppercase tracking-wide text-neutral-500">
                    <tr>
                        <th class="w-12 px-4 py-3">#</th>
                        <th class="px-4 py-3">Заголовок</th>
                        <th class="w-44 px-4 py-3">Медиа</th>
                        <th class="w-40 px-4 py-3">Опубликовано</th>
                        <th class="w-44 px-4 py-3">Статус</th>
                        <th class="w-44 px-4 py-3">Источник</th>
                        <th class="w-48 px-4 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-100">
                    @foreach($news as $n)
                        @php $isPub = filled($n->published_at); @endphp
                        <tr class="hover:bg-neutral-50">
                            <td class="px-4 py-3 text-neutral-400">{{ $n->id }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-neutral-900">{{ \Illuminate\Support\Str::limit($n->title, 80) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $photos = $n->media->filter(fn ($m) => $m->is_photo);
                                    $videos = $n->media->filter(fn ($m) => $m->is_video);
                                @endphp
                                <div class="flex items-center gap-1.5">
                                    @forelse($photos->take(4) as $m)
                                        <a href="{{ $m->url }}" target="_blank" rel="noopener" title="{{ $m->alt ?? 'Фото' }}" class="block h-9 w-9 flex-none overflow-hidden rounded-md border border-neutral-200 bg-neutral-100">
                                            <img src="{{ $m->url }}" alt="{{ $m->alt ?? '' }}" class="h-full w-full object-cover" loading="lazy">
                                        </a>
                                    @empty
                                        <span class="text-xs text-neutral-400">—</span>
                                    @endforelse
                                    @if($photos->count() > 4)
                                        <span class="flex h-9 w-9 flex-none items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-semibold text-neutral-500">+{{ $photos->count() - 4 }}</span>
                                    @endif
                                    @if($videos->count())
                                        <span class="flex h-9 w-9 flex-none items-center justify-center rounded-md border border-neutral-200 bg-neutral-50 text-xs font-medium text-neutral-500" title="{{ $videos->count() }} видео">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-neutral-500">
                                {{ $isPub ? $n->published_at->format('d.m.Y H:i') : '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($isPub)
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Опубликована</span>
                                @else
                                    <span class="rounded-full bg-neutral-200 px-2.5 py-1 text-xs font-semibold text-neutral-600" title="Авто-публикация через {{ $n->daysToPublish() }} дн. при добавлении новых новостей (или опубликовать вручную)">Черновик · авто {{ $n->daysToPublish() }} дн.</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-neutral-500">
                                @php $host = $n->source ? parse_url($n->source, PHP_URL_HOST) : null; @endphp
                                {{ $host ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/news/{{ $n->id }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Открыть">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                    </a>
                                    <button wire:click="togglePublish({{ $n->id }})" wire:loading.attr="disabled"
                                            class="rounded-md px-2.5 py-1 text-xs font-semibold {{ $isPub ? 'bg-neutral-100 text-neutral-700 hover:bg-neutral-200' : 'bg-green-600 text-white hover:bg-green-700' }}"
                                            title="{{ $isPub ? 'Снять с публикации' : 'Опубликовать' }}">
                                        {{ $isPub ? 'Скрыть' : 'Опубликовать' }}
                                    </button>
                                    <button wire:click="deleteNews({{ $n->id }})" wire:confirm="Удалить новость?" wire:loading.attr="disabled"
                                            class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600 hover:bg-red-100" title="Удалить">
                                        Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 mx-auto w-auto max-w-md">
            {{ $news->links('pagination.custom_st_news') }}
        </div>
    @else
        <div class="rounded-xl border border-dashed border-neutral-300 bg-neutral-50 px-6 py-14 text-center">
            <p class="text-lg font-semibold text-neutral-800">Новости не найдены</p>
            <p class="mt-1 text-sm text-neutral-500">Добавьте новости через API или создайте вручную.</p>
        </div>
    @endif

</div>
