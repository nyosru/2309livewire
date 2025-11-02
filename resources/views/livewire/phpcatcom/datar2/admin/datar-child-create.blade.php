<div>
    <livewire:tech.menu type="cfa" />

    <livewire:app.breadcrumb :menu="[
        [ 'name' => 'Тех. отдел',
         'link'=>'no' ],
        [ 'name' => 'База знаний',
        'route' => 'tech.datar2',
         ],
        [ 'name' => 'Добавить запись', 'link'=>'no'
         ],
    ]" />
    {{--        [ 'name' => '', 'route' => '',  'route-var' => [], 'link'=>'no' ],--}}

    <div class=" container mx-auto">


    @if (session()->has('message'))
        <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4 ">


        <div>
            <label class="block font-semibold mb-1">Родитель</label>
            <select wire:model.defer="parent_id" class="w-full px-3 py-2 border rounded" required >
                <option value="">Выберите родителя</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent['id'] }}">{{ $parent['title'] ?? 'Родитель #' . $parent['id'] }}</option>
                @endforeach
            </select>
            @error('parent_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold mb-1">Заголовок</label>
            <input type="text" wire:model.defer="title" class="w-full px-3 py-2 border rounded" />
            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        @if(1==2)
        <div>
            <label class="block font-semibold mb-1">Контент</label>
            <textarea wire:model.defer="content" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
            @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
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
                        height: 300,
                        removePlugins: 'elementspath',
                        resize_enabled: false,
                        licenseKey: 'GPL',
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


        {{--        <div>--}}
{{--            <label class="block font-semibold mb-1">Порядок</label>--}}
{{--            <input type="number" min="0" wire:model.defer="order" class="w-full px-3 py-2 border rounded" />--}}
{{--            @error('order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror--}}
{{--        </div>--}}

        <div class="flex items-center space-x-2">
            <input id="is_active" type="checkbox" wire:model.defer="is_active" class="rounded" />
            <label for="is_active" class="text-sm font-semibold">Активен</label>
            @error('is_active') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
            Создать
        </button>
    </form>
</div>
</div>
