<div class="relative bg-white p-5 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
    @if($isDeleted)
        <div class="absolute top-2 left-2 bg-red-500 text-white p-2 rounded-lg">
            Новость удалена
        </div>
    @endif


    {{--        <pre style="font-size:10px;">{{ print_r($newsItem,true) }}</pre>--}}

    {{--    <div style="max-height:600px; overflow: auto;">--}}
    {{--        <pre style="max-height:200px; overflow: auto; font-size:10px;">{{ print_r($newsItem,true) }}</pre>--}}
    {{--        <pre style="max-height:200px; overflow: auto; font-size:10px;">{{ print_r($newsItem->photos,true) }}</pre>--}}
    {{--        @foreach( $newsItem->photos as $ph )--}}
    {{--            <img src="/storage/{{ $ph->image_path }}"/>--}}
    {{--            <br/>--}}
    {{--        @endforeach--}}
    {{--    </div>--}}

    <h2 class="text-xl font-semibold mb-2">{{ $newsItem->title }}</h2>
{{--        ++--}}
{{--    <p class="text-gray-600 mb-4">{{ $newsItem->summary }}</p>--}}
{{--        ----}}
{{--    <p class="text-gray-600 mb-4">{{ $newsItem->content }}</p>--}}
    @if( !empty($newsItem->published_at) )
        <p class="text-gray-500 text-sm mb-4">Опубликовано: {{ $newsItem->published_at->format('d M Y') }}</p>
    @endif

{{--        <p class="text-gray-500 text-sm mb-4">Источник: <a href="{{ $newsItem->source }}"--}}
{{--                                                       target="_blank">{{ $newsItem->source }}</a></p>--}}

    @if ($newsItem->firstPhoto())
        <img class="w-full h-48 object-cover rounded-lg mb-4"
             src="{{ asset('storage/' . $newsItem->firstPhoto()->image_path) }}" alt="{{ $newsItem->title }}">
    @endif

    @if (request()->has('ss'))
        <button wire:click="deleteNews" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>
