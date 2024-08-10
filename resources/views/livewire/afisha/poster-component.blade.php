<div class="p-6 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Список Афиш</h2>

    <ul class="space-y-4">
        @foreach ($posters as $poster)
            <li class="p-4 bg-gray-100 rounded shadow-md">
                <h3 class="text-lg font-semibold">{{ $poster->title }}</h3>
                <p class="text-gray-700">{{ $poster->description }}</p>
                <p class="text-gray-600">Дата проведения: {{ date('d.m.Y', strtotime($poster->event_date)) }}</p>
                @if($poster->end_date)
                    <p class="text-gray-600">Дата окончания: {{ date('d.m.Y', strtotime($poster->end_date)) }}</p>
                @endif
                <p><a href="{{ $poster->link }}" class="text-blue-500 hover:underline">Перейти к афише</a></p>
                @if($poster->source_link)
                    <p><a href="{{ $poster->source_link }}" class="text-blue-500 hover:underline">Источник</a></p>
                @endif
                @if($poster->buy_tickets_link)
                    <p><a href="{{ $poster->buy_tickets_link }}" class="text-blue-500 hover:underline">Купить билеты</a></p>
                @endif
                @if(!empty($poster->images))
                    <div class="relative mt-4">
                        <img src="{{ asset('storage/' . $poster->images[0]) }}" alt="Image" class="w-full h-auto">
                    </div>
                @endif
                <a href="{{ route('afisha.detail', ['posterId' => $poster->id]) }}" class="text-blue-500 hover:underline mt-2 block">Подробнее</a>
            </li>
        @endforeach
    </ul>
</div>
