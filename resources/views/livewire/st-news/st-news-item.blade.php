<div class="relative bg-white p-5 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
    <a href="/news/{{ $newsItem->id }}">
        @if($isDeleted)
            <div class="absolute top-2 left-2 bg-red-500 text-white p-2 rounded-lg">
                Новость удалена
            </div>
        @endif

        <h2 class="text-xl font-semibold mb-2">{{ $newsItem->title }}</h2>
        {{--    <p class="text-gray-600 mb-4">{{ $newsItem->summary }}</p>--}}
        {{--    <p class="text-gray-600 mb-4">{{ $newsItem->content }}</p>--}}
        @if( !empty($newsItem->published_at) )
            {{--        <p class="text-gray-500 text-sm mb-4">Опубликовано: {{ $newsItem->published_at->format('d.m.Y') }}</p>--}}
            <p class="text-gray-500 text-sm mb-4">{{ $newsItem->published_at->format('d.m.Y') }}</p>
        @endif

        @if ($newsItem->firstPhoto())
            @if( !empty($newsItem->firstPhoto()->local_photo) )
                <img class="w-full h-48 object-cover rounded-lg mb-4  border-l-5 border-orange-500"
                     src="{{ $newsItem->firstPhoto()->local_photo }}"
                     alt="{{ $newsItem->title }}">
            @else
                <img class="w-full h-48 object-cover rounded-lg mb-4"
                     src="{{ $newsItem->firstPhoto()->image_path }}"
                     alt="{{ $newsItem->title }}">
            @endif

            {{--             src="{{ asset('storage/' . $newsItem->firstPhoto()->image_path) }}" --}}
        @endif

        @if (request()->has('ss'))
            <button wire:click="deleteNews" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif

    </a>
</div>
