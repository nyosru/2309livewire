<div>
    <div class="background-radial-gradient py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-black text-white mb-3" style="text-shadow: 3px 3px 10px rgba(0,0,0,0.3);">
                Кейсы внедрения ИИ
            </h1>
            <p class="text-2xl text-white/80 max-w-xl mx-auto">
                Реальные проекты, реальные результаты
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10 space-y-8">
        @foreach ($cases as $c)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10">
                <div class="flex items-start gap-2 mb-2">
                    <span class="px-4 py-1.5 bg-orange-100 text-orange-700 text-sm font-bold rounded-full">{{ $c['tag'] }}</span>
                </div>
                <h2 class="text-3xl font-bold mb-2">{{ $c['title'] }}</h2>
                <p class="text-gray-500 text-base mb-3">{{ $c['client'] }}</p>
                <div class="bg-green-50 border border-green-200 rounded-xl px-5 py-4 mb-4 text-green-800 font-semibold text-lg">
                    📈 {{ $c['result'] }}
                </div>
                <p class="text-gray-700 text-lg">{{ $c['desc'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="container mx-auto px-4 pb-10 text-center">
        <a href="/contacts"
           class="inline-block px-10 py-5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xl rounded-xl transition shadow-lg">
            Хочу так же — заказать внедрение
        </a>
    </div>
</div>
