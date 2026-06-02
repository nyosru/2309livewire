<div>
    <div class="background-radial-gradient py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="title_head">
                Свяжитесь с нами
            </h1>
            <p class="opis_head">
                Оставьте заявку — и мы подберём лучшее решение для ваших задач
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <h2 class="text-3xl font-bold mb-8">Напишите нам</h2>

                @if (!$sent)
                    <form wire:submit="submit" class="space-y-5">
                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-1">Ваше имя *</label>
                            <input wire:model="name" type="text"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg focus:ring-2 focus:ring-orange-300 focus:border-orange-300">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-1">Телефон *</label>
                            <input wire:model="phone" type="text"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg focus:ring-2 focus:ring-orange-300 focus:border-orange-300">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-1">Email</label>
                            <input wire:model="email" type="email"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg focus:ring-2 focus:ring-orange-300 focus:border-orange-300">
                        </div>

                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-1">Услуга</label>
                            <select wire:model="service"
                                    class="w-full px-5 py-4 rounded-xl border border-gray-300 bg-white text-lg focus:ring-2 focus:ring-orange-300 focus:border-orange-300">
                                @foreach ($services as $val => $label)
                                    <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-base font-medium text-gray-700 mb-1">Сообщение</label>
                            <textarea wire:model="message" rows="5"
                                      class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg focus:ring-2 focus:ring-orange-300 focus:border-orange-300"></textarea>
                        </div>

                        <button type="submit"
                                class="w-full px-6 py-5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xl rounded-xl transition shadow-lg">
                            Отправить заявку
                        </button>
                        <p class="text-sm text-gray-400 text-center">Отправляя форму, вы соглашаетесь на обработку персональных данных</p>
                    </form>
                @else
                    <div class="text-center py-12 bg-green-50 rounded-2xl">
                        <div class="text-6xl mb-4">✅</div>
                        <h3 class="text-3xl font-bold text-green-700 mb-2">Спасибо!</h3>
                        <p class="text-lg text-gray-600">Мы получили вашу заявку и свяжемся с вами в ближайшее время</p>
                    </div>
                @endif
            </div>

            <div class="lg:pl-8">
                <h2 class="text-3xl font-bold mb-8">Контакты</h2>
                <div class="space-y-6 text-gray-700 text-lg">
                    <div class="flex items-start gap-3">
                        <div class="text-2xl mt-0.5">📍</div>
                        <div>
                            <h4 class="font-bold text-xl">Регион</h4>
                            <p>Тюмень, Россия.<br/>Работаем удалённо по всей стране.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="text-2xl mt-0.5">💬</div>
                        <div>
                            <h4 class="font-bold text-xl">VK</h4>
                            <a href="https://vk.com/tymenskie" target="_blank"
                               class="text-blue-600 hover:underline">vk.com/tymenskie</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="text-2xl mt-0.5">⏰</div>
                        <div>
                            <h4 class="font-bold text-xl">Режим работы</h4>
                            <p>Пн-Пт: 10:00–19:00<br/>Сб: по договорённости<br/>Поддержка: 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
