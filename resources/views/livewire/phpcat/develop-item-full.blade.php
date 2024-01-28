<div
    class="border-l-[2rem] border-blue-200 pl-5 pt-5"
    style="min-height: 60vh;"
>

    <img src="{{ $item->img_url }}" class="float-left pr-5"/>

    <p>{{ $item->opis }}</p>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 my-3">

        @if( !empty($item->github ) )
            <a href="{{$item->github}}" target="_blank" class="text-blue-600 hover:underline p-3">
                <img src="/logo/github.png" class="w-[64px] float-left mr-4"/> GitHub репозиторий
                <br/>
                {{ str_replace( 'https://github.com', '' , $item->github ) }}
            </a>
        @endif

        @if( !empty($item->packagist ) )
            <a href="{{$item->packagist}}" target="_blank" class="text-blue-600 hover:underline p-3">
                <img src="/logo/packagist.png" class="w-[64px] float-left mr-4"/> Composer пакет
                <br/>
                {{ str_replace( 'https://packagist.org/packages', '' , $item->packagist ) }}
            </a>
        @endif

    </div>

    @if( !empty($item->how_start ) )
        <h3 class="block my-3 text-2xl bg-green-200 p-4">Быстрый старт</h3>
        <div class="pl-5">
            {{ $item->how_start }}
        </div>
    @endif

{{--    <br clear="all"/>--}}
{{--    item: {{ $item }}--}}

</div>

{{--<script>--}}
{{--    document.querySelector('#develop-head').scrollIntoView({ behavior: 'smooth' });--}}
{{--</script>--}}
