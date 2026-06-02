<div>
    <div class="background-radial-gradient py-16">
        <div class="container mx-auto px-4 text-center">
            <span class="px-4 py-1.5 bg-white/20 text-white text-sm font-bold rounded-full mb-3 inline-block">{{ $post['tag'] }}</span>
            <h1 class="text-4xl sm:text-5xl font-black text-white mb-3" style="text-shadow: 3px 3px 10px rgba(0,0,0,0.3);">
                {{ $post['title'] }}
            </h1>
            <p class="text-white/70 text-lg">{{ $post['date'] }}</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <article class="max-w-3xl mx-auto">
            <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm">
                <div class="prose prose-lg max-w-none space-y-6">
                    @foreach ($post['content'] as $paragraph)
                        <p class="text-gray-700 text-lg leading-relaxed">{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 bg-gradient-to-r from-orange-50 to-yellow-50 rounded-2xl p-10 text-center border border-orange-100">
                <h3 class="text-3xl font-bold mb-2">Хотите внедрить ИИ в свой бизнес?</h3>
                <p class="text-lg text-gray-600 mb-6">Мы поможем — от идеи до работающего решения за 1 день</p>
                <a href="/contacts"
                   class="inline-block px-10 py-5 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xl rounded-xl transition shadow-lg">
                    Заказать консультацию
                </a>
            </div>

            <div class="text-center mt-8">
                <a href="/blog" class="text-orange-500 font-semibold text-lg hover:underline">← Все статьи</a>
            </div>
        </article>
    </div>
</div>
