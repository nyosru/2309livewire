<div class="p-4">
    <div class="flex flex-col md:flex-row md:space-x-8">
        {{-- Левая колонка: Список сайтов --}}
        <div class="md:w-1/2">
            <h2 class="text-xl font-bold mb-4">Список сайтов</h2>

            @if (session()->has('message'))
                <div class="mb-4 p-2 bg-green-200 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <ul class="mb-4">
                @forelse($sites as $site)
                    @livewire('st-news.a.st-news-site-item', ['site' => $site], key($site->id))
                @empty
                    <li class="text-gray-500">Нет сайтов</li>
                @endforelse
            </ul>
        </div>

        {{-- Правая колонка: Форма добавления нового сайта --}}
        <div class="md:w-1/2">
            <h2 class="text-xl font-bold mb-4">Добавить новый сайт</h2>

            <form wire:submit.prevent="addSite" class="space-y-4">
                {{-- Название сайта --}}
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700">Название сайта</label>
                    <input
                        type="text"
                        wire:model="site_name"
                        id="site_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Введите название сайта">
                    @error('site_name')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- URL сайта --}}
                <div>
                    <label for="site_url" class="block text-sm font-medium text-gray-700">URL сайта</label>
                    <input
                        type="text"
                        wire:model="site_url"
                        id="site_url"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Введите URL сайта">
                    @error('site_url')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- URL парсинга категории --}}
                <div>
                    <label for="category_parsing_url" class="block text-sm font-medium text-gray-700">URL парсинга категории</label>
                    <input
                        type="text"
                        wire:model="category_parsing_url"
                        id="category_parsing_url"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Введите URL для парсинга категории">
                    @error('category_parsing_url')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Время до автопубликации --}}
                <div>
                    <label for="time_to_auto_publish" class="block text-sm font-medium text-gray-700">Время до автопубликации (в минутах)</label>
                    <input
                        type="number"
                        wire:model="time_to_auto_publish"
                        id="time_to_auto_publish"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                        placeholder="Введите время до автопубликации">
                    @error('time_to_auto_publish')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Модерация при загрузке --}}
                <div>
                    <label for="moderation_on_upload" class="block text-sm font-medium text-gray-700">Модерация при загрузке</label>
                    <input
                        type="checkbox"
                        wire:model="moderation_on_upload"
                        id="moderation_on_upload"
                        class="mt-1">
                    Включить модерацию при загрузке
                    @error('moderation_on_upload')
                    <div class="text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Кнопка добавить --}}
                <div>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">
                        Добавить сайт
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
