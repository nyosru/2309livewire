<div>

            {{ count($objects) }}
{{--            {{ $objects }}--}}

    <livewire:ar.ObjectItemAddForm />

{{--    <livewire:ar.ObjectAddForm--}}
{{--        xdata="$o->prices"--}}
{{--        xpayes="$o->payes"--}}
{{--        xobject_id="$o->id"--}}
{{--    />--}}

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

    <div class="items">
        @foreach( $objects as $o )
            <livewire:ar.arObject
                :object="$o"
            />
        @endforeach
    </div>

{{--    @include('livewire.ar.add')--}}

</div>
