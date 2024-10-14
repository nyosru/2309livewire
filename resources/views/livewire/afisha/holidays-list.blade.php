<div class="container mx-auto p-6">

    {{-- Для отладки --}}
    {{-- <pre style="font-size: 10px;">{{ print_r($holidays, true) }}</pre> --}}

    <div class="relative flex flex-col">
        <!-- Вертикальная линия -->
        <div class="absolute left-4 top-0 bottom-0 w-1 bg-gray-300"></div>

        @php
            use Carbon\Carbon;
			$currentMonth = null;
            $lastDay = null;
        @endphp

        @foreach ($holidays as $holiday)

            @php
                $date = Carbon::create()->year(date('Y'))->month($holiday->month)->day($holiday->day);
                $dayOfWeek = $date->translatedFormat('D'); // Получаем сокращение дня недели
                $isWeekend = in_array($dayOfWeek, ['Sun', 'Sat']); // Определяем выходной день
            @endphp

            @if ($currentMonth !== $holiday->month)
                @php
                    $currentMonth = $holiday->month;
                    // Получаем название месяца на русском языке
                    $monthName = Carbon::create()->month($holiday->month)->locale('ru')->translatedFormat('F');
                @endphp
                    <!-- Месяц -->
                <div class="sticky top-[5.6rem] z-10 py-2"
                     style="background: linear-gradient(to bottom right, blue, white);">
                    <h2 class="text-xl font-bold text-white text-center">{{ ucfirst($monthName) }}</h2>
                </div>
            @endif

            @if(!empty($lastDay) && $lastDay == $holiday->day )
                @continue
            @endif

            @php
                $lastDay = $currentDay = $holiday->day;
            @endphp

            <div class="flex mb-8">
                <!-- Дата -->
                <div class="flex-shrink-0 min-w-[3rem] чtext-right mr-6">
                    <div class="sticky top-[8.3rem] w-full text-gray-700 font-semibold">
                        <div class="bg-gradient-to-r from-red-200 to-white p-2 rounded-lg">
                            {{ str_pad($holiday->day, 2, '0', STR_PAD_LEFT) }}
                            @if ($isWeekend)
                                <sup class="text-xs xtext-gray-500 bg-yellow-300 py-0 px-1">
                                    {{ $dayOfWeek == 'Sun' ? 'вск' : 'сб' }}
                                </sup>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Описание праздников -->
                <div class="flex-grow pl-1 border-l-2 border-red-400">
                    @include('livewire.afisha.holidays-listday-list', [
                        'holidays' => $holidays,
                        'month' => $holiday->month,
                        'day' => $holiday->day
                    ])
                </div>
            </div>
        @endforeach

        <style>
            /* Удаляем нижнюю границу у последнего элемента */
            /*.container .flex:not(:last-child) {*/
            /*    border-bottom: 1px solid #ababab; !* Цвет границы *!*/
            /*}*/
        </style>


        <style>
            /* Удаляем нижнюю границу у последнего элемента */
            .holydays-items > div:last-child {
                border-bottom: none;
            }

            /* Стили для элементов праздников */
            .holydays-items > div {
                border-bottom: 1px solid #ababab; /* Цвет границы: градиент серый */
            }

        </style>

    </div>
</div>
