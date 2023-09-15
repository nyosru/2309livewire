        
        <div class="text-center">
        <a href="/"><h1 style="font-size: 3rem;">php-cat.com</h1></a>
    </div>
        <!-- Navigation bar -->
        <nav class="relative flex w-full items-center justify-between bg-white py-2 text-neutral-600 shadow-lg hover:text-neutral-700 focus:text-neutral-700 dark:bg-neutral-600 dark:text-neutral-200 md:flex-wrap md:justify-start"
            data-te-navbar-ref>
            {{-- <div class="flex w-full flex-wrap items-center justify-between px-3"> --}}            
                <div class="flex items-center">
                    <!-- Hamburger menu button -->
                    <button
                        class="border-0 bg-transparent px-2 text-xl leading-none transition-shadow duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 dark:hover:text-white dark:focus:text-white lg:hidden"
                        type="button" data-te-collapse-init data-te-target="#navbarSupportedContentX"
                        aria-controls="navbarSupportedContentX" aria-expanded="false" aria-label="Toggle navigation">
                        <!-- Hamburger menu icon -->
                        <span class="[&>svg]:w-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </span>
                    </button>
                </div>

                <!-- Navigation links -->
                <div class="!visible hidden grow basis-[100%] items-center lg:!flex lg:basis-auto"
                    id="navbarSupportedContentX" data-te-collapse-item>
                    {{-- <ul class="mr-auto flex flex-col lg:flex-row" data-te-navbar-nav-ref> --}}
                    <ul class="m-auto flex" data-te-navbar-nav-ref>

                        <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
                                class="block 
                                @if( Route::currentRouteName() == 'phpcat.index' ) active bg-orange-100 @endif
                                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="{{ route('phpcat.index') }}" data-te-nav-link-ref data-te-ripple-init                                
                                data-te-ripple-color="light"
                                wire:navigate
                                >Супер предложение!</a></li>
                                             
                        {{-- <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
                            class="block 
                            @if( Route::currentRouteName() == 'phpcat.news' ) active bg-orange-100 @endif
                            transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                            href="{{ route('phpcat.news') }}" data-te-nav-link-ref data-te-ripple-init
                            data-te-ripple-color="light"
                            wire:navigate
                            >Новости</a></li> --}}

                        <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
                                class="block 
                                @if( Route::currentRouteName() == 'phpcat.services' ) active bg-orange-100 @endif
                                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="{{ route('phpcat.services') }}" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light"
                                wire:navigate
                                >Сервисы(службы)</a></li>
                   
                        {{-- <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
                                class="block 
                                @if( Route::currentRouteName() == 'phpcat.torrent' ) active bg-orange-100 @endif
                                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="{{ route('phpcat.torrent') }}" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light"
                                wire:navigate
                                >Торенты</a></li> --}}
                        {{-- <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref><a
                                class="block 
                                @if( Route::currentRouteName() == 'phpcat.money' ) active bg-orange-100 @endif
                                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="{{ route('phpcat.money') }}" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light"
                                wire:navigate
                                >Деньги по быстрому</a></li> --}}

                        {{--                                 
                        <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                            <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="#!" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light">Home</a>
                        </li>
                        
                        <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                            <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="#!" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light">Features</a>
                        </li>
                        <li class="mb-4 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                            <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="#!" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light">Pricing</a>
                        </li>
                        <li class="mb-2 lg:mb-0 lg:pr-2" data-te-nav-item-ref>
                            <a class="block transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                                href="#!" data-te-nav-link-ref data-te-ripple-init
                                data-te-ripple-color="light">About</a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </nav>