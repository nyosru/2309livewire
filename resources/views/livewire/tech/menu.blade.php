<div class="flex flex-wrap

{{--bg-gray-600--}}
{{--bg-gradient-to-br from-[#042274] to-gray-200--}}
bg-gradient-to-br from-gray-400 to-gray-200
{{--fixed top-0 left-[30%]--}}
{{--my-6--}}
{{--mt-[-50px]--}}
py-1
space-x-1
justify-center ">

    {{--        <pre>{{ print_r($links) }}</pre>--}}

    @if( $type == 'cfa' )

        <a
                href="/"
                wire:navigate
                class="
                   hover:bg-gradient-to-tr
                   hover:from-orange-300
                   hover:to-bg-cyan-300
{{--bg-cyan-300--}}
                bg-gradient-to-br from-[#042274] to-[#2442a4]
                text-white
{{--                   {{ Request::routeIs($v['route']) ? 'bg-orange-300' : 'bg-cyan-300' }}--}}
                     px-2 py-1 whitespace-nowrap
                     rounded"
        >Сайт</a>

        <a
                href="{{route('tech.datar2')}}"
                wire:navigate
                class="
                   hover:bg-gradient-to-tr
                   hover:from-orange-300
                   hover:to-bg-cyan-300
{{--bg-cyan-300--}}
                   {{ str_starts_with(request()->route()->getName(), 'tech.datar2') ? 'bg-orange-300' :
//'bg-cyan-300'
'bg-gradient-to-br from-[#042274] to-[#2442a4] text-white'
 }}
{{--                   {{ Request::routeIs('tech.datar2') ? 'bg-orange-300' : 'bg-cyan-300' }}--}}
                     px-2 py-1 whitespace-nowrap
                     rounded"
        >База знаний</a>
        <a href="{{ route('tech.news.admin',['type'=>$type]) }}"
           wire:navigate
           class="
                   hover:bg-gradient-to-tr
                   hover:from-orange-300
                   hover:to-bg-cyan-300
{{--bg-cyan-300--}}
{{--                   {{ Request::routeIs($v['route']) ? 'bg-orange-300' : 'bg-cyan-300' }}--}}
                   {{ str_starts_with(request()->route()->getName(), 'tech.news') ? 'bg-orange-300' :
//'bg-cyan-300'
'bg-gradient-to-br from-[#042274] to-[#2442a4] text-white'
}}

                                        px-2 py-1 whitespace-nowrap
                     rounded"
        >Новости</a>

    @else

        @foreach( $links as $name => $v )
            @if( !empty($v['permission']) && !empty($v['route']) )
                @permission($v['permission'])
                @if(Route::has($v['route']))
                    <a href="{{route($v['route'])}}"
                       wire:navigate
                       class="
                   hover:bg-gradient-to-tr
                   hover:from-orange-300
                   hover:to-bg-cyan-300
                   {{ Request::routeIs($v['route']) ? 'bg-orange-300' : 'bg-cyan-300' }}
                     px-2 py-1 whitespace-nowrap
                     rounded"
                    >{{ $name }}</a>
                @endif
                @endpermission
            @else
                @if(Route::has($v['route']))
                    <a href="{{route($v['route'])}}"
                       wire:navigate
                       class=" bg-cyan-300 px-2 py-1 whitespace-nowrap rounded
               hover:bg-gradient-to-tr
                   hover:from-orange-300
                   hover:to-bg-cyan-300
                   {{ Request::routeIs($v['route']) ? 'bg-orange-300' : 'bg-cyan-300' }}
               "
                    >{{ $name }}</a>
                @else
                    {{--                --{{$v['route']}}----}}
                @endif
            @endif
        @endforeach
    @endif
</div>
