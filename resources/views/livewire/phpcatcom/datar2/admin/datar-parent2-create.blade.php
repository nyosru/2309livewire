<div >

    <livewire:tech.menu type="cfa"/>

    <livewire:app.breadcrumb :menu="[
        [ 'name' => 'Тех. отдел',
         'link'=>'no' ],
        [ 'name' => 'База знаний',
        'route' => 'tech.datar2',
         ],
        [ 'name' => 'Добавить группу',
        'route' => 'tech.datar2.parents.create',
         ],
    ]"/>
    {{--        [ 'name' => '', 'route' => '',  'route-var' => [], 'link'='no' ],--}}


    <form wire:submit.prevent="save" class="max-w-xl mx-auto pb-6 bg-white rounded-lg shadow-md space-y-6">

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
            <input id="title" type="text" wire:model.defer="title"
                   class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>
            @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

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



            <div class="flex items-center space-x-2">
            <input id="is_active" type="checkbox" wire:model.defer="is_active"
                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"/>
            <label for="is_active" class="text-sm font-medium text-gray-700">Активен</label>
            @error('is_active') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Создать
        </button>
    </form>

    {{-- подключаем CKEditor без CDN --}}
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>


    <script>
        document.addEventListener('livewire:load', () => {
            // Инициализация CKEditor
            const editor = CKEDITOR.replace('editor');

            // Обновляем Livewire при изменении текста
            editor.on('change', function () {
            @this.set('content', editor.getData())
                ;
            });

            // Повторная инициализация после обновления DOM
            Livewire.hook('morph.updated', () => {
                if (!CKEDITOR.instances.editor) {
                    const newEditor = CKEDITOR.replace('editor');
                    newEditor.on('change', function () {
                    @this.set('content', newEditor.getData())
                        ;
                    });
                }
            });
        });
    </script>

</div>
