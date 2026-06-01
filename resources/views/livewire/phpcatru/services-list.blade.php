<div>
    <div class="background-radial-gradient py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-black text-white mb-3" style="text-shadow: 3px 3px 10px rgba(0,0,0,0.3);">
                Наши услуги
            </h1>
            <p class="text-2xl text-white/80 max-w-xl mx-auto">
                Выберите формат внедрения ИИ, который подходит именно вам
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10 space-y-8">
        @foreach ($services as $i => $s)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition overflow-hidden {{ $i % 2 == 0 ? '' : 'sm:flex-row-reverse' }} flex flex-col sm:flex-row">
                <div class="sm:w-1/3 bg-gradient-to-br {{ $i % 2 == 0 ? 'from-orange-50 to-yellow-50' : 'from-blue-50 to-indigo-50' }} p-10 flex flex-col items-center justify-center text-center">
                    <div class="text-7xl mb-3">{{ $s['icon'] }}</div>
                    <h2 class="text-3xl font-bold">{{ $s['title'] }}</h2>
                    <p class="text-lg text-orange-500 font-semibold">{{ $s['subtitle'] }}</p>
                </div>
                <div class="sm:w-2/3 p-10">
                    <p class="text-gray-700 text-lg mb-4">{{ $s['desc'] }}</p>
                    <ul class="space-y-3 mb-6">
                        @foreach ($s['benefits'] as $b)
                            <li class="flex items-start gap-2">
                                <span class="text-green-500 mt-0.5 text-lg">✓</span>
                                <span class="text-gray-600 text-base">{{ $b }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-black text-gray-800">{{ $s['price'] }}</span>
                        <a href="/service/{{ $s['slug'] }}"
                           class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold text-lg rounded-xl transition">
                            Подробнее →
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
