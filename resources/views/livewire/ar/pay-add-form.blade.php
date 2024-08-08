<div>
    <a href="#" wire:click.prevent="toggle" class="bg-green-300 p-1 rounded">+платеж</a>
    {{--    show: {{ $show ? 1 : 0 }}--}}
    @if( $show )
        <form class="w-full border border-green-300 border-[3px] border-solid p-2 mb-2" wire:submit="addPay">
            <div class="flex items-center border-b border-teal-500 py-2">
                <input
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    {{--                   type="text" placeholder="Jane Doe"--}}
                    type="number" min="0" step="50"
                    aria-label="Full name"
                    wire:model="amount"
                />
                <button
                    class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                    type="submit"
                >
                    +
                </button>
            </div>
            <input type="date" wire:model="date" class="border border-1 border-solid border-green-200 p-1"/>
            <input type="text" wire:model="opis" placeholder="какойнить коментарий"
                   class="border border-1 border-solid border-green-200 p-1"/>
        </form>

    @endif

    @if( !empty($message) )
        <div class="bg-green-400 p-1">
            {!! $message !!}
        </div>
    @endif

</div>
