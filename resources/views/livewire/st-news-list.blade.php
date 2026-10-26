<div class="stn-news">
    <section class="mx-auto mt-12 mb-16">

        @if (request()->has('ss'))
            <div class="mb-10">
                @livewire('st-news-create')
            </div>
        @endif

        {{-- Заголовок секции: сетка по Брокману — чёткий заголовок, подзаголовок с пользой, выравнивание --}}
        <div class="mb-8 border-b border-neutral-200 pb-5">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="mb-2 text-sm font-semibold uppercase tracking-widest text-orange-500">Тюмень&nbsp;•&nbsp;прямо&nbsp;сейчас</p>
                    <h1 class="tracking-tight text-3xl font-bold text-neutral-900 md:text-4xl">Новости&nbsp;Тюмени</h1>
                </div>
                <p class="text-right text-sm text-neutral-500 max-w-sm">
                    Отборные события города: свежие материалы, проверенные источники и&nbsp;одна удобная лента.
                </p>
            </div>
        </div>

        @if ($news->count() > 0)

            {{-- Сетка карточек --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($news as $item)
                    @livewire('st-news.st-news-item', ['newsItem' => $item], key($item->id))
                @endforeach
            </div>

            <div class="mt-10 mb-4 mx-auto w-auto max-w-md">
                {{ $news->links('pagination.custom_st_news') }}
            </div>

        @else
            {{-- Пустое состояние: дружелюбное, с призывом к действию (И. Манн) --}}
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 px-6 py-16 text-center">
                <p class="mb-2 text-lg font-semibold text-neutral-800">Сейчас в&nbsp;ленте пусто</p>
                <p class="mx-auto mb-6 max-w-md text-neutral-500">Мы уже готовим свежие тюменские новости — загляните чуть позже.</p>
                <a href="https://vk.com/tymenskie" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    Подписаться на&nbsp;наш ВКонтакте
                </a>
            </div>
        @endif

    </section>
</div>
