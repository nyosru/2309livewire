<div class="bg-gradient-to-r from-blue-50 to-indigo-50 py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900">Последнее в блоге</h2>
                <p class="text-lg text-gray-600 mt-1">Новости, статьи и полезные материалы об ИИ</p>
            </div>
            <a href="/blog"
               class="hidden sm:inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-orange-300 hover:text-orange-600 transition shadow-sm">
                Все записи
                <span class="text-lg">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach ($posts as $i => $post)
                <a href="/blog/{{ $post['slug'] }}"
                   class="group block @if ($i > 0) hidden sm:block @endif">
                    <div class="h-full p-6 sm:p-8 rounded-2xl bg-white border border-gray-100 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="text-sm text-orange-500 font-semibold mb-3">
                            {{ $post['published_at'] }}
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition">
                            {{ $post['title'] }}
                        </h3>
                        <p class="text-gray-600 text-base leading-relaxed">
                            {{ Str::limit($post['excerpt'], 120) }}
                        </p>
                        <div class="mt-4 flex items-center gap-1 text-orange-500 font-semibold group-hover:gap-2 transition-all">
                            Читать дальше
                            <span>→</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-6 sm:hidden">
            <a href="/blog"
               class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-orange-300 hover:text-orange-600 transition shadow-sm">
                Все записи в блоге
                <span class="text-lg">→</span>
            </a>
        </div>
    </div>
</div>
