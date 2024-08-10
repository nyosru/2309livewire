<div class="p-6 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
    @if ($poster)
        <h2 class="text-2xl font-semibold mb-4">{{ $poster->title }}</h2>

        <p class="text-gray-700 mb-4">{{ $poster->description }}</p>
        <p class="text-gray-600 mb-2">Дата проведения: {{ date('d.m.Y', strtotime($poster->event_date)) }}</p>
        @if($poster->end_date)
            <p class="text-gray-600 mb-2">Дата окончания: {{ date('d.m.Y', strtotime($poster->end_date)) }}</p>
        @endif
        @if($poster->buy_tickets_link)
            <p class="mb-2"><a href="{{ $poster->buy_tickets_link }}" class="text-blue-500 hover:underline">Купить билеты</a></p>
        @endif
        @if($poster->source_link)
            <p class="mb-2"><a href="{{ $poster->source_link }}" class="text-blue-500 hover:underline">Источник</a></p>
        @endif

        @if(!empty($poster->images))
            <div class="relative mt-4">
                <div class="flex overflow-x-auto">
                    @foreach($poster->images as $image)
                        <div class="flex-shrink-0 w-full max-w-[800px]">
                            <img src="{{ asset('storage/' . $image) }}" alt="Image" class="w-full h-auto">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="{{ route('afisha.list') }}" class="text-blue-500 hover:underline mt-4 block">Вернуться к списку афиш</a>
    @else
        <p>Афиша не найдена.</p>
    @endif
</div>
