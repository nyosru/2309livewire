<div>
    <div class="background-radial-gradient py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl sm:text-5xl font-black text-white mb-3" style="text-shadow: 3px 3px 10px rgba(0,0,0,0.3);">
                Новая запись в блоге
            </h1>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto bg-white p-8 md:p-10 rounded-2xl shadow-sm">
            @if (session('success'))
                <div class="mb-6 px-6 py-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-lg font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit="save" class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Заголовок</label>
                    <input type="text" wire:model="title"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 outline-none transition text-lg">
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Тег (категория)</label>
                    <input type="text" wire:model="tag"
                           class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 outline-none transition"
                           placeholder="Например: Статья, Обзор, Гайд, Подборка">
                    @error('tag') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Краткое описание (excerpt)</label>
                    <textarea wire:model="excerpt" rows="2"
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 outline-none transition"
                              placeholder="Короткое описание для списка статей"></textarea>
                    @error('excerpt') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Содержимое</label>
                    <textarea wire:model="content" rows="15"
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 outline-none transition text-lg leading-relaxed font-mono"></textarea>
                    @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" wire:model="is_published" id="is_published"
                           class="w-5 h-5 rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    <label for="is_published" class="text-gray-700 font-semibold">Опубликовано</label>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                            class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold text-lg rounded-xl transition shadow-lg">
                        Сохранить
                    </button>
                    <a href="/blog"
                       class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-lg rounded-xl transition">
                        Отмена
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
