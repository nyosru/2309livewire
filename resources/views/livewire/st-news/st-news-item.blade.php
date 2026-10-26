<div class="stn-news">
    <article class="stn-card relative flex flex-col overflow-hidden rounded-xl border border-neutral-200 bg-white">

        @if($isDeleted)
            <div class="absolute top-3 left-3 z-10 rounded-full bg-red-500 px-2.5 py-1 text-xs font-semibold text-white">
                Новость удалена
            </div>
        @endif

        {{-- Главное — заголовок и фото. Клик по карточке ведёт к новости (И. Манн: один понятный жест). --}}
        <a href="/news/{{ $newsItem->id }}" class="block flex flex-col">

            @if ($newsItem->firstPhoto())
                @if( !empty($newsItem->firstPhoto()->local_photo) )
                    <img class="stn-photo w-full" src="{{ $newsItem->firstPhoto()->local_photo }}" alt="{{ $newsItem->title }}">
                @else
                    <img class="stn-photo w-full" src="{{ $newsItem->firstPhoto()->image_path }}" alt="{{ $newsItem->title }}">
                @endif
            @else
                <div class="stn-photo w-full bg-gradient-to-br from-blue-50 via-white to-orange-50"></div>
            @endif

            <div class="flex flex-1 flex-col p-5">

                {{-- Мета-строка: дата + источник (Мunari: функционально, только нужное) --}}
                <div class="mb-2.5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-neutral-500">
                    @if( !empty($newsItem->published_at) )
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                            {{ $newsItem->published_at->format('d.m.Y') }}
                        </span>
                    @endif
                    @php
                        $srcHost = !empty($newsItem->source) ? parse_url($newsItem->source, PHP_URL_HOST) : null;
                    @endphp
                    @if($srcHost)
                        <span class="rounded-full bg-neutral-100 px-2 py-0.5 font-medium text-neutral-600">{{ $srcHost }}</span>
                    @endif
                </div>

                {{-- Заголовок — король карточки (И. Манн: заголовок продаёт клик) --}}
                <h2 class="stn-headline mb-3 text-lg font-bold leading-snug text-neutral-900">
                    {{ $newsItem->title }}
                </h2>
            </div>

            <div class="mt-auto px-5 pb-5">
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600">
                    Читать дальше
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
            </div>
        </a>

        {{-- Кнопка удаления вынесена из <a> (валидный HTML) --}}
        @if (request()->has('ss'))
            <button wire:click="deleteNews" class="absolute top-3 right-3 z-10 grid h-8 w-8 place-items-center rounded-full bg-white/90 text-neutral-400 shadow-sm ring-1 ring-neutral-200 hover:bg-red-50 hover:text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        @endif

    </article>
</div>
