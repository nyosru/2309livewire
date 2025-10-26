<section class="py-16
    bg-gradient-to-tr from-green-700 to-green-500
    text-white">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-8">

        <!-- Форма -->
        <div class="md:w-1/2">
            <form wire:submit.prevent="submit" class="max-w-md mx-auto space-y-4">
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
                @if (session()->has('message'))
                    <div class="text-green-200 text-center">{{ session('message') }}</div>
                @endif
            </form>
        </div>

        <!-- Текст предложения -->
        <div class="md:w-1/2 text-center md:text-left">
            <h2 class="text-3xl font-bold mb-4 text-black bg-yellow-500">
                курс Мастер! <sup>(пол года)</sup>
                <br/>
                Скидка 20%
            </h2>
            <h2 class="text-3xl font-bold mb-4">22 занятия и 2 недели паузы</h2>
            <h2 class="text-3xl font-bold">4`000р</h2>
            <strike class="font-normal text-[20px] text-gray-100">6`000р</strike>

        </div>

    </div>
</section>
