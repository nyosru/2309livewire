<div class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <form wire:submit.prevent="createNews" class="space-y-6" enctype="multipart/form-data">
        <!-- Заголовок -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Заголовок</label>
            <input type="text" wire:model="title" id="title"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300
                          rounded-md shadow-sm focus:outline-none
                          focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Краткий текст -->
        <div>
            <label for="summary" class="block text-sm font-medium text-gray-700">Краткий текст</label>
            <textarea wire:model="summary" id="summary" rows="3"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300
                             rounded-md shadow-sm focus:outline-none
                             focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      required></textarea>
            @error('summary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Описание -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Описание</label>
            <textarea wire:model="content" id="content" rows="6"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300
                             rounded-md shadow-sm focus:outline-none
                             focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                      required></textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Дата публикации -->
        <div>
            <label for="published_at" class="block text-sm font-medium text-gray-700">Дата публикации</label>
            <input type="date" wire:model="published_at" id="published_at"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300
                          rounded-md shadow-sm focus:outline-none
                          focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                   required>
            @error('published_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Промокод -->
        <div>
            <label for="promo_code" class="block text-sm font-medium text-gray-700">Промокод</label>
            <input type="text" wire:model="promo_code" id="promo_code"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300
                          rounded-md shadow-sm focus:outline-none
                          focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            @error('promo_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Загрузка изображений -->
        <div>
            <label for="photos" class="block text-sm font-medium text-gray-700">Загрузить изображения</label>
            <input type="file" wire:model="photos" id="photos" multiple
                   class="mt-1 block w-full text-sm text-gray-500
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-md file:border-0
                          file:text-sm file:font-semibold
                          file:bg-blue-50 file:text-blue-700
                          hover:file:bg-blue-100"/>
            @error('photos.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <!-- Показ загруженных изображений -->
            @if ($photos)
                <div class="mt-4 flex flex-wrap gap-4">
                    @foreach ($photos as $photo)
                        <div class="relative w-32 h-32">
                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover rounded-md">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Кнопка добавления -->
        <div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 border border-transparent
                           rounded-md shadow-sm text-sm font-medium hover:bg-blue-700
                           focus:outline-none focus:ring-2 focus:ring-offset-2
                           focus:ring-blue-500">
                Добавить новость
            </button>
        </div>
    </form>
</div>
