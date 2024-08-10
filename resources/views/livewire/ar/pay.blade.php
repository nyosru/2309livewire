<div>
    <div
        class="xinline-block max-w-full mr-1 max-h-[300px] overflow-auto border border-solid border-[2px] border-green-200 p-1"
    >

        @if( $deleted )
            <span class="float-right bg-red-300 px-[2px] py-[1px]">Удалено</span>
        @else
            <button class="bg-white float-right hover:bg-red-300 px-[2px] py-[1px]" title="Удалить"
                    wire:click="delete"
                    wire:confirm="Удалить ?">X
            </button>
        @endif

        <livewire:helper.showerDopInfo
            :string="$pay->date.' / '. number_format($pay->amount,0,'','`')"
            :data="$pay->getAttributes()"
        />

        {{--        {{$pay->id}} /--}}
        {{--        {{$pay->date}} /--}}
        {{--        {{$pay->amount}}--}}
    </div>

</div>
