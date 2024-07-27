<div>
    {{--    <form wire:submit="show">--}}
    {{--        <input--}}
    {{--            class="shadow appearance-none border rounded w-[200px] py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"--}}
    {{--            placeholder="Пароль"--}}
    {{--            type="password" wire:model="password" >--}}
    {{--    </form>--}}

    {{--    <br/>--}}
    {{--    <br/>--}}

    {{--    <form class="w-full max-w-sm text-center">--}}
    {{--        <div class="flex items-center border-b border-teal-500 py-2 w-[500px]">--}}
    {{--            <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Пароль" aria-label="Супер пароль">--}}
    {{--            <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="button">--}}
    {{--                Вперёд!--}}
    {{--            </button>--}}
    {{--            <button class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-sm py-1 px-2 rounded" type="button">--}}
    {{--                Cancel--}}
    {{--            </button>--}}
    {{--        </div>--}}
    {{--    </form>--}}

    <div class="w-full flex justify-center">
        <form class="w-full max-w-sm text-center">
            <div class="flex items-center border-b border-teal-500 py-2 w-[250px] mx-auto">
                <input
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" placeholder="Пароль" aria-label="Супер пароль" wire:model.live="pass">
                {{--                <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" type="button">--}}
                {{--                    Вперёд!--}}
                {{--                </button>--}}
            </div>
        </form>
    </div>

    @if( $pass == 11 )
        <livewire:skidki.listComponent />
    @endif
</div>
