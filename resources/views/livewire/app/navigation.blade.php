<nav
    x-data="{ open: false ,
     showHeader: true,
     showBlock: true,
     lastScrollPosition: 0 }"

{{--    x-on:scroll.window.throttle.200ms="() => {--}}
    x-on:scroll.window="() => {
        const currentScroll = window.scrollY;
        const isMobile = window.innerWidth < 600;

         showBlock = currentScroll < 100

         if (isMobile) {
        if (currentScroll > 100) {
            showHeader = false;
        } else {
            showHeader = true;
        }
        lastScrollPosition = currentScroll;
         } }"

    class="bg-white border-b border-gray-100
{{--     @guest() --}}
     sticky top-0
{{--     @endguest--}}
shadow-lg
     "
>
<div class="bg-gray-200 text-center w-full flex flex-wrap justify-center space-x-1 md:space-x-4"
     x-show="showBlock"
>
    <div class="px-3 py-1 ">
        Москва
    </div>
    <div class="px-3 py-1 ">
        Санкт-Петербург
    </div>
    <div class="px-3 py-1 ">
        Оренбург
    </div>
    <div class="px-3 py-1 ">
        Екатеринбург
    </div>
    <div class="px-3 py-1 ">
        Челябинск
    </div>
    <div class="px-3 py-1 ">
        Пермь
    </div>
</div>


    <div class="flex flex-col sm:w-full sm:flex-row space-y-2 pb-3"
    >
        <div class="w-full
        align-center sm:text-left
        sm:w-2/3 sm:pt-3 flex
        justify-center
        sm:items-center py-2"

             x-show="showHeader"
             x-transition.opacity.duration.300ms

        >
            <a href="/" class=" text-2xl pl-4 font-bold">

                {{--                <livewire:app.navigation-upravlyator-logo />--}}
                {{--                <livewire:app.navigation-logo />--}}

                <div class="flex flex-row">
                    <div class="flex-1 items-center align-middle">
{{--                        <img src="/cfa/img/logo.jpg" alt="logo" class="h-[4rem] inline mt-[0.5rem]"/>--}}
                        <img src="/cfa/img/logo.svg" alt="logo" class="h-[4rem] inline mt-[0.5rem]"/>
                    </div>
                    <div class="flex flex-col pl-2 text-[20px] ">
                        <div class="p-0 m-0">
                            ЦЕНТР
                        </div>
                        <div class="p-0 my-[-0.4rem]">
                            ФИНАНСОВОЙ
                        </div>
                        <div class="p-0 m-0">
                            АНАЛИТИКИ
                        </div>
                    </div>
                </div>

                {{--                <div class="flex">--}}
                {{--                    <img src="/cfa/img/logo.jpg" alt="logo" class="h-[4rem] inline"/>--}}
                {{--                    ЦЕНТР ФИНАНСОВОЙ АНАЛИТИКИ--}}
                {{--                </div>--}}

            </a>
        </div>
        <div class="sm:w-1/2 flex justify-center items-center ">

            <div class="flex flex-col
{{--            w-[150px] --}}
            text-right "
                 x-show="!showHeader"
                 x-transition.opacity.duration.300ms
            ><a href="/">
                    <img src="/cfa/img/logo.jpg" alt="logo" style="height:40px; width: 80px;"/>
                </a>
            </div>
            <div class="flex flex-col flex-1 items-center ">
                <div>
                    <a href="tel:+79324818910" target="_blank">
                        <img src="/icon/svg/Light/Calling.svg" class="h-[20px] inline"/> 8(932)481-89-10
                    </a>
                </div>
                <div>
                    <a href="https://t.me/Nadi_Zhdanova" target="_blank">
                        <img src="/icon/Telegram.png" class="h-[20px] inline"/> @Nadi_Zhdanova
                    </a>
                </div>
            </div>


            @if(1==1)

                @guest
                    @if(request()->routeIs('cfa.index2'))
                        <livewire:auth.vk/>
                    @endif
                @else
                    <div>
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="inline xw-full text-start">
                                {{ auth()->user()->name ?? '-' }}
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute  border-2 border-gray-500 rounded
                         rounded shadow-lg z-10">
                                <div class="flex flex-col w-[150px] ">
                                    {{--                                    <div class="">--}}
                                    {{--                                        <a href="{{ route('lk.profile') }}"--}}
                                    {{--                                           class="block bg-white px-4 py-2--}}
                                    {{--                                        hover:bg-orange-200 hover:underline--}}
                                    {{--                                        "--}}
                                    {{--                                        >--}}
                                    {{--                                            Профиль--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </div>--}}
                                    <div>
                                        <a
                                            href="#"
                                            class=" bg-white px-4 py-2 hover:underline block
                                        hover:bg-orange-200
                                        "
                                            wire:click="logout"
                                        >
                                            Выйти
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            @endif

        </div>
    </div>

</nav>
