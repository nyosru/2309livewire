<div>

    {{--        {{ $objects }}--}}

    <livewire:ar.objectAddForm
        xdata="$o->prices"
        xpayes="$o->payes"
        xobject_id="$o->id"
    />

    <style>
        .pay-in-month{
            /*.pay-in-month.pay-yes*/
            display: block;
        }
        .pay-in-month.pay-yes{
            background-color: #70f276;
        }
        /*.pay-in-month.pay-no*/
        .pay-in-month.pay-no{
            background-color: #f0f287;
        }
        .pay-in-month.pay-no2{
            background-color: #f2a1ab;
        }
    </style>

    <div class="items">
        @foreach( $objects as $o )

            <div>

                <div class="pay-in-month {{ $o->pay_in_month ? 'pay-yes' : ( $o->pay_in_month ? 'pay-no' : 'pay-no2' ) }}">
                    <livewire:helper.showerDopInfo
                        :string="'старт '.$o->nomer .' / '.$o->adres"
                        :data="$o->getAttributes()"
                    />
                </div>

                <div class="head">
                    <h2>
                        <span class="text-3xl font-bold bg-yellow-200 px-3 py-1">
                            id {{$o->id }} /
                            # {{$o['nomer']}} /
                    <sup>{{$o['adres']}}</sup>
                        </span>
                    </h2>
                    {{$o['opis']}}
                </div>
                <div class="kto">

                    <livewire:ar.peopleAddForm
                        :now_object="$o['id']"
                        xdata="$o->prices"
                        xpayes="$o->payes"
                        xobject_id="$o->id"
                    />

                    @foreach( $o->prices as $op )
                        <div
                            class="inline-block max-w-[30%] mr-1 max-h-[300px] overflow-auto border border-solid border-[2px] border-green-200 p-1">

                            <livewire:helper.showerDopInfo
                                :string="'старт '.$op->date_start .' / <b>'.number_format($op->price,0,'','`') .'</b> р.'"
                                :data="$op->getAttributes()"
                            />
                            <livewire:helper.showerDopInfo
                                :string="'#'.$op->man[0]->id . ' / ' .$op->man[0]->name . ' ' .$op->man[0]->phone"
                                :data="$op->man[0]->getAttributes()"
                            />

                            @if( !empty($op->man[0]->payes) )

                                @if( !empty($op->man[0]->payes[0]->date))
                                    <livewire:ar.service.payInLastMonth
                                        :date_pay="$op->man[0]->payes[0]->date"
                                    />
                                @endif

                                <livewire:ar.payAddForm
                                    :object_id="$o->id"
                                    :people_id="$op->man[0]->id"
                                />


                                @foreach( $op->man[0]->payes as $opm )
                                    <livewire:ar.pay
                                        :pay="$opm"
                                    />
                                @endforeach

                            @endif

                        </div>
                    @endforeach

                </div>
            </div>

        @endforeach
    </div>

    @include('livewire.ar.add')

</div>
