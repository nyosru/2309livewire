<div class="container mx-auto mt-10">

    @if (request()->has('ss'))
        <div class="mb-10">
            @livewire('st-news-create')
        </div>
    @endif

    {{--    <h1 class="text-3xl font-bold mb-6 text-center">Новости</h1>--}}

    @if ($news->count() > 0)

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                @livewire('st-news.st-news-item', ['newsItem' => $item], key($item->id))
            @endforeach
        </div>

        <div class="mt-6">
            {{ $news->links() }}
        </div>

    @else
        <p class="text-center text-gray-500">Новости ещё не подвезли</p>
    @endif

</div>
