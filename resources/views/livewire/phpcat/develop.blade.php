<div id="develop-head">
    <div class="block bg-blue-200">
        <div class="container mx-auto py-5">
            <h1 class="text-[2rem] font-bold">
                @if(!empty($show_id))
                    <a href="#" wire:click.prevent="setShowIdNull"
                       class="text-blue-700 underline"
                    >Компоненты</a>
                    / {{ $item->title }}
                @else
                    Компоненты для программистов
                @endif
            </h1>
        </div>
    </div>
    <div class="container mx-auto xpy-5"
    >

        {{--        show_id: {{ $show_id  }}--}}

        @if(!empty($show_id))
                <livewire:Phpcat.develop-item-full :item="$item"/>
        @else

            {{--            <div wire:transition.out.opacity.duration.200ms>--}}

            {{--    {{ $items->links() }}--}}

            {{-- <div class="gap-2 columns-2xs columns-3md columns-5"> --}}
            {{-- <div class="flex flex-row:md gap-5"> --}}
            {{-- <div class="flex flex-wrap gap-5"> --}}
            <div
                class="grid grid-cols-1 md:grid-cols-1
            lg:grid-cols-1
            xl:grid-cols-2
            gap-4 grid-auto-rows: auto; py-5"
                {{--        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 grid-auto-rows: auto; py-5"--}}
            >
                {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
                {{-- news --}}
                {{-- {{ $data }} --}}
                @foreach ($items as $i)

                    <a
{{--                        wire:navigate--}}
{{--                        href="/develop/{{ $i->id }}"--}}
                        href="#"
                       class="block" target="_blank"
                       wire:click.prevent="setShowId({{$i->id}})"
                    >

                        <div class="flex-1">

                            <img src="{{ $i->img_url }}" class="float-left pr-3 pb-2 max-w-[150px]"/>

                            {{--                    id: {{$i['id'] }}--}}
                            {{-- {{ print_r($post) }} --}}
                            <h2 class="
                    background-radial-gradient
                    xbg-green-100 pt-2 pb-2 text-[2rem]">{{ $i->title }}</h2>
                            {{-- <p>{{ $post->photo }}</p> --}}

                            <p class="text-blue-500 text-[1.5rem] hover:underline">{{ $i->link_title }}</p>
                            <p>{{ $i->opis }}</p>
                            <Br clear="all"/>

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
            {{--            </div>--}}

            {{--    {{ $items->links() }}--}}

        @endif

    </div>

</div>
