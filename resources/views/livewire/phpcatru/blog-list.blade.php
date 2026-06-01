<div>
    <div class="background-radial-gradient py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-black text-white mb-3" style="text-shadow: 3px 3px 10px rgba(0,0,0,0.3);">
                Блог об ИИ
            </h1>
            <p class="text-2xl text-white/80 max-w-xl mx-auto">
                Статьи, гайды и новости из мира искусственного интеллекта
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($posts as $p)
                <a href="/blog/{{ $p['slug'] }}" class="block group">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition h-full flex flex-col">
                        <div class="p-8 flex flex-col flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-sm font-bold rounded-full">{{ $p['tag'] }}</span>
                                <span class="text-gray-400 text-sm">{{ $p['date'] }}</span>
                            </div>
                            <h2 class="text-xl font-bold mb-3 group-hover:text-orange-600 transition">{{ $p['title'] }}</h2>
                            <p class="text-gray-600 text-base flex-1">{{ $p['excerpt'] }}</p>
                            <div class="mt-4 text-orange-500 font-semibold text-base group-hover:translate-x-1 transition inline-block">
                                Читать далее →
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
