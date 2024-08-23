<div class="container mx-auto p-6">
    <div class="relative flex flex-col">
        <!-- Вертикальная линия -->
        <div class="absolute left-4 top-0 bottom-0 w-1 bg-gray-300"></div>

        @php
            $currentMonth = null;
        @endphp

        @foreach ($holidays as $holiday)
            @if ($currentMonth !== $holiday->month)
                @php
                    $currentMonth = $holiday->month;
                    // Получаем название месяца на русском языке
                    $monthName = \Carbon\Carbon::create()->month($holiday->month)->locale('ru')->translatedFormat('F');
                @endphp
                    <!-- Месяц -->
                <div class="sticky top-[5.6rem] z-10 py-2"
                     style="background: linear-gradient(to bottom right, blue, white);">
                    <h2 class="text-xl font-bold text-white text-center">{{ ucfirst($monthName) }}</h2>
                </div>
            @endif

            <div class="flex mb-8">
                <!-- Дата -->
                <div class="flex-shrink-0 w-16 text-right mr-6">
                    <div class="sticky top-[8.3rem] text-gray-700 font-semibold">
                        <div class="bg-gradient-to-r from-red-500 to-white p-2 rounded-lg">
                            {{ str_pad($holiday->day, 2, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>
                </div>

                <!-- Описание праздников -->
                <div class="flex-grow pl-8 border-l-2 border-transparent">
                    <div class="bg-white p-4 rounded-lg shadow-md">

                        <span class="float-right">{!! $holiday->countryStr !!}</span>

                        <h3 class="text-lg font-bold text-gray-800">{{ $holiday->title }}</h3>
                        <p class="text-gray-600">{{ $holiday->text }}</p>
                        {{--                        <p class="text-gray-600">{{ $holiday->countryStr }}</p>--}}
                        <br clear="all" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
