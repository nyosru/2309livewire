<div>

    <livewire:tech.menu type="cfa"/>

    <livewire:app.breadcrumb :menu="[
        [ 'name' => 'Тех. отдел',
         'link'=>'no' ],
        [ 'name' => 'База знаний',
        'route' => 'tech.datar2',
         ],
        [ 'name' => 'Редактируем группу', 'link'=>'no'
         ],
    ]"/>
    {{--        [ 'name' => '', 'route' => '',  'route-var' => [], 'link'=>'no' ],--}}


    <div class="container mx-auto pb-4 bg-white shadow rounded-lg">


        @if (session()->has('success'))
            <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        {{--title: {{ $title }}--}}
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <label for="title" class="block font-medium text-gray-700">Title</label>
                <input type="text" id="title" wire:model="title" class="mt-1 block w-full border rounded p-2"/>
                @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            @if(1==2)
                <div>
                    <label for="content" class="block font-medium text-gray-700">Content</label>
                    <textarea id="content" wire:model.defer="content" rows="4"
                              class="mt-1 block w-full border rounded p-2"></textarea>
                    @error('content') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            @else

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

            @endif

            {{--        <div>--}}
            {{--            <label for="order" class="block font-medium text-gray-700">Order</label>--}}
            {{--            <input type="number" id="order" wire:model.defer="order" class="mt-1 block w-full border rounded p-2" />--}}
            {{--            @error('order') <span class="text-red-600">{{ $message }}</span> @enderror--}}
            {{--        </div>--}}

            <div class="flex items-center">
                <input type="checkbox" id="is_active" wire:model.defer="is_active" class="mr-2"/>
                <label for="is_active" class="font-medium text-gray-700">Active</label>
                @error('is_active') <span class="text-red-600 ml-4">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>
