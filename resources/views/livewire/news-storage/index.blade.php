<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Поиск по заголовку, тексту, ссылке..."
                   class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <select wire:model.live="statusFilter" class="w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Все статусы</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Источник</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Заголовок</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Медиа</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($newsList as $news)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $news->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $news->source?->name ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900">
                                <a href="{{ $news->url }}" target="_blank" class="hover:text-indigo-600">{{ $news->title }}</a>
                            </div>
                            @if($news->summary)
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $news->summary }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $news->status === 'new' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $news->status === 'archived' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ !in_array($news->status, ['published', 'new', 'archived']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ $news->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            @foreach($news->media as $media)
                                <span class="inline-block mr-1 text-xs px-1.5 py-0.5 bg-gray-100 rounded">{{ $media->type }}</span>
                            @endforeach
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">{{ $news->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Нет записей</td>
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
