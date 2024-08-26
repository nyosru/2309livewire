<a href="/" class="p-3 m-0 block bg-white text-center" style="position: sticky; top: 0; z-index: 100;">
    <h1 style="font-size: 3rem;">
        <img src="/phpcat/cat.png" style="display:inline-block; max-height: 4rem;"/>
        ТюменскаяАфиша.рф
    </h1>
</a>

<header>

@if(1==1)
    <div class="flex items-center justify-center">

        <a
            class="inline-block
                @if( Route::is('afisha.afisha.*' ) ) active bg-orange-100 @endif
                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
            href="{{ route('afisha.afisha.index') }}" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light"
            wire:navigate
        >Афиша</a>

        <a
            class="inline-block
                @if( Route::is('afisha.holiday') ) active bg-orange-100 @endif
                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
            href="{{ route('afisha.holiday') }}" data-te-nav-link-ref data-te-ripple-init
            data-te-ripple-color="light"
            wire:navigate
        >Праздники</a>

        @if(1==2)
            <a
                class="inline-block
                @if( Route::currentRouteName() == 'afisha.add' ) active bg-orange-100 @endif
                transition duration-150 ease-in-out hover:text-neutral-700 focus:text-neutral-700 disabled:text-black/30 dark:hover:text-white dark:focus:text-white lg:p-2 [&.active]:text-black/90"
                href="{{ route('afisha.add') }}" data-te-nav-link-ref data-te-ripple-init
                data-te-ripple-color="light"
                wire:navigate
            >afisha.add</a>
        @endif
    </div>
@endif
</header>
