<div class="mb-5 break-inside-avoid">
    <div class="relative block bg-white rounded-lg shadow-lg overflow-hidden">

        @if( $i->photos->isNotEmpty() )
            <img src="{{ $i->photos->first()->mini_url }}" loading="lazy" class="
{{--            aspect-square --}}
            w-full"/>
        @endif

        @if( !empty($i['opis']) )
            <div class="px-6 pt-4">
                <p class="text-sm text-gray-600">{{ $i['opis'] }}</p>
            </div>
        @endif

        <div class="px-6 pt-6 pb-2">
            <h5 class="font-bold text-lg mb-3">{{ $i['name'] }}</h5>
        </div>
    </div>
</div>
