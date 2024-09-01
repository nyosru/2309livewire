<div class="container holydays-items mx-auto xp-6">
    @foreach ($holidays as $holiday)
        @if ($month == $holiday->month &&
        $day == $holiday->day )
            <div class="p-2 xmb-2">

                <span class="float-right">
{{--                    {!! $holiday->countryStr !!}--}}
                    @if(!empty($holiday->CountryImg))
                        <img title="{{ $holiday->country }}" src="{!! $holiday->CountryImg  !!}" class="max-w-[3rem]"/>
                    @else
                        {!! $holiday->country !!}
                    @endif


                </span>
                <h3 class="text-lg font-bold text-gray-800">{{ $holiday->title }}</h3>
                <p class="text-gray-600">{{ $holiday->text }}<br clear="all" style="height: 1px; line-height: 1px;"/></p>

            </div>

        @endif
    @endforeach

</div>
