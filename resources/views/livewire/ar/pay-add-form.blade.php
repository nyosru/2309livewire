<div>
    <a href="#" wire:click.prevent="toggleShowAr('p1')" class="bg-green-300 p-1 rounded">+платеж</a>
    {{--    show: {{ $show ? 1 : 0 }}--}}
    @if( isset($show_ar['p1']) && $show_ar['p1'] )
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
            <input type="date" wire:model="date" id="date-input" class="border border-1 border-solid border-green-200 p-1"/>
            <input type="text" wire:model="opis" placeholder="какойнить коментарий"
                   class="border border-1 border-solid border-green-200 p-1"/>
        </form>

    @endif

    @if (session()->has('message'))
        <div class="mb-2 p-2 bg-green-100 text-green-800 border border-green-200 rounded">
            {{ session('message') }}
        </div>

{{--        <script>--}}
{{--            document.addEventListener('DOMContentLoaded', function() {--}}
{{--                let dateInput = document.getElementById('date-input');--}}
{{--                if (dateInput) {--}}
{{--                    dateInput.focus();--}}
{{--                }--}}
{{--            });--}}
{{--        </script>--}}
    @endif

    {{--    @if( !empty($message) )--}}
    {{--        <div class="bg-green-400 p-1">--}}
    {{--            {!! $message !!}--}}
    {{--        </div>--}}
    {{--    @endif--}}

</div>
