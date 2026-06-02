<div>
    <div class="bg-gradient-to-r {{ $service['color'] }} py-16">
        <div class="container mx-auto px-4 text-center text-white">
            <div class="text-7xl mb-4">{{ $service['icon'] }}</div>
            <h1 class="text-5xl font-black mb-3">{{ $service['title'] }}</h1>
            <p class="text-2xl text-white/80">{{ $service['subtitle'] }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <div class="bg-white rounded-2xl p-10 border border-gray-200">
                <h2 class="text-3xl font-bold mb-4">О услуге</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-6">{{ $service['full_desc'] }}</p>
                <h3 class="text-2xl font-bold mb-3">Что вы получаете:</h3>
                <ul class="space-y-3">
                    @foreach ($service['benefits'] as $b)
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 mt-0.5 text-xl">✓</span>
                            <span class="text-gray-700 text-lg">{{ $b }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-8 text-4xl font-black text-gray-800">{{ $service['price'] }}</div>
            </div>
        </div>

        <div>
            <div class="bg-gray-50 rounded-2xl p-10 border border-gray-200 sticky top-4">
                <h3 class="text-3xl font-bold mb-6">Заказать услугу</h3>

                @if (!$sent)
                    <form wire:submit="submit" class="space-y-5">
                        <div>
                            <input wire:model="name" type="text" placeholder="Ваше имя"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <input wire:model="phone" type="text" placeholder="Ваш телефон"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit"
                                class="w-full px-6 py-5 bg-gradient-to-r {{ $service['color'] }} text-white font-bold text-xl rounded-xl hover:opacity-90 transition shadow-lg">
                            Отправить заявку
                        </button>
                        <p class="text-sm text-gray-400 text-center">Отправляя форму, вы соглашаетесь на обработку персональных данных</p>
                    </form>
                @else
                    <div class="text-center py-10">
                        <div class="text-6xl mb-4">✅</div>
                        <h3 class="text-3xl font-bold text-green-700 mb-2">Заявка отправлена!</h3>
                        <p class="text-lg text-gray-600">Мы свяжемся с вами в ближайшее время</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
