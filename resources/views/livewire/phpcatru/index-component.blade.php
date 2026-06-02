<div>

    {{-- Hero --}}
    <div class="background-radial-gradient py-20 sm:py-32">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl sm:text-7xl font-black text-white mb-6" style="text-shadow: 3px 3px 12px rgba(0,0,0,0.3);">
                Внедряем ИИ в ваш бизнес<br/>
                <span class="text-yellow-300">за 1 день</span>
            </h1>
            <p class="text-2xl sm:text-3xl text-white/90 max-w-3xl mx-auto mb-10" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">
                Вы получаете готового ИИ-ассистента, который работает 24/7 без зарплаты, отпусков и больничных
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/services"
                   class="px-10 py-5 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold text-xl rounded-xl shadow-lg transition transform hover:scale-105">
                    Смотреть услуги
                </a>
                <a href="/contacts"
                   class="px-10 py-5 bg-gray-700/20 hover:bg-gray-900/30 text-black hover:text-white  font-bold text-xl rounded-xl shadow-lg transition transform hover:scale-105">
                    Бесплатная консультация
                </a>
            </div>
        </div>
    </div>

    {{-- Соцдоказательство --}}
    <div class="bg-white py-10 shadow-inner">
        <div class="container mx-auto px-4 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-4xl sm:text-5xl font-black text-orange-500">50+</div>
                <div class="text-base sm:text-lg text-gray-600">внедрений ИИ</div>
            </div>
            <div>
                <div class="text-4xl sm:text-5xl font-black text-orange-500">97%</div>
                <div class="text-base sm:text-lg text-gray-600">довольных клиентов</div>
            </div>
            <div>
                <div class="text-4xl sm:text-5xl font-black text-orange-500">2 дня</div>
                <div class="text-base sm:text-lg text-gray-600">средний срок запуска</div>
            </div>
            <div>
                <div class="text-4xl sm:text-5xl font-black text-orange-500">40%</div>
                <div class="text-base sm:text-lg text-gray-600">рост эффективности</div>
            </div>
        </div>
    </div>

    {{-- Рекламный блок 1: ChatGPT / GigaChat --}}
    <div class="container mx-auto px-4 py-12">
        <div class="rounded-2xl overflow-hidden shadow-xl bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex flex-col sm:flex-row items-center">
            <div class="sm:w-2/3 p-8 sm:p-12">
                <div class="text-6xl mb-4">🤖</div>
                <h2 class="text-3xl sm:text-4xl font-black mb-3">DeepSeek, ChatGPT, GigaChat, YandexGPT</h2>
                <p class="text-xl text-white/80 mb-6">Подключим и настроим любые нейросети (бесплатные в том числе) под ваши задачи. Работает из коробки.</p>
                <a href="/services"
                   class="inline-block px-8 py-4 bg-white text-blue-700 font-bold text-lg rounded-xl hover:bg-gray-100 transition shadow-lg">
                    Выбрать модель →
                </a>
            </div>

        </div>
    </div>

    {{-- Блок услуг --}}
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-4xl font-bold text-center mb-3">Ваши выгоды от внедрения ИИ</h2>
        <p class="text-xl text-center text-gray-600 mb-10">Выберите подходящий формат сотрудничества</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($services as $i => $s)
                <a href="/service/{{ $s['slug'] }}"
                   class="block group">
                    <div class="h-full p-8 rounded-2xl border-2 border-gray-100 hover:border-orange-300 bg-white shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="text-5xl mb-4">{{ $s['icon'] }}</div>
                        <h3 class="text-2xl font-bold mb-2 group-hover:text-orange-600 transition">{{ $s['title'] }}</h3>
                        <p class="text-base text-orange-500 font-semibold mb-3">{{ $s['sub'] }}</p>
                        <p class="text-gray-600 text-base mb-4">{{ $s['desc'] }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-black text-gray-800">{{ $s['price'] }}</span>
                            <span class="text-orange-500 text-xl group-hover:translate-x-1 transition inline-block">→</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- "Почему мы №1" --}}
    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-10">Почему выбирают нас</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-6xl mb-4">⚡</div>
                    <h3 class="font-bold text-2xl mb-2">Запуск за 1 день</h3>
                    <p class="text-gray-600 text-lg">Приехали, настроили, показали — вы работаете</p>
                </div>
                <div>
                    <div class="text-6xl mb-4">🔧</div>
                    <h3 class="font-bold text-2xl mb-2">Под ключ</h3>
                    <p class="text-gray-600 text-lg">Ничего не нужно делать — мы берём всё на себя</p>
                </div>
                <div>
                    <div class="text-6xl mb-4">📞</div>
                    <h3 class="font-bold text-2xl mb-2">Поддержка 24/7</h3>
                    <p class="text-gray-600 text-lg">Всегда на связи, если что-то пошло не так</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Блог --}}
    <livewire:Phpcatru.blog-informer />

    {{-- Рекламный блок 2: Аудит безопасности --}}
    <div class="container mx-auto px-4 py-12">
        <div class="rounded-2xl overflow-hidden shadow-xl bg-gradient-to-r from-red-600 to-rose-700 text-white flex flex-col sm:flex-row-reverse items-center">
            <div class="sm:w-1/2 p-8 sm:p-12">
                <div class="text-6xl mb-4">🔒</div>
                <h2 class="text-3xl sm:text-4xl font-black mb-3">Проверьте сеть на безопасность</h2>
                <p class="text-xl text-white/80 mb-6">Бесплатный аудит при заказе любой услуги. Только в этом месяце.</p>
                <a href="/service/security"
                   class="inline-block px-8 py-4 bg-white text-red-700 font-bold text-lg rounded-xl hover:bg-gray-100 transition shadow-lg">
                    Заказать аудит →
                </a>
            </div>
            <div class="sm:w-1/2 h-64 sm:h-80 w-full bg-cover bg-center"
                 style="background-image: url('/phpcat/img/security-audit.jpg');">
            </div>
        </div>
    </div>

    {{-- Lead Magnet --}}
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl p-10 text-center text-white shadow-xl">
            <h2 class="text-4xl font-bold mb-3">🎯 Чек-лист внедрения ИИ за 7 дней</h2>
            <p class="text-xl mb-6 text-white/90">Скачайте бесплатный чек-лист и узнайте, с чего начать внедрение ИИ в вашем бизнесе</p>

            @if (!$sent)
                <form wire:submit="submit" class="space-y-4 max-w-md mx-auto">
                    <input wire:model="name" type="text" placeholder="Ваше имя"
                           class="w-full px-5 py-4 rounded-xl text-gray-900 placeholder-gray-400 text-lg">
                    @error('name') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror

                    <input wire:model="email" type="email" placeholder="Ваш Email"
                           class="w-full px-5 py-4 rounded-xl text-gray-900 placeholder-gray-400 text-lg">
                    @error('email') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror

                    <input wire:model="phone" type="text" placeholder="Ваш телефон"
                           class="w-full px-5 py-4 rounded-xl text-gray-900 placeholder-gray-400 text-lg">
                    @error('phone') <span class="text-red-200 text-sm">{{ $message }}</span> @enderror

                    <button type="submit"
                            class="w-full px-6 py-4 bg-white text-orange-600 font-bold text-lg rounded-xl hover:bg-gray-100 transition">
                        Скачать чек-лист
                    </button>
                    <p class="text-sm text-white/70">Отправляя форму, вы соглашаетесь на обработку персональных данных</p>
                </form>
            @else
                <div class="py-8">
                    <div class="text-6xl mb-4">✅</div>
                    <h3 class="text-3xl font-bold mb-2">Чек-лист отправлен!</h3>
                    <p class="text-xl">Проверьте вашу почту — мы отправили чек-лист и бонусные материалы</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Кейсы --}}
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-3">Результаты наших клиентов</h2>
            <p class="text-xl text-center text-gray-600 mb-10">Реальные цифры и истории внедрения</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $quickCases = [
                        ['emoji' => '🏪', 'title' => 'Интернет-магазин', 'result' => 'Ответ клиентам — 2 минуты вместо 2 часов'],
                        ['emoji' => '📝', 'title' => 'Маркетинговое агентство', 'result' => 'Контента в 5 раз больше без найма копирайтеров'],
                        ['emoji' => '⚖️', 'title' => 'Юридическая компания', 'result' => 'Анализ договоров — 15 минут вместо 3 часов'],
                        ['emoji' => '📞', 'title' => 'Оптовая компания', 'result' => 'Конверсия в продажи +40% за 2 недели'],
                    ];
                @endphp
                @foreach ($quickCases as $c)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-start gap-4">
                        <div class="text-4xl">{{ $c['emoji'] }}</div>
                        <div>
                            <h3 class="text-xl font-bold">{{ $c['title'] }}</h3>
                            <p class="text-gray-600 text-base">{{ $c['result'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="/cases" class="text-orange-500 font-semibold text-lg hover:underline">Все кейсы →</a>
            </div>
        </div>
    </div>

    {{-- Форма захвата --}}
    <div class="container mx-auto px-4 py-12 max-w-xl text-center">
        <h2 class="text-4xl font-bold mb-3">Остались вопросы?</h2>
        <p class="text-xl text-gray-600 mb-8">Оставьте заявку — мы перезвоним и бесплатно проконсультируем</p>

        @if (!$sent)
            <form wire:submit="submit" class="space-y-4">
                <input wire:model="name" type="text" placeholder="Ваше имя"
                       class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input wire:model="phone" type="text" placeholder="Ваш телефон"
                       class="w-full px-5 py-4 rounded-xl border border-gray-300 text-lg">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <select wire:model="service"
                        class="w-full px-5 py-4 rounded-xl border border-gray-300 bg-white text-lg">
                    <option value="">— Выберите услугу —</option>
                    @foreach ($services as $s)
                        <option value="{{ $s['slug'] }}">{{ $s['title'] }}</option>
                    @endforeach
                </select>

                <button type="submit"
                        class="w-full px-6 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xl rounded-xl transition">
                    Заказать консультацию
                </button>
            </form>
        @else
            <div class="py-8 bg-green-50 rounded-2xl">
                <div class="text-6xl mb-4">✅</div>
                <h3 class="text-3xl font-bold text-green-700 mb-2">Спасибо!</h3>
                <p class="text-xl text-gray-600">Мы свяжемся с вами в ближайшее время</p>
            </div>
        @endif
    </div>

    {{-- Дефицит + срочность --}}
    <div class="bg-gray-900 text-white py-10 text-center">
        <p class="text-2xl font-bold">🎉 Только в этом месяце: <span class="text-yellow-300">бесплатный аудит сети</span> при заказе любой настройки ИИ</p>
        <p class="text-base text-gray-400 mt-2">Осталось 2 места на эту неделю. Успейте!</p>
    </div>

</div>
