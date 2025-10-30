<div>
    <livewire:tech.menu type="cfa" />


    <div class="container mx-auto px-4 py-8 max-w-4xl">


    <!-- Заголовок -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Создание новости</h1>
        <p class="text-gray-600">Заполните форму для добавления новой новости</p>
    </div>

    <!-- Форма -->
    <form wire:submit="save" class="bg-white rounded-lg shadow-md p-6">
        <!-- Заголовок -->
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Заголовок новости *
            </label>
            <input
                type="text"
                id="title"
                wire:model="title"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Введите заголовок новости"
            >
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Краткое описание -->
        <div class="mb-6">
            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                Краткое описание
            </label>
            <textarea
                id="excerpt"
                wire:model="excerpt"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Краткое описание новости (необязательно)"
            ></textarea>
            @error('excerpt') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Содержание -->
        <div class="mb-6">
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                Содержание новости *
            </label>

            @if(1==2)
            <textarea
                id="content"
                wire:model="content"
                rows="10"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="Полное содержание новости"
            ></textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @endif

            <div wire:ignore>
                <label class="block mb-1 font-medium">Контент</label>
                <textarea id="editor" class="w-full border rounded p-2" rows="10">
                {!! $content !!}
            </textarea>
            </div>
            @error('content') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

            @push('scripts')

                <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

                <script>
                    document.addEventListener('livewire:navigated', initEditor);
                    document.addEventListener('livewire:load', initEditor);

                    function initEditor() {
                        if (window.editorInitialized) return; // чтобы не инициализировать повторно
                        window.editorInitialized = true;

                        const textarea = document.getElementById('editor');
                        if (!textarea) return;

                        const editor = CKEDITOR.replace('editor', {
                            licenseKey: 'GPL',
                            height: 300,
                            removePlugins: 'elementspath',
                            resize_enabled: false,
                        });

                        // При изменении контента — обновляем свойство Livewire
                        editor.on('change', function () {
                        @this.set('content', editor.getData())
                            ;
                        });

                        // После рендера вставляем начальное значение
                        Livewire.hook('message.processed', (message, component) => {
                            if (editor.getData() !== @this.get('content')) {
                                editor.setData(@this.get('content') ?? '');
                            }
                        });

                        // В первый раз тоже вставляем данные
                        editor.setData(@this.get('content') ?? '');
                    }
                </script>
            @endpush


        </div>

        <!-- Изображение -->
        <div class="mb-6">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Изображение
            </label>
            <input
                type="file"
                id="image"
                wire:model="image"
                accept="image/*"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg"
            >
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            @if($image)
                <div class="mt-2">
                    <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded">
                </div>
            @endif
        </div>

        <!-- Статус публикации -->
        <div class="mb-6">
            <label class="flex items-center">
                <input
                    type="checkbox"
                    wire:model="is_published"
                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                >
                <span class="ml-2 text-sm text-gray-700">Опубликовать сразу</span>
            </label>
        </div>

        @if($is_published)
            <!-- Дата публикации -->
            <div class="mb-6">
                <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                    Дата и время публикации
                </label>
                <input
                    type="datetime-local"
                    id="published_at"
                    wire:model="published_at"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                @error('published_at') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <!-- Кнопки -->
        <div class="flex justify-end space-x-4">
            <button
                type="button"
                wire:click="cancel"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
            >
                Отмена
            </button>
            <button
                type="submit"
                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
            >
                Сохранить новость
            </button>
        </div>
    </form>
</div>
</div>
