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

                @if( !empty($p->local_photo) )
                    <img
                        src="/{{ $news->firstPhoto()->local_photo }}"
                        class="w-[30%] float-left pr-2 h-auto rounded-md border-l-2 border-orange-500"
                        alt="{{ $news->title }}"
                    >
                @else
                    <img
                        src="{{ $news->firstPhoto()->image_path }}"
                        class="w-[30%] float-left pr-2 h-auto rounded-md"
                        alt="{{ $news->title }}"
                    >
                @endif

            </div>
        @endif

        {!! $news->content !!}

        <br clear="all"/>
        <br clear="all"/>
        <div class="flex flex-wrap -mx-2">
            @foreach( $news->photos as $p )
                @if( $news->firstPhoto()->image_path != $p->image_path  )
                    <div class="w-1/2 px-2 mb-4">
                        @if( !empty($p->local_photo) )
                            1
                            <img src="/{{ $p->local_photo }}" class="w-full inline border-l-2 border-orange-500"/>
                        @else
                            2
                            <img src="{{ $p->image_path }}" class="w-full inline"/>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>


        @if ($news->source)
            <div class="mt-4">
                {{--                {{ dd($news->site->site_url) }}--}}
                {{--                {{ dd($news->photos) }}--}}
                <a href="{{ ($news->site->site_url ?? '').$news->source }}" target="_blank"
                   class="text-blue-500 hover:underline">
                    Читать на источнике
                </a>
            </div>
        @endif

    </div>
</div>
