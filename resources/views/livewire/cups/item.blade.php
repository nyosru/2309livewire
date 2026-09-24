<div class="mb-5 break-inside-avoid">
    <div class="relative block bg-white rounded-lg shadow-lg overflow-hidden">

        @if( $i->photos->isNotEmpty() )
            <img src="{{ $i->photos->first()->mini_url }}" loading="lazy" class="
{{--            aspect-square --}}
            w-full"/>
        @endif

{{--        @if( !empty($i['opis']) )--}}
{{--            <div class="px-6 pt-4">--}}
{{--                <p class="text-sm text-gray-600">{{ $i['opis'] }}</p>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <div class="px-6 pt-6 pb-2">--}}
            <h5
                style="text-shadow: 2px 0 3px rgba(255, 255, 255, 0.6), -2px 0 3px rgba(255, 255, 255, 0.9),  0 3px 3px rgba(255, 255, 255, 0.6), 0 -2px 3px rgba(255, 255, 255, 0.9);"
                class="
                shadow-lg
                inline absolute left-[10px]
                bottom-[0]
                font-bold text-lg mb-3">{{ $i['name'] }}</h5>
{{--        </div>--}}
    </div>
</div>
