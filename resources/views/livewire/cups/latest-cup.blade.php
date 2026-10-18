<section class="latest-cup-gradient flex min-h-[350px] items-center px-5 py-6">
    @if( $cup )
        <div class="mx-auto grid w-full max-w-5xl items-center gap-4 md:grid-cols-2 md:gap-7">
            <div class="relative mx-auto h-[350px] w-full max-w-xl overflow-hidden rounded-2xl bg-white shadow-xl"
                 @if( $cup->photos->isNotEmpty() )
                     x-data="{ active: 0, photos: {{ Illuminate\Support\Js::from($cup->photos->pluck('mini_url')->values()) }} }"
                     x-on:mouseleave="active = 0"
                 @endif>
                @if( $cup->photos->isNotEmpty() )
                    <img src="{{ $cup->photos->first()->mini_url }}"
                         x-bind:src="photos[active]"
                         class="h-full w-full object-contain"
                         alt="{{ $cup->name }}"/>

                    @if( $cup->photos->count() > 1 )
                        <div class="absolute inset-0 z-10 flex"
                             aria-label="Фотографии кружки «{{ $cup->name }}»">
                            @foreach( $cup->photos as $photo )
                                <button type="button"
                                        class="h-full flex-1 cursor-default bg-transparent"
                                        x-on:mouseenter="active = {{ $loop->index }}"
                                        x-on:focus="active = {{ $loop->index }}"
                                        x-on:touchstart="active = {{ $loop->index }}"
                                        aria-label="Показать фото {{ $loop->iteration }} из {{ $cup->photos->count() }}">
                                </button>
                            @endforeach
                        </div>

                        <div class="pointer-events-none absolute left-3 right-3 top-3 z-20 flex gap-1"
                             aria-hidden="true">
                            @foreach( $cup->photos as $photo )
                                <span class="h-1 flex-1 rounded-full shadow-sm"
                                      x-bind:class="active === {{ $loop->index }} ? 'bg-orange-500' : 'bg-gray-300/80'">
                                </span>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="flex h-full items-center justify-center text-gray-400">
                        Фотография пока не добавлена
                    </div>
                @endif
            </div>

            <div class="self-center text-center md:text-left">
                <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-orange-600">
                    Последнее пополнение
                </p>
                <h2 class="mb-4 text-3xl font-bold text-gray-900">{{ $cup->name }}</h2>

                @if( filled($cup->opis) )
                    <p class="mb-4 whitespace-pre-line text-gray-700">{{ $cup->opis }}</p>
                @endif

                @if( $mapUrl )
                    <p class="mb-5 text-sm text-gray-600">
                        Координаты: {{ $cup->lat }}, {{ $cup->lon }}
                        <a href="{{ $mapUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="relative z-20 ml-2 font-semibold text-blue-600 underline hover:text-blue-800">
                            Посмотреть на карте
                        </a>
                    </p>
                @else
                    <p class="text-sm text-gray-500">Координаты пока не указаны</p>
                @endif

                @if( $showAdvertisement )
                    <div class="relative mt-5 rounded-lg border border-orange-200 bg-white/70 px-4 pb-4 pt-9">
                        <p class="absolute right-3 top-2 text-xs font-semibold uppercase tracking-wider text-orange-600">
                            На правах рекламы
                        </p>

                        @if( filled($cup->advertising_text) )
                            <p class="mb-3 whitespace-pre-line font-medium text-gray-800">{{ $cup->advertising_text }}</p>
                        @endif

                        <div class="flex flex-wrap justify-center gap-x-5 gap-y-2 text-sm md:justify-start">
                            @if( $advertisingMapUrl )
                                <a href="{{ $advertisingMapUrl }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="font-semibold text-orange-700 underline hover:text-orange-900">
                                    {{ $cup->advertising_address }}
                                </a>
                            @endif

                            @if( $telephoneUrl )
                                <a href="{{ $telephoneUrl }}"
                                   class="font-semibold text-orange-700 underline hover:text-orange-900">
                                    Позвонить: {{ $cup->advertising_phone }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>
