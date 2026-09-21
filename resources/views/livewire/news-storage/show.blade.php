<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-4">
        <a href="{{ route('news-storage.index') }}" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-800">&larr; К списку</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $news->title }}</h1>

            @if($news->source)
                <div class="text-sm text-gray-500 mb-4">
                    Источник:
                    <a href="{{ $news->source->url }}" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-800 underline">
                        {{ $news->source->name }}
                    </a>
                </div>
            @endif

            <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-6">
                <span>Статус:
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $news->status === 'new' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $news->status === 'archived' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ !in_array($news->status, ['published', 'new', 'archived']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                        {{ \App\Livewire\NewsStorage\Index::STATUSES[$news->status] ?? $news->status }}
                    </span>
                </span>
                @if($news->status_show)
                    <span>Статус показа:
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $news->status_show === 'надо рассказать' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $news->status_show === 'рассказал' ? 'bg-purple-100 text-purple-800' : '' }}">
                            {{ \App\Livewire\NewsStorage\Index::STATUSES_SHOW[$news->status_show] ?? $news->status_show }}
                        </span>
                    </span>
                @endif
                <span>Создано: {{ $news->created_at->format('d.m.Y H:i') }}</span>
                @if($news->updated_at && $news->updated_at != $news->created_at)
                    <span>Обновлено: {{ $news->updated_at->format('d.m.Y H:i') }}</span>
                @endif
            </div>

            @if($news->url)
                <div class="mb-6">
                    <span class="text-sm text-gray-500">Ссылка на оригинал:</span>
                    <a href="{{ $news->url }}" target="_blank" rel="noopener noreferrer" class="block text-indigo-600 hover:text-indigo-800 underline break-all">
                        {{ $news->url }}
                    </a>
                </div>
            @endif

            @if($news->summary)
                <div class="mb-6">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Кратко</h2>
                    <p class="text-gray-700">{{ $news->summary }}</p>
                </div>
            @endif

            @if($news->content)
                <div class="mb-6">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Содержание</h2>
                    <div class="prose prose-sm max-w-none text-gray-800 whitespace-pre-wrap">{{ $news->content }}</div>
                </div>
            @endif

            @if($news->media->isNotEmpty())
                <div>
                    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-2">Медиа</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($news->media as $media)
                            <div class="border rounded-lg p-2 bg-gray-50">
                                @if(in_array($media->type, ['image', 'photo']))
                                    <img src="{{ $media->url }}" alt="" class="w-full h-48 object-cover rounded" loading="lazy">
                                @else
                                    <a href="{{ $media->url }}" target="_blank" rel="noopener noreferrer" class="text-indigo-600 hover:text-indigo-800 underline text-sm break-all">
                                        {{ $media->type }} &mdash; {{ $media->url }}
                                    </a>
                                @endif
                                <div class="text-xs text-gray-500 mt-1">{{ $media->type }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
