<div>

    <div class="text-white hover:text-gray-300" style="position: absolute; top: 10px; right: 30px;" >    {{ count($objects) }}</div>
    {{-- {{ $objects }}--}}

    <livewire:ar.object-add-form/>

    <style>
        .pay-in-month {
            /*.pay-in-month.pay-yes*/
            display: block;
        }

        .pay-in-month.pay-yes {
            xbackground-color: #70f276;
        }

        /*.pay-in-month.pay-no*/
        .pay-in-month.pay-no {
            xbackground-color: #f0f287;
        }

    </style>

    <div class="items md:mx-auto md:max-w-[40rem]">
        @foreach( $objects as $o )
{{--            <livewire:Ar.arObject--}}
{{--                :object="$o"--}}
{{--            />--}}
        @endforeach
    </div>
    {{--    @include('livewire.ar.add')--}}

</div>
