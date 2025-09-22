<nav

    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-5"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-5"

    x-data="{ open: false ,
     showHeader: true,
     showBlock: true,
     lastScrollPosition: 0 }"

    {{--    x-on:scroll.window.throttle.200ms="() => {--}}
    x-on:scroll.window="() => {
        const currentScroll = window.scrollY;
        const isMobile = window.innerWidth < 600;

            if (lastScrollPosition < currentScroll && currentScroll > 100) {
                showBlock = false
            } else if (lastScrollPosition > currentScroll && currentScroll < 100) {
                showBlock = true
            }

         if (isMobile) {
            if (currentScroll > 100) {
                showHeader = false;
            } else {
                showHeader = true;
            }
         }

         lastScrollPosition = currentScroll;

         }"

    class="bg-white border-b border-gray-100
{{--     @guest() --}}
     sticky top-0
{{--     @endguest--}}
shadow-lg
     "


    style="
            background: linear-gradient(45deg,
                /*rgba(205, 205, 205, 0.7) 10%,*/
                rgba(180, 180, 250, 0.6) 11%,
                rgba(220, 220, 220, 0.6) 80%,
                rgba(120, 120, 220, 0.6)) 81%;
            background-size: 300% 300%;
            animation: gradientShift2 30s ease infinite;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        "

>


    <style>
        @keyframes gradientShift2 {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>

    <div class="
bg-gray-200
{{--bg-gradient-to-br from-[#898989] to-[#b9b9b9]--}}
text-center w-full flex flex-wrap justify-center space-x-1 md:space-x-4"
         x-show="showBlock"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-5"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-5"
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
            Тюмень
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

             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-5"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-5"


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

            {{--            <div class="flex flex-col--}}
            {{--            flex-1--}}
            {{--w-1/2--}}
            {{--             items-end--}}
            {{--             items-center--}}
            {{--            w-[150px] --}}
            {{--            text-right --}}
            {{--            "--}}
            {{--                 x-show="!showHeader"--}}
            {{--                 x-transition.opacity.duration.300ms--}}
            {{--            ><a href="/">--}}
            {{--                    <img src="/cfa/img/logo.jpg" alt="logo" style="height:40px; width: 80px;"/>--}}
            {{--                </a>--}}
            {{--            </div>--}}

            <img x-show="!showHeader"

                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-5"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-5"

                 src="/cfa/img/logo.jpg" alt="logo"
                 class="float-left"
                 style="height:40px; width: 80px;"/>

            <div class="flex flex-col
            w-2/4
{{--            flex-1 --}}
            items-center
{{--            items-start--}}
             ">

                <div>
                    <a href="tel:+79324818910" target="_blank" class=" hover:underline">
                        <img src="/icon/svg/Light/Calling.svg" class="h-[20px] inline "/> 8(932)481-89-10
                    </a>
                </div>
                <div>
                    <a href="https://t.me/Nadi_Zhdanova" target="_blank" class=" hover:underline">
                        <img src="/icon/Telegram.png" class="h-[20px] inline"/> @Nadi_Zhdanova
                    </a>
                </div>
            </div>


            @if(1==1)

                @guest
                    @if(request()->routeIs('cfa.index2'))
                        <div class="flex-1">
                            <livewire:auth.vk/>
                        </div>
                    @endif
                @else
                    <div class="flex-1">
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="inline xw-full text-start">
                                {{ auth()->user()->name ?? '-' }}
                            </button>
                            <div x-show="open"

                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform -translate-y-5"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-5"


                                 @click.away="open = false" class="absolute  border-2 border-gray-500 rounded
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
