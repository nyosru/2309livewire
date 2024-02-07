<div>

    <style>
        .lili ul {
        }

        .lili ul li {
            list-style: inside decimal;
            padding-left: 20px;
        }

        .lili ol li {
            list-style: circle inside;
            padding-left: 20px;
        }
    </style>

    <div class="bg-gradient-to-b from-gray-100 to-yellow-100">
        <div class="container text-2xl py-16 mx-auto text-center">
            Все документы и схемы отправляем Вам чтобы их напечататать и записать диски ( тогда с нас скидка! ) или привозим к МФЦ, подаёте их и получаете приватизацию гаража и земли под ним! нужно 5 визитов в
            <a href="https://моидокументы.рф/" target="_blank" class="text-blue-600 underline">МФЦ "Мои документы" (найдите ближайший)</a>
        </div>
    </div>
    <div class="lili px-[3%]">

        <div class="grid grid-cols-7  pb-[3rem]">
            <div class="col-span-8 block text-center pt-6 text-2xl">

                <h2 class="block text-4xl  text-center font-bold mb-4 ">Схема прохождения приватизации
                </h2>

                версия просмотра:
                <button class="@if( $show_type == 'small' ) bg-green-300 @else bg-green-100 @endif p-2 underline"
                        wire:click="setShow('small')">Кратко
                </button>
                <button class="@if( $show_type != 'small' ) bg-green-300 @else bg-green-100 @endif p-2 underline"
                        wire:click="setShow('full')">Расширенный план
                </button>

            </div>
        </div>

        {{--        show_type: {{ $show_type }}--}}

        {{--        <p>--}}
        {{--            --}}{{--            Кратко / Полно--}}
        {{--            <br/>--}}
        {{--            <br/>--}}


        @if( $show_type == 'small' )

            <br clear="all"/>

            <div class=" text-2xl">
                <div class="grid grid-cols-1 md:grid-cols-8 font-bold">
                    <div class="invisible md:visible">&nbsp;</div>
                    <div class="invisible md:visible">&nbsp;</div>
                    <div class="col-span-5 pb-2">
                        Описание
                    </div>
                    <div class="text-right md:text-left pb-2">
                        Оплата
                    </div>
                </div>

                @foreach( $uslugi as $u )
                    <div
                        class="grid grid-cols-1 md:grid-cols-8 @if($loop->index%2==0) bg-blue-100 @else bg-white @endif">
                        <div class="fixed md:relative invisible md:visible text-center pt-2"><span
                                class="text-2xl inline-block rounded bg-yellow-300 p-2">{{ $loop->index+1 }}</span>
                        </div>
                        <div class="fixed md:relative invisible md:visible p-1">{!! $u['mini']['img'] ?? ''  !!} </div>
                        {{--                    <img src="/icon/map.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
                        {{--                </div>--}}
                        <div class=" md:col-span-5">
                            <div>{!! $u['mini']['opis'] ?? ''  !!} </div>
                        </div>
                        <div class="text-right md:text-left">
                            @if( !empty($u['price']) )
                                {{ $u['price'] }} ₽
                            @endif
                        </div>
                    </div>
                @endforeach


                <div class="w-full text-3xl px-10 py-5 bg-green-300 mb-10">
                    <img src="/icon/winner.png" class="inline-block" style="max-width: 64px; 1border: 1px solid green;"/>
                    Поздравляем! Земля и гараж приватизированы!
                </div>


            </div>
            {{--        <div class="grid grid-cols-8">--}}
            {{--            <div>1</div>--}}
            {{--            <div><img src="/icon/map.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/></div>--}}
            {{--            <div class="col-span-6">--}}
            {{--                собираем первые документы--}}
            {{--            </div>--}}
            {{--        </div>--}}
            {{--        <div class="grid grid-cols-8">--}}
            {{--            <div>2</div>--}}
            {{--            <div><img src="/icon/man.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--                <img src="/logo/mfc_mini.svg" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            </div>--}}
            {{--            отдаёте в МФЦ--}}
            {{--        </div>--}}
            {{--</div>--}}


            {{--            3) получаем результат--}}
            {{--            <img src="/icon/email.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <br/>--}}

            {{--            4) готови ещё схемы на cd--}}
            {{--            <img src="/icon/map.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <br/>--}}
            {{--            5) визит в мфц, отдаёте--}}
            {{--            <img src="/icon/man.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <img src="/logo/mfc_mini.svg" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <br/>--}}
            {{--            6) готовим ещё документы--}}
            {{--            <img src="/icon/map.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <br/>--}}
            {{--            7) при получении результата по заявлению шага 5 отдаём документы что приготовили в шаге 6--}}
            {{--            <img src="/icon/man.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <img src="/logo/mfc_mini.svg" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <br/>--}}
            {{--            8) получаем результат обработки, смотрим результат на кадастровой карте, поздравляем Вы владеете землей и--}}
            {{--            строением--}}
            {{--            гаража!--}}
            {{--            <img src="/icon/winner.png" class="inline-block" style="max-width: 64px; border: 1px solid green;"/>--}}
            {{--            <br/>--}}
            {{--            </p>--}}

        @endif

        @if( $show_type == 'full' )
            {{--            <div style="font-size: 12px;">--}}
            {{--                $uslugi: {{ print_r($uslugi) }}--}}
            {{--            </div>--}}


            @foreach( $uslugi as $u )

                @if( 1 == 2 )
                    <br/>
                    <br/>
                    <br/>
                    $u: {{ print_r($u) }}
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                @endif

                <div class="grid grid-cols-6 md:grid-cols-8">
                    <div class="col-span-6">
                        <div class="bg-blue-300 pl-0 p-3 rounded-2xl border-2 border-blue-500 min-h-[200px]">
                            <ul class="
                                xinline-block
                                block
                                text-2xl">
                                @foreach( $u['data'] as $u1 )
                                    <li>
                                        {!! $u1 !!}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if( isset($u['after']['false']) )
                        <div class="text-center fixed md:relative invisible md:visible ">
                            <div class="block text-center">
                                <img src="/icon/right1.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                            </div>
                            @if( !empty($u['after']['false']) )
                                {{ $u['after']['false'] }}
                            @endif
                        </div>
                        @if( !empty($u['after']['false_message']) )
                            <div class="fixed md:relative invisible md:visible ">
                                <div class="bg-red-100 rounded mt-3 px-2 py-1">
                                    {{ $u['after']['false_message'] }}
                                </div>
                            </div>
                        @endif
                    @endif

                </div>

                @if( isset($u['after']['good']) )
                    <div class="grid grid-cols-8 py-5">

                        <div class="col-span-2 md:col-span-1 text-center">
                            <img src="/icon/down1.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                        </div>

                        <div class="col-span-6 md:col-span-5 text-2xl">
                            @if( !empty($u['after']['good']) )
                                <ol>
                                    @foreach( $u['after']['good'] as $ug )
                                        <li>{!! $ug !!}</li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>

                    </div>
                @endif

            @endforeach


            <div class="w-full text-3xl px-10 py-5 bg-green-300">
                <img src="/icon/winner.png" class="inline-block" style="max-width: 64px; 1border: 1px solid green;"/>
                Поздравляем! Земля и гараж приватизированы!
            </div>

            @if(1==2)

                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>

                <div class="grid grid-cols-8">
                    <div class="col-span-6">
                        <ul class="bg-blue-300 pl-0 p-3
                            xinline-block
                            block
                            rounded-2xl border-2 border-blue-500 text-2xl">
                            <li>
                                У вас есть гараж в кооперативе,
                            </li>
                            <li>
                                железобетонный или кирпичный,
                            </li>
                            <li>
                                членская книжка,
                            </li>
                            <li>
                                ежегодные платежи в кооператив уплачены
                            </li>
                        </ul>
                    </div>

                    <div class="text-center">
                        <div class="block text-center">
                            <img src="/icon/right.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                        </div>
                        Если чего-то&nbsp;нет из&nbsp;списка
                    </div>
                    <div>
                        не стоит начинать
                    </div>
                </div>

                <div class="grid grid-cols-8">
                    <div class="col-span-6 text-center">
                        <img src="/icon/down.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                        Если все пункты есть, <b>хорошо</b>
                    </div>
                </div>

                <div class="grid grid-cols-8">

                    <div class="col-span-6">
                        <ul class="bg-blue-300 pl-0 p-3
                            xinline-block
                            block
                            rounded-2xl border-2 border-blue-500 text-2xl">
                            <li>
                                Взять справку у председателя гаражного кооператива ( скачать шаблон )
                            </li>
                            <li>
                                Оплатить услуги, первый шаг 5`000 р
                            </li>
                            <li>
                                Заполнить форму заявки ( адрес, номер гаража, название кооператива, ваши данные, точка
                                на
                                карте
                                где гараж )
                            </li>
                            <li>
                                Отправить фото гаража снаружи (чтобы специалист смог найти)
                            </li>
                        </ul>
                    </div>

                    {{--            <div class="text-center">--}}
                    {{--                <div class="block text-center">--}}
                    {{--                    <img src="/icon/right.png" style="max-width: 80px; width: 50%;" class="inline-block"/>--}}
                    {{--                </div>--}}
                    {{--                Если чего-то&nbsp;нет из&nbsp;списка--}}
                    {{--            </div>--}}
                    {{--            <div>--}}
                    {{--                не стоит начинать--}}
                    {{--            </div>--}}

                </div>



                <div class="grid grid-cols-8">
                    <div class="col-span-2 text-center">
                        <img src="/icon/down.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                    </div>
                    <div class="col-span-4 py-3">
                        Подготавливаем документ для подачи ( 3-10 рабочих дней ), присылаем его вам в электронном виде
                        (если
                        сможете распечатать, скидка на следующий шаг 100р) или пришлём на такси распечатанный вариант
                    </div>
                </div>



                <div class="grid grid-cols-8">

                    <div class="col-span-6">
                        <ul class="bg-blue-300 pl-0 p-3
                            xinline-block
                            block
                            rounded-2xl border-2 border-blue-500 text-2xl">
                            <li>
                                Сдаёте документы в МФЦ (первый шаг по приватизации по гаражной амнистии)
                                <ol>
                                    <li>справка от председателя</li>
                                    <li>схема что подготовили и вам прислали</li>
                                    <li>не забудте взять с собой паспорт</li>
                                </ol>
                            </li>
                        </ul>
                    </div>

                    {{--            <div class="text-center">--}}
                    {{--                <div class="block text-center">--}}
                    {{--                    <img src="/icon/right.png" style="max-width: 80px; width: 50%;" class="inline-block"/>--}}
                    {{--                </div>--}}
                    {{--                Если результат рассмотрения отрицательный--}}
                    {{--            </div>--}}
                    {{--            <div>--}}
                    {{--                Закончили, не дадут приватизировать--}}
                    {{--            </div>--}}

                </div>


                <div class="grid grid-cols-8">
                    <div class="col-span-2 text-center">
                        <img src="/icon/down.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                    </div>
                    <div class="col-span-4 py-3">
                        Ждём результата рассмотрения заявления (до 10 дней) обычно гораздо быстрее
                    </div>
                </div>


                <div class="grid grid-cols-8">

                    <div class="col-span-6">
                        <ul class="bg-blue-300 pl-0 p-3
                            xinline-block
                            block
                            rounded-2xl border-2 border-blue-500 text-2xl">
                            <li>
                                Полученный результат о возможности предоставления земли бесплатно
                            </li>
                        </ul>
                    </div>

                    <div class="text-center">
                        <div class="block text-center">
                            <img src="/icon/right.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                        </div>
                        Если результат отрицательный
                    </div>
                    <div>
                        Закончили, не дадут приватизировать
                    </div>

                </div>


                <div class="grid grid-cols-8">
                    <div></div>
                    <div class="xcol-span-2 text-center">
                        <img src="/icon/down.png" style="max-width: 80px; width: 50%;" class="inline-block"/>
                    </div>
                    <div class="col-span-4 py-3">
                        Результат положительный (99% случаев) работаем!
                    </div>
                </div>


                <div class="grid grid-cols-7">

                    <div>11</div>
                    <div>11</div>
                    <div>11</div>
                    <div>11</div>

                </div>

                <p>
                    Приватизация возможна!
                </p>
                <p>
                    Наше сотрудничество
                </p>

                <ul>
                    <li>
                        старт
                        <ul>
                            <li>заполняете форму ( что за кооператив, ваши данные, номер гаража),
                            </li>
                            <li>
                                отправляете фотки гаража (на сайте,в телеграм или на email)
                            </li>
                            <li>ссылку на точку на карте где он стоит (2гис, яндекс карты, гугл карты)
                            </li>
                            <li>
                                берёте справку у председателя по форме (скачать шаблон)
                            </li>
                        </ul>
                    </li>
                    <li>
                        <ul>
                            <li>
                                обращаетесь в мфц с заявлением и подготовленным диском
                            </li>
                            <li>
                                получаете результат рассмотрения
                            </li>
                            <li>
                                если дают добро - 95% обращений, работаем дальше
                            </li>
                            <li>
                                если результат проверки отрицательный - возвращаем 4тр провести процесс приватизации без
                                суда не
                                получится, заканчиваем сотрудничество по этому гаражу
                            </li>
                        </ul>
                    </li>
                    <li>
                    </li>
                    <li>
                    </li>
                </ul>
            @endif


    </div>
    @endif
</div>
