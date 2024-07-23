<div class="container mx-auto">
    <div class="columns-2">
        <div class="w-full text-center p-3">© {{ date('Y') }} Все права защищены</div>
        <div class="w-full text-center p-3"><a href="https://php-cat.com" target="_blank">Cоздание и поддержка сервиса
                <u class="text-blue-600 hover:text-blue-800">php-cat.com</u></a></div>
    </div>
</div>

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
    <div class="px-6 py-12 text-center md:px-12 lg:text-left">
        <div class="w-100 mx-auto sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="mt-12 lg:mt-0 text-center">

                    <h1
                        class="mt-0 mb-16 text-2xl font-bold tracking-tight md:text-4xl xl:text-5xl text-[rgb(118,11%,25%)]">
                        {{ date('Y') }}&nbsp;год самое&nbsp;время реализовать вашу&nbsp;идею!
                    </h1>

                    <p class="text-center text-xl font-bold md:text-2xl xl:text-3xl"> Я&nbsp;Сергей&nbsp;Бакланов
                        <br><br>
                        Младший помощник программиста, Програмист, IT&nbsp;архитектор и&nbsp;IT&nbsp;космонавт&nbsp;
                        <br><br>
                        Использую чаще всего php, Symfony, Laravel, js, Vue3, LiveWire
                        <br><br> Работаю удалённо
                        {{--                        ,--}}
                        {{--                        нахожусь&nbsp;в&nbsp;Тюмени--}}

                    </p>
                    {{-- <h2 class="alert xalert-info text-center"> Позвоните и&nbsp;обсудим <br clear="all">
                      <small>(или напишите Телеграм)</small><br clear="all"><a href="tel:+79222622289"> тел:
                            <b>89-222-6-222-89</b></a>
                    </h2> --}}

                    {{-- <h1
                        class="mt-0 mb-16 text-5xl font-bold tracking-tight md:text-6xl xl:text-7xl text-[hsl(218,81%,95%)]">
                        The best offer <br /><span class="text-[hsl(218,81%,75%)]">for your business</span>
                    </h1> --}}

                    <br/>
                    <br/>

                    <a class="

                        mb-2
                        md:mr-2
                        md:mb-0

                        px-12
                        pt-4
                        pb-3.5


                        inline-block
                        text-sm
                        font-medium

                        rounded
                        uppercase

                        leading-normal
                        text-neutral-800

                        shadow-[0_4px_9px_-4px_#cbcbcb]
                        transition duration-150
                        ease-in-out

                        {{-- bg-neutral-50  --}}
                        bg-orange-200

                        hover:bg-orange-500
                        hover:text-white
                        hover:shadow-[0_8px_9px_-4px_rgba(203,203,203,0.3),0_4px_18px_0_rgba(203,203,203,0.2)]

                        {{-- focus:bg-neutral-100 focus:shadow-[0_8px_9px_-4px_rgba(203,203,203,0.3),0_4px_18px_0_rgba(203,203,203,0.2)]  --}}
                        {{-- focus:outline-none  --}}
                        {{-- focus:ring-0  --}}

                        {{-- active:bg-neutral-200  --}}
                        {{-- active:shadow-[0_8px_9px_-4px_rgba(203,203,203,0.3),0_4px_18px_0_rgba(203,203,203,0.2)]  --}}

                        {{-- dark:shadow-[0_4px_9px_-4px_rgba(251,251,251,0.3)]  --}}
                        {{-- dark:hover:shadow-[0_8px_9px_-4px_rgba(251,251,251,0.1),0_4px_18px_0_rgba(251,251,251,0.05)]  --}}
                        {{-- dark:focus:shadow-[0_8px_9px_-4px_rgba(251,251,251,0.1),0_4px_18px_0_rgba(251,251,251,0.05)]  --}}
                        {{-- dark:active:shadow-[0_8px_9px_-4px_rgba(251,251,251,0.1),0_4px_18px_0_rgba(251,251,251,0.05)]                         --}}

                        "
                       data-te-ripple-init data-te-ripple-color="light"
                       href="tel:+79222622289"
                       role="button">Позвонить 89-222-6-222-89</a>

                    <a class="
                        inline-block
                        px-12
                        pt-4
                        pb-3.5
                        text-sm
                        font-medium

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

                        "

                       data-te-ripple-init data-te-ripple-color="light"
                       href="https://t.me/phpcatcom"
                       target="_blank"
                       role="button"
                    >Написать в телеграм @phpcatcom</a>

                </div>
                <div class="mb-12 lg:mb-0">
                    {{--                    <a href="/phpcat/img/ya7.jpg" target="_blank" >/storage/phpcat/img/ya7.jpg</a>--}}
                    <img
                        {{-- src="https://tecdn.b-cdn.net/img/new/ecommerce/horizontal/048.jpg" --}}
                        src="/phpcat/img/ya7.jpg"
                        class="w-full rounded-lg shadow-lg dark:shadow-black/20" alt=""/>
                </div>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->
