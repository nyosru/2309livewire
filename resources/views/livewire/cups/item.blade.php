<div class="mb-5 break-inside-avoid">
    <div class="relative block overflow-hidden rounded-lg bg-white shadow-lg"
         @if( $i->photos->isNotEmpty() )
             x-data="{
                 active: 0,
                 photos: {{ Illuminate\Support\Js::from($i->photos->pluck('mini_url')->values()) }},
                 maxRatio: null,
                 galleryHeight: null,
                 resizeObserver: null,
                 init() {
                     Promise.all(this.photos.map((source) => new Promise((resolve) => {
                         const image = new Image();
                         image.onload = () => resolve(image.naturalHeight / image.naturalWidth);
                         image.onerror = () => resolve(0);
                         image.src = source;
                     }))).then((ratios) => {
                         const validRatios = ratios.filter((ratio) => ratio > 0);
                         this.maxRatio = validRatios.length ? Math.max(...validRatios) : 1;
                         this.updateGalleryHeight();
                     });

                     this.$nextTick(() => {
                         this.resizeObserver = new ResizeObserver(() => this.updateGalleryHeight());
                         this.resizeObserver.observe(this.$refs.gallery);
                     });
                 },
                 updateGalleryHeight() {
                     if (this.maxRatio && this.$refs.gallery) {
                         this.galleryHeight = Math.round(this.$refs.gallery.clientWidth * this.maxRatio);
                     }
                 },
                 destroy() {
                     this.resizeObserver?.disconnect();
                 }
             }"
             x-on:mouseleave="active = 0"
         @endif>

        @if( $i->photos->isNotEmpty() )
            <div x-ref="gallery"
                 x-bind:style="galleryHeight ? 'height: ' + galleryHeight + 'px; aspect-ratio: auto;' : ''"
                 class="relative aspect-square w-full bg-white">
                <img src="{{ $i->photos->first()->mini_url }}"
                     x-bind:src="photos[active]"
                     loading="lazy"
                     decoding="async"
                     class="absolute inset-0 h-full w-full object-contain"
                     alt="{{ $i->name }}"/>

                @if( $i->photos->count() > 1 )
                    <div class="absolute inset-0 z-10 flex" aria-label="Фотографии кружки «{{ $i->name }}»">
                        @foreach( $i->photos as $photo )
                            <button type="button"
                                    class="h-full flex-1 cursor-default bg-transparent"
                                    x-on:mouseenter="active = {{ $loop->index }}"
                                    x-on:focus="active = {{ $loop->index }}"
                                    x-on:touchstart="active = {{ $loop->index }}"
                                    aria-label="Показать фото {{ $loop->iteration }} из {{ $i->photos->count() }}">
                            </button>
                        @endforeach
                    </div>

                    <div class="pointer-events-none absolute left-2 right-2 top-2 z-20 flex gap-1" aria-hidden="true">
                        @foreach( $i->photos as $photo )
                            <span class="h-1 flex-1 rounded-full shadow-sm"
                                  x-bind:class="active === {{ $loop->index }} ? 'bg-orange-500' : 'bg-white/80'">
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

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
                pointer-events-none z-20
                inline absolute left-[10px]
                bottom-[0]
                font-bold text-lg mb-3">{{ $i['name'] }}</h5>
{{--        </div>--}}
    </div>
</div>
