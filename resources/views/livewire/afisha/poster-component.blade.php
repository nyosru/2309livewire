<div class="p-6 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
    <ul class="space-y-4">
        @foreach ($posters as $poster)
            <li class="p-4 bg-gray-100 rounded shadow-md block">

                <span class="mb-2 text-xl bg-orange-100 p-1"
                      title="Дата проведения">
                    {{ date('d.m.Y', strtotime($poster->event_date)) }}
                    {{-- Проверка времени --}}
                    @if (date('H:i', strtotime($poster->event_time)) !== '00:00')
                        {{ date('H:i', strtotime($poster->event_time)) }}
                    @endif
                </span>
                <br/>

                <a href="{{ route('afisha.afisha.detail', ['posterId' => $poster->id]) }}" class="hover:underline">
                    <h3 class="mb-2 text-2xl font-semibold">{{ $poster->title }}</h3>
                </a>

                {{-- Отображаем первую картинку, если есть --}}
                @if($poster->images && count($poster->images) > 0)
                    <div class="relative mt-1 mr-3 float-left max-w-[40%]">
                        <img src="{{ $poster->images->first()->url }}" alt="Image" class="w-full h-auto">
                        <br clear="all" />
                    </div>
                @endif

                <p class="text-gray-700">{!! nl2br(e($poster->description)) !!}</p>

                @if($poster->end_date)
                    <p class="text-gray-600">Дата окончания: {{ date('d.m.Y', strtotime($poster->end_date)) }}</p>
                @endif

                <p><a href="{{ $poster->link }}" target="_blank" class="text-blue-500 hover:underline">Перейти к
                        афише</a></p>

                @if($poster->source_link)
                    <p><a href="{{ $poster->source_link }}" target="_blank" class="text-blue-500 hover:underline">Источник</a>
                    </p>
                @endif

                {{-- Проверка, чтобы ссылка на покупку билетов отображалась, если текущая дата меньше даты проведения --}}
                @if($poster->buy_tickets_link && now()->lt(new \DateTime($poster->event_date . ' ' . $poster->event_time)))
                    <p><a href="{{ $poster->buy_tickets_link }}" class="text-blue-500 hover:underline">Купить билеты</a>
                    </p>
                @endif
<br clear="all" />
            </li>
        @endforeach
    </ul>
</div>
