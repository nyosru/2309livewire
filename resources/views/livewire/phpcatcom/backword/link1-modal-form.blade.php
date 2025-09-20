<div>
    <!-- Ссылка, открывающая модальное окно -->
    <a href="#"
       wire:click.prevent="openModal"
       class="{{ !empty($class) ? $class : 'text-blue-600 hover:text-blue-800 underline cursor-pointer' }}"
    >
        Записаться на консультацию
    </a>

    <!-- Само модальное окно -->
    @if($isOpen)
        <div
            class="fixed inset-0 flex items-center justify-center z-50"
            style="
            background: linear-gradient(270deg,
                rgba(214, 218, 233, 0.5),
                rgba(63, 72, 207, 0.5),
                rgba(140, 153, 176, 0.5),
                rgba(76, 184, 204, 0.5));
            background-size: 800% 800%;
            animation: gradientShift 30s ease infinite;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        "
        >
            <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
                <button
                    wire:click="closeModal"
                    class="absolute top-3 right-3 text-gray-600 hover:text-gray-900"
                    aria-label="Close modal"
                >
                    &times;
                </button>

                <h2 class="text-xl font-semibold mb-4">Записаться на консультацию</h2>


                @if (session()->has('datar_child_success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                        {{ session('datar_child_success') }}
                    </div>
                @endif


                @if(session()->has('send_tel_message'))
                    <div class="mb-4 p-3 bg-green-200 text-green-700 rounded">
                        {{ session('send_tel_message') }}
                    </div>
                @else

                <form wire:submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="phone" class="block mb-1 font-medium">Телефон</label>
                        <input
                            type="tel"
                            id="phone"
                            wire:model.defer="phone"
                            placeholder="+7 (999) 123-45-67"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition"
                    >
                        Отправить
                    </button>
                </form>
                @endif
            </div>
        </div>

        <style>
            @keyframes gradientShift {
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
    @endif
</div>
