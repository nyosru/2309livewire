<div>
    <div class="block bg-blue-200">
        <div class="container mx-auto py-5">
            <h1 class="text-[2rem] font-bold">Удобные сервисы, присоединяйтесь незаметно</h1>
        </div>
    </div>
    <div class="container mx-auto py-5">

        {{--    {{ $items->links() }}--}}

        {{-- <div class="gap-2 columns-2xs columns-3md columns-5"> --}}
        {{-- <div class="flex flex-row:md gap-5"> --}}
        {{-- <div class="flex flex-wrap gap-5"> --}}
        <div
            class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-4 grid-auto-rows: auto; py-5"
            {{--        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 grid-auto-rows: auto; py-5"--}}
        >
            {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
            {{-- news --}}
            {{-- {{ $data }} --}}
            @foreach ($items as $i)
                <a href="{{ $i->link }}" class="block" target="_blank" >
                <div class="flex-1">

                    <img src="{{ $i->img_url }}" class="float-left pr-3 pb-2 max-w-[150px]"/>

{{--                    id: {{$i['id'] }}--}}
                    {{-- {{ print_r($post) }} --}}
                    <h2 class="
                    background-radial-gradient
                    xbg-green-100 pt-2 pb-2 text-[2rem]">{{ $i->title }}</h2>
                    {{-- <p>{{ $post->photo }}</p> --}}

                    <p class="text-blue-500 text-[1.5rem] hover:underline" >{{ $i->link_title }}</p>
                    <p>{{ $i->opis }}</p>
                    <Br/>

                    @if(1==2)
                    <div
                        style="max-height: 175px; overflow: auto; font-size: 12px; border: 1px solid green; padding: 3px;">
                        {{ str_replace('"','" ',json_encode($i,true)) }}
                    </div>
                    @endif

                {{--<br clear="all" />--}}
                </div>
                </a>
            @endforeach

        </div>

        {{--    {{ $items->links() }}--}}

    </div>

</div>
