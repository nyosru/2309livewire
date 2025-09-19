<div class="inline-block breadcrumb xfloat-sm-end d-flex flex-wrap text-gray-600 m-3 bg-white rounded px-4">

    @foreach( $menu as $k => $m )

        {{--        если нет имени то пропускаем элемент--}}
        @if( empty($m['name']) )
            @continue
        @endif

        @if($k > 0)
            /
        @endif
        @if( isset($m['link']) && $m['link'] == 'no' )
            <span class="breadcrumb-item active xme-2" aria-current="page">
            @else
                    <span class="hover:bg-orange-200 px-1 breadcrumb-item xme-2"><a
                            wire:navigate href="{{ route($m['route'], ( $m['route-var'] ?? [] ) ) }}"
                        >
                @endif

                        {!! $m['name'] !!}
                        @if( isset($m['link']) && $m['link'] == 'no' )
                </span>
                    @else
                        </a></span>
        @endif
    @endforeach
</div>
