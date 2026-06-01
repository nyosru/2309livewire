<div>
    <div class="bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl p-8 text-center text-white shadow-xl">
        <h2 class="text-3xl font-bold mb-2">🎯 Чек-лист внедрения ИИ за 7 дней</h2>
        <p class="mb-6 text-white/90">Скачайте бесплатный чек-лист и узнайте, с чего начать внедрение ИИ в вашем бизнесе</p>

        @if (!$sent)
            <form wire:submit="submit" class="space-y-3 max-w-md mx-auto">
                <input wire:model="name" type="text" placeholder="Ваше имя"
                       class="w-full px-4 py-3 rounded-xl text-gray-900 placeholder-gray-400">
                @error('name') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror

                <input wire:model="email" type="email" placeholder="Ваш Email"
                       class="w-full px-4 py-3 rounded-xl text-gray-900 placeholder-gray-400">
                @error('email') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror

                <input wire:model="phone" type="text" placeholder="Ваш телефон"
                       class="w-full px-4 py-3 rounded-xl text-gray-900 placeholder-gray-400">
                @error('phone') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror

                <button type="submit"
                        class="w-full px-6 py-3 bg-white text-orange-600 font-bold rounded-xl hover:bg-gray-100 transition">
                    Скачать чек-лист
                </button>
                <p class="text-xs text-white/70">Отправляя форму, вы соглашаетесь на обработку персональных данных</p>
            </form>
        @else
            <div class="py-8">
                <div class="text-5xl mb-4">✅</div>
                <h3 class="text-2xl font-bold mb-2">Чек-лист отправлен!</h3>
                <p class="text-white/80">Проверьте вашу почту — мы отправили чек-лист и бонусные материалы</p>
            </div>
        @endif
    </div>
</div>
