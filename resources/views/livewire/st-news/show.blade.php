<div class="
xmax-w-3xl
max-w-[75%]
mx-auto py-6 sm:px-6 lg:px-8">
    <div class="">

        <h1 class="text-3xl font-bold mb-4">{{ $news->title }}</h1>

        @if( !empty($news->published_at) )
            <p class="text-gray-600 mb-6">{{ $news->published_at->format('d.m.Y') }}</p>
        @endif

        {{--        <div class="text-lg text-gray-800 leading-7">--}}
        {{--            {{ $news->content }}--}}
        {{--        </div>--}}

        @if ($news->firstPhoto())
            <div class="mt-6">
                <img
                    {{--                    src="{{ asset('storage/' . $news->firstPhoto()->image_path) }}" --}}
                    src="{{ $news->firstPhoto()->image_path }}"
                    alt="{{ $news->title }}"
                    {{--                    class="w-full h-auto rounded-md"--}}
                    class="w-[30%] float-left pr-2 h-auto rounded-md"
                >
            </div>
        @endif

        <p>{{ $news->content }}</p>

        @if ($news->source)
            <div class="mt-4">
                <a href="{{ $news->source }}" target="_blank" class="text-blue-500 hover:underline">
                    Читать на источнике
                </a>
            </div>
        @endif

    </div>
</div>
