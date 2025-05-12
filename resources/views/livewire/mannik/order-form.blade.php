<div class="
{{--max-w-md mx-auto --}}
w-full
p-4
{{--border rounded shadow bg-white--}}
{{--bg-[url('/mannik/photo/big1.jpeg')] bg-center bg-cover--}}
flex flex-row
{{--bg-gradient-to-br from-white to-gray-100--}}
bg-blue-100
">
    <div class="
container mx-auto
">
        <div class="w-full md:w-[350px] mx-auto">
            @if ($successMessage)
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ $successMessage }}
                </div>
            @endif

            <h2 class="text-2xl font-bold mb-4">Отправить заявку</h2>

            <form wire:submit.prevent="submit" novalidate>
                <label for="phone" class="block mb-2 font-semibold">укажите свой телефон, позвоним уточнить детали</label>
                <input
                    type="text"
                    id="phone"
                    wire:model.defer="phone"
                    class="w-full p-2 border rounded @error('phone') border-red-500 @enderror"
                    placeholder="+7 (999) 123-45-67"
                >
                @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <button
                    type="submit"
                    class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition"
                >
                    Отправить
                </button>
            </form>
        </div>
{{--        <div class="w-1/2">--}}
{{--        </div>--}}
    </div>
</div>
