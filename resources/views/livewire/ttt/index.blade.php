{{--@section('content')--}}
<div>

    {{--    <livewire:mannik.order-form/>--}}


    <div>
        <livewire:spa.form1/>
    </div>
    <livewire:ttt.smi-list/>
    {{--    <div>--}}
    {{--        <livewire:spa.form2-action1/>--}}
    {{--    </div>--}}

    {{--блок слева картинка справа текст списком--}}
    <div class="
{{--    my-5 --}}
    py-10 to-orange-200
    bg-gradient-to-bl from-yellow-200
    ">
        <div class="container mx-auto">

            <img src="/ttt/img/b1.jpeg" class="rounded-xl float-left mr-2"/>

            <div class="">
                Присоединяйтесь к нашей школе бильярда!
                Хотите освоить бильярд с нуля или поднять свою игру на новый уровень?
            </div>
            <div class="font-bold pt-3">
                🎱 Почему выбирают нас?
            </div>
            <div>
                + Обучение от профессионального тренера с многолетним опытом.
                <br/>
                + Программы для всех уровней: от новичков до мастеров.
                <br/>
                + Уютная атмосфера, современные столы и индивидуальный подход.
            </div>
            @if(1==2)
                <div class="pt-3 ">
                    <b>📝 Запишитесь прямо сейчас!</b><br/>
                    Оставьте заявку, и мы свяжемся с вами, чтобы подобрать удобное время и формат занятий.

                    <div class="flex justify-center">
                        <div class="w-[300px] bg-gradient-to-bl from-yellow-200 to-orange-500 rounded-xl p-4">
                            <div class="flex flex-col space-y-2">
                                <div class="font-bold text-center">
                                    Записаться на обучение игре в&nbsp;бильярд
                                </div>
                                <div class="">
                                    <input type="text" placeholder="Ваш телефон" class="w-full"/>
                                </div>
                                <div class="">
                                    <button
                                        class="bg-gradient-to-bl from-blue-200 to-blue-400 w-full font-bold rounded-xl px-2 py-1">
                                        Отправить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <br clear="all"/>
        </div>
    </div>

    @if(1==2)
        <div class="w-full">
            <div class="w-full min-h-screen flex justify-center items-center">
                <div
                    class="relative flex justify-center items-center min-h-[650px] w-full max-w-4xl bg-cover bg-no-repeat bg-center border-2 border-red-300"
                    style="background-image: url('/ttt/img/bar777-ball-colorful-photo-lg.jpeg');">
                    <div
                        class="w-[300px] bg-gradient-to-bl from-yellow-200 to-orange-500 rounded-xl p-4 flex justify-center items-center">
                        <div class="flex flex-col space-y-2 w-full">
                            <div class="font-bold text-center">
                                Записаться на обучение игре в&nbsp;бильярд
                            </div>
                            <div>
                                <input type="text" placeholder="Ваш телефон" class="w-full rounded-md p-2"/>
                            </div>
                            <div>
                                <button
                                    class="bg-gradient-to-bl from-blue-200 to-blue-400 w-full font-bold rounded-xl px-2 py-1">
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <livewire:spa.form2-action1 />

</div>
{{--@endsection--}}

