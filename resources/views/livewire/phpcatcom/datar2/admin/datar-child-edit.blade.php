<div class="p-6 bg-white rounded-xl shadow">
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block mb-1 font-medium">Название</label>
            <input type="text" wire:model="title" class="w-full border rounded p-2">
            @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div wire:ignore >
            <label class="block mb-1 font-medium">Контент</label>
            <textarea id="editor" class="w-full border rounded p-2" rows="10">
                {!! $content !!}
            </textarea>
        </div>
        @error('content') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror

        <div>
            <label class="block mb-1 font-medium">Порядок</label>
            <input type="number" wire:model="order" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model="is_active" class="mr-2">
                Активна
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Сохранить</button>
            <button type="button" wire:click="cancel" class="px-4 py-2 bg-gray-400 text-white rounded">Отмена</button>
        </div>
    </form>
</div>

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
                height: 300,
                removePlugins: 'elementspath',
                resize_enabled: false,
                licenseKey: 'GPL',
            });

            // При изменении контента — обновляем свойство Livewire
            editor.on('change', function() {
            @this.set('content', editor.getData());
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
