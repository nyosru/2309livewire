<div class="p-6 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
    123
    @if($poster)
        <h1 class="text-3xl font-bold mb-4">{{ $poster->title }}</h1>
        <p class="text-gray-700 mb-4">{!! nl2br(e($poster->description)) !!}</p>

        @if($poster->images->isNotEmpty())
            <div class="relative mt-4">
                @foreach($poster->images as $image)
                    <img src="{{ $image->url }}" alt="{{ $image->title }}" class="w-full h-auto mb-2">
                @endforeach
            </div>
        @endif

        @if($poster->event_date)
            <p class="text-gray-600">Дата проведения: {{ date('d.m.Y H:i', strtotime($poster->event_date . ' ' . $poster->event_time)) }}</p>
        @endif

        @if($poster->end_date)
            <p class="text-gray-600">Дата окончания: {{ date('d.m.Y', strtotime($poster->end_date)) }}</p>
        @endif

        @if($poster->link)
            <p><a href="{{ $poster->link }}" target="_blank" class="text-blue-500 hover:underline">Перейти к афише</a></p>
        @endif

        @if($poster->source_link)
            <p><a href="{{ $poster->source_link }}" target="_blank" class="text-blue-500 hover:underline">Источник</a></p>
        @endif

        @if($poster->buy_tickets_link && now()->lt(new \DateTime($poster->event_date . ' ' . $poster->event_time)))
            <p><a href="{{ $poster->buy_tickets_link }}" class="text-blue-500 hover:underline">Купить билеты</a></p>
        @endif
    @else
        <p>Афиша не найдена.</p>
    @endif
</div>
