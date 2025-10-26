{{--<div class="text-center pb-3">--}}
<a href="/" class="p-3 m-0 block text-center">
    <h1 class="w-full justify-center flex">
        {{--        <img src="/phpcat/cat.png" style="display:inline-block; max-height: 5rem;" />--}}

            <div class=" flex flex-col space-x-2 sm:flex-row text-[3rem] text-left">
{{--                <div class="" title="Тактика Техника Точность">--}}
{{--                    <div class="bg-green-300 rounded-xl px-2 py-1">--}}
{{--                    ТТТ72.рф--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="text-xl md:text-4xl text-center">
                    Школа бильярда Александра&nbsp;Коновалова
                </div>
            </div>

    </h1>
</a>
@if(1==2)
    {{--    <br/>--}}
    {{--    </div>--}}
    <!-- Navigation bar -->
    {{--        <nav class="relative flex w-full items-center justify-between bg-white py-2 text-neutral-600 shadow-lg hover:text-neutral-700 focus:text-neutral-700 md:flex-wrap md:justify-start"--}}
    {{--            >--}}
    {{--            <a href="/"><h1 style="font-size: 3rem;">php-cat.com</h1></a>--}}

    <a
        class="inline-block
            @if( Route::currentRouteName() == 'phpcat.index' ) active bg-orange-100 @endif
            transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
        href="{{ route('phpcat.index') }}" data-te-nav-link-ref data-te-ripple-init
        data-te-ripple-color="light"
        wire:navigate
    >Супер предложение!</a>

    {{-- <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
        class="block
        @if( Route::currentRouteName() == 'phpcat.news' ) active bg-orange-100 @endif
        transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
        href="{{ route('phpcat.news') }}" data-te-nav-link-ref data-te-ripple-init
        data-te-ripple-color="light"
        wire:navigate
        >Новости</a></li> --}}

    <a
        class="inline-block
                                @if( Route::currentRouteName() == 'phpcat.services' ) active bg-orange-100 @endif
                                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
        href="{{ route('phpcat.services') }}" data-te-nav-link-ref data-te-ripple-init
        data-te-ripple-color="light"
        wire:navigate
    >Сервисы(службы)</a>

    {{-- <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
            class="block
            @if( Route::currentRouteName() == 'phpcat.torrent' ) active bg-orange-100 @endif
            transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
            href="{{ route('phpcat.torrent') }}" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light"
            wire:navigate
            >Торенты</a></li> --}}
    {{-- <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
            class="block
            @if( Route::currentRouteName() == 'phpcat.money' ) active bg-orange-100 @endif
            transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
            href="{{ route('phpcat.money') }}" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light"
            wire:navigate
            >Деньги по быстрому</a></li> --}}

    {{--
    <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
        <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
            href="#!" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light">Home</a>
    </li>

    <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
        <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
            href="#!" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light">Features</a>
    </li>
    <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
        <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
            href="#!" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light">Pricing</a>
    </li>
    <li class="mb-2 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
        <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 lg:p-2 [&.active]:text-black/90"
            href="#!" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light">About</a>
    </li> --}}
    {{--                    </ul>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </nav>--}}
    {{--</div>--}}
@endif
