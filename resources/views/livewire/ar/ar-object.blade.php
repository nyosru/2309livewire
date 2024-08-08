<div>
<br clear="all" />
    <div
        class="head text-3xl  pay-in-month {{ $object->pay_in_month ? 'pay-yes' : 'pay-no' }} p-2">

        <button class="px-2 py-0 my-0  text-[12px] float-right text-black-200 hover:bg-red-300 hover:text-black-800"
                wire:click="delete"
                wire:confirm="Удалить ?">
            X
        </button>

        @if( $deleted )
            <span class="float-left" >Удалено</span>
        @endif

        <livewire:helper.showerDopInfo
            :string="'#'.$object->nomer .' / '.$object->adres"
            :data="$object->getAttributes()"
        />

    </div>

    <div class="kto">

        <livewire:ar.peopleAddForm
            :now_object="$object['id']"
            xdata="$object->prices"
            xpayes="$object->payes"
            xobject_id="$object->id"
        />

        @foreach( $object->prices as $op )
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
                        :object_id="$object->id"
                        :people_id="$op->man[0]->id"
                        :amount="round($op->price)"
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
