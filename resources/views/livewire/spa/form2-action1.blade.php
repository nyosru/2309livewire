<div class="w-full">

    <div
        class="
        ">
        <div class="flex
             items-center
            min-h-[650px]
            bg-cover bg-no-repeat
            bg-center
            "
             style="background-image: url('/ttt/img/bar777-ball-colorful-photo-lg.jpeg');"
        >
            $telegram_bot_token_config {{ $telegram_bot_token_config ?? 'xx' }}
            <br/>
            $telegram_bot_token {{ $telegram_bot_token ?? 'x' }}
            <br/>
            <br/>

            <form wire:submit.prevent="sendMsg">
                <div id="a7" class="w-[300px]
                    bg-gradient-to-bl from-yellow-200 to-orange-500 rounded-xl p-4
                     mx-auto
                     md:mr-[5vw]
                     md:ml-[5vw]
                    flex flex-col space-y-2">
                    @if(session('message_ok'))
                        <div class="bg-green-100
                        text-center
                        border border-green-400 text-green-700 px-4 py-3 rounded relative"
                             role="alert">
                            {{ session('message_ok') }}
                        </div>
                    @else
                        <div class="font-bold text-center">
                            Записаться на обучение игре в&nbsp;бильярд
                        </div>
                        <div class="">
                            <input type="text" wire:model="phone" placeholder="Ваш телефон" class="w-full"/>
                        </div>
                        <div class="">
                            <button
                                type="submit"
                                class="bg-gradient-to-bl from-blue-200 to-blue-400 w-full font-bold rounded-xl px-2 py-1">
                                Отправить
                            </button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>
