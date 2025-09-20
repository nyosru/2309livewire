<div style="background-image: url('/cfa/img/bg1_board.webp')"
     class="bg-cover bg-bottom min-h-[500px] w-full
        lg:bg-[bottom_-150px_center]
        "
>

    <style>
        .gradient-animation {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), transparent);
            animation: gradient-shift 15s ease infinite;
        }

        @keyframes gradient-shift {
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

    {{--    <div class="w-1/2"></div>--}}
    {{--    <div class="w-1/2">--}}

    {{--        <span class="float-right bg-gray-100 border border-4 border-blue-900 p-2 rounded">--}}
    {{--        орпоративное право/владельческий контроль/защита бизнеса--}}
    {{--        </span>--}}

    {{--        <span class="float-right bg-gray-100 border border-4 border-blue-900 p-2 rounded">--}}
    {{--        Банкротство/субсидиарная ответственность--}}
    {{--        </span>--}}
    {{--            <span class="float-right bg-gray-100 border border-4 border-blue-900 p-2 rounded">--}}
    {{--        Инвестиции в стрессовые активы/покупка дебиторской задолженности--}}
    {{--        </span>--}}
    {{--                <span class="float-right bg-gray-100 border border-4 border-blue-900 p-2 rounded">--}}
    {{--        Электронная книга «основы корпоративных долгов (убытков)--}}
    {{--        </span>--}}
    {{--    </div>--}}
    @if(1==2)
        <!-- Градиентный затемняющий слой -->
        <div class="bg-gradient-to-r from-black/60 to-transparent  w-full flex flex-row">
            <div class="flex flex-col w-full md:w-1/2
    items-center
    text-center justify-center min-h-[500px] h-full">
                <h1 class="text-5xl font-bold text-white shadows">Банкротство</h1>
                {{--            <button class="bg-blue-300 p-1 rounded text-lg">Бесплатная консультация</button>--}}
                <span class="w-[300px] float-right bg-gray-100 border border-4 border-blue-900 p-2 rounded"><livewire:phpcatcom.backword.link1-modal-form/></span>
                {{--            <button class="bg-blue-300 p-1 rounded text-lg">Бесплатная консультация</button>--}}

            </div>
        </div>
    @endif

    @if(1==1)
        <!-- Градиентный затемняющий слой -->
        <div class="
{{--        bg-gradient-to-tr from-black/60 to-transparent  --}}
{{--gradient-animation--}}
        w-full flex flex-row-reverse">

            <div class="
            flex flex-col
                w-full md:w-1/2
                mr-0 md:mr-4
                 justify-center min-h-[500px] h-full">

                <div class="bg-gradient-to-br from-[rgba(0,0,0,0.6)] to-[rgba(0,0,0,0.3)]
                text-center items-center
                flex flex-col
                p-5 rounded">

                    <h1 class="text-2xl font-bold text-white shadows mb-2">
                        с&nbsp;2017 года профессионально защищаем Ваши&nbsp;интересы
                        от&nbsp;субсидиарной ответственности и&nbsp;эффективно взыскиваем задолженности,
                        обеспечивая максимальную защиту и&nbsp;результат.</h1>
                    {{--            <button class="bg-blue-300 p-1 rounded text-lg">Бесплатная консультация</button>--}}
                    {{--            <button class="bg-blue-300 p-1 rounded text-lg">Бесплатная консультация</button>--}}
                    <div
                        class="mx-auto w-full max-w-[300px] float-right bg-blue-900 border border-blue-900 p-2 rounded shadow-lg hover:bg-blue-800 transition duration-200">
    <livewire:phpcatcom.backword.link1-modal-form class="text-white cursor-pointer rounded text-xl"/>
</div>
                </div>
            </div>
            {{--            <div class="flex flex-col w-full md:w-1/4--}}
            {{--    items-center--}}
            {{--    text-center justify-center min-h-[500px] h-full">--}}

            {{--            </div>--}}
        </div>
    @endif

</div>
