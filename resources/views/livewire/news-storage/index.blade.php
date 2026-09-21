<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
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

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Заголовок</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Статус показа</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Медиа</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Дата</th>
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
                            @if($news->source)
                                <div class="text-xs mt-0.5">
                                    <a href="{{ $news->source->url }}" target="_blank" rel="noopener noreferrer" class="text-indigo-500 hover:text-indigo-700 underline">{{ $news->source->name }}</a>
                                </div>
                            @endif
                            @if($news->summary)
                                <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $news->summary }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <select wire:change="updateStatus({{ $news->id }}, $event.target.value)"
                                    class="text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                {{ $news->status === 'published' ? 'border-green-300 text-green-800 bg-green-50' : '' }}
                                {{ $news->status === 'new' ? 'border-blue-300 text-blue-800 bg-blue-50' : '' }}
                                {{ $news->status === 'archived' ? 'border-gray-300 text-gray-800 bg-gray-50' : '' }}
                                {{ !in_array($news->status, ['published', 'new', 'archived']) ? 'border-yellow-300 text-yellow-800 bg-yellow-50' : '' }}">
                                @foreach(\App\Livewire\NewsStorage\Index::STATUSES as $value => $label)
                                    <option value="{{ $value }}" {{ $news->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-3">
                            <select wire:change="updateStatusShow({{ $news->id }}, $event.target.value)"
                                    class="text-xs rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                {{ $news->status_show === 'надо рассказать' ? 'border-yellow-300 text-yellow-800 bg-yellow-50' : '' }}
                                {{ $news->status_show === 'рассказал' ? 'border-purple-300 text-purple-800 bg-purple-50' : '' }}">
                                <option value="">—</option>
                                @foreach(\App\Livewire\NewsStorage\Index::STATUSES_SHOW as $value => $label)
                                    <option value="{{ $value }}" {{ $news->status_show === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
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
