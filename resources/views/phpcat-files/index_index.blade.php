<!-- Section: Design Block -->
<section class="background-radial-gradient xmb-40">
    <style>
        .background-radial-gradient {
            background-color: rgb(255, 255, 240);
            background-image: radial-gradient(650px circle at 0% 0%,
            rgb(255, 255, 240) 15%,
                /* hsl(218, 41%, 35%) 15%, */ rgb(255, 255, 220) 35%,
                /* hsl(218, 41%, 30%) 35%, */ /* hsl(218, 41%, 20%) 75%, */ rgb(205, 255, 220) 75%,
                /* hsl(218, 41%, 19%) 80%, */ rgb(240, 255, 250) 80%,
            transparent 100%),
            radial-gradient(1250px circle at 100% 100%,
                    /* hsl(218, 41%, 45%) 15%, */ rgb(240, 255, 250) 15%,
                    /* hsl(218, 41%, 30%) 35%, */ rgb(240, 255, 220) 35%,
                    /* hsl(218, 41%, 20%) 75%, */ rgb(240, 225, 250) 75%,
                    /* hsl(218, 41%, 19%) 80%, */ rgb(220, 255, 250) 80%,
                transparent 100%);
        }
    </style>

    <!-- Jumbotron -->
    <div class="px-6 py-2 text-center md:px-12 lg:text-left">
        <div class="w-100 mx-auto sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
            <div class="grid items-center gap-12 lg:grid-cols-3">
                <div class="mt-1 lg:mt-0 text-center">
                    <a href="https://php-cat.com" target="_blank" class="p-0 m-0 block text-center"><h1
                            style="font-size: 3rem;">
                            <img src="/phpcat/cat.png" style="display:inline-block; max-height: 5rem;"/>
                            php-cat.com</h1></a>
                    <br/>
                </div>
                <div class="mt-2 lg:mt-0 text-center">

                    <h1
                        class="mt-0 mb-3 text-xl font-bold tracking-tight md:text-2xl xl:text-2xl text-[rgb(118,11%,25%)]">
                        Создаю сайты и&nbsp;службы
                    </h1>

                    @if(1==2)
                        <a class="
                        inline-block
                        px-12
                        pt-4
                        pb-3.5

                        text-xl
                        font-bold


                        rounded
                        uppercase

                        leading-normal
                        transition
                        duration-150
                        ease-in-out

                        bg-blue-300
                        {{-- text-neutral-50  --}}

                        {{-- hover:bg-neutral-500  --}}
                        hover:bg-blue-500
                        {{-- hover:bg-opacity-10  --}}
                        {{-- hover:text-neutral-200  --}}
                        hover:text-white

                        {{-- focus:text-neutral-200  --}}
                        {{-- focus:outline-none  --}}
                        {{-- focus:ring-0  --}}
                        {{-- active:text-neutral-300 --}}
                        mb-1
                        "

                           data-te-ripple-init data-te-ripple-color="light"
                           href="https://t.me/phpcatcom"
                           target="_blank"
                           role="button"
                        >Написать в телеграм @phpcatcom</a>
                    @endif
                    <p>Этот сайт построен на: Laravel&nbsp;10 +&nbsp;LiveWire</p>
                </div>
                <div class="mb-1 lg:mb-0">
                    {{--                    <a href="/phpcat/img/ya7.jpg" target="_blank" >/storage/phpcat/img/ya7.jpg</a>--}}
                    <img
                        {{-- src="https://tecdn.b-cdn.net/img/new/ecommerce/horizontal/048.jpg" --}}
                        src="/phpcat/img/ya7.jpg"
                        class=" rounded-lg shadow-lg" alt=""
                        style="max-height: 150px; margin: 0 auto;"
                    />
                </div>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
