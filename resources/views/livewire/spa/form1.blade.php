<section class="py-16
{{--    bg-gradient-to-bl from-green-500 to-blue-600--}}


    text-white


 bg-cover bg-no-repeat
            bg-center

            "
         style="background-image: url('/ttt/img/bb1.jpeg');"
>
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <!-- Текст предложения -->
        <div class="md:w-1/2 text-center md:text-right">
            <h2 class="text-3xl font-bold mb-4"
                style="text-shadow: 1px 1px 5px rgba(0,0,0,0.7);"
            >Станьте мастером бильярда!</h2>
            <p class="text-lg mb-6"
               style="text-shadow: 1px 1px 5px rgba(0,0,0,0.7);"
            >Пройдите курс&nbsp;обучения 6&nbsp;месяцев</p>
        </div>

        <!-- Форма -->
        <div class="md:w-1/2">
            @if(session('message_ok'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                     role="alert">
                    {{ session('message_ok') }}
                </div>
            @else
                <form wire:submit.prevent="sendMsg" class="max-w-md mx-auto space-y-4">
                    <div>
                        <input
                            type="text"
                            wire:model="phone"
                            placeholder="Ваш номер телефона"
                            class="w-full p-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                        >
                        @error('phone') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-yellow-400 text-green-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition"
                    >
                        Отправить
                    </button>
                    {{--                @if (session()->has('message'))--}}
                    {{--                    <div class="text-green-200 text-center">{{ session('message') }}</div>--}}
                    {{--                @endif--}}
                </form>
            @endif

        </div>
    </div>
</section>
