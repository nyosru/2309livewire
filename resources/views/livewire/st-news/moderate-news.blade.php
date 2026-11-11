<div class="mx-auto w-full max-w-full p-2 sm:p-4">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold">Модерация новостей</h1>
        @can('manage-news-storage')
            <a href="{{ route('news-storage.admin.topics') }}" class="rounded bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100">Настроить темы</a>
        @endcan
    </div>

    @if($newsToModerate->isEmpty())
        <p>Нет новостей, требующих модерации.</p>
    @else
        <table class="w-full table-fixed border border-gray-200 bg-white text-sm">
            <colgroup>
                <col class="w-[40%]">
                <col class="w-[12%]">
                <col class="w-[30%]">
                <col class="w-[18%]">
            </colgroup>
            <thead>
            <tr>
                <th class="break-words px-2 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-3">Заголовок</th>
                <th class="break-words px-2 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-3">Дата публикации</th>
                <th class="break-words px-2 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-3">Темы новости</th>
                <th class="break-words px-2 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 sm:px-3">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($newsToModerate as $news)
                <tr>
                    <td class="break-words border-t border-gray-200 px-2 py-3 sm:px-3">
                        <div class="font-medium text-gray-900">{{ $news->title }}</div>
                        @if($news->source)
                            <a href="{{ $news->source }}" target="_blank" rel="noopener noreferrer" class="mt-1 block break-all text-sm text-blue-700 underline">{{ $news->source }}</a>
                        @endif
                    </td>
                    <td class="break-words border-t border-gray-200 px-2 py-3 sm:px-3">{{ ($news->news_date ?? $news->published_at ?? $news->created_at)?->format('d.m.Y') }}</td>
                    <td class="border-t border-gray-200 px-2 py-3 sm:px-3">
                        <div class="max-h-28 w-full min-w-0 space-y-1 overflow-y-auto rounded border border-gray-200 bg-gray-50 p-2">
                            @forelse($topics as $topic)
                                <label class="flex items-start gap-2 text-sm text-gray-700" title="{{ $topic->name_en }}">
                                    <input type="checkbox" wire:key="moderation-topic-{{ $news->id }}-{{ $topic->id }}"
                                           @checked(in_array($topic->id, $selectedTopics[$news->id] ?? [], true) || in_array((string) $topic->id, $selectedTopics[$news->id] ?? [], true))
                                           wire:change="toggleSelectedTopic({{ $news->id }}, {{ $topic->id }}, $event.target.checked)"
                                           class="mt-0.5 rounded border-gray-300 text-indigo-600">
                                    <span><strong>{{ $topic->name_ru }}</strong><br><span class="text-gray-500">{{ $topic->name_en }}</span></span>
                                </label>
                            @empty
                                <span class="text-sm text-gray-500">Добавьте темы перед модерацией.</span>
                            @endforelse
                        </div>
                        @error('topics') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </td>
                    <td class="border-t border-gray-200 px-2 py-3 sm:px-3">
                        <div class="flex flex-wrap gap-2">
                        <button class="rounded bg-green-500 px-2 py-2 font-bold text-white hover:bg-green-700 sm:px-3" wire:click="approve({{ $news->id }})">
                            Одобрить
                        </button>
                        <button class="rounded bg-red-500 px-2 py-2 font-bold text-white hover:bg-red-700 sm:px-3" wire:click="reject({{ $news->id }})">
                            Отклонить
                        </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
