<div class="w-full">

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

        <div>

            <div
                x-data="{
        content: @entangle('content').defer,
        format(cmd) {
            document.execCommand(cmd, false, null);
            this.update();
        },
        update() {
            this.content = $refs.editor.innerHTML;
        }
    }"
                class="space-y-2"
            >
                <label class="block text-sm font-medium text-gray-700 mb-1">Контент</label>

                <!-- Панель инструментов -->
                <div class="flex space-x-2 border rounded-md p-2 bg-gray-50">
                    <button type="button" @click="format('bold')" class="px-2 py-1 rounded hover:bg-gray-200 font-bold">
                        Ж
                    </button>
                    <button type="button" @click="format('italic')" class="px-2 py-1 rounded hover:bg-gray-200 italic">
                        К
                    </button>
                    <button type="button" @click="format('underline')"
                            class="px-2 py-1 rounded hover:bg-gray-200 underline">Ч
                    </button>
                </div>

                <!-- Поле редактирования -->
                <div
                    x-ref="editor"
                    contenteditable="true"
                    @input="update"
                    x-html="content"
                    class="min-h-[150px] border border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-indigo-300"
                ></div>

                @error('content')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


        </div>

        @if(1==2)
            <div wire:ignore>
                <label for="editor" class="block text-sm font-medium text-gray-700 mb-1">Контент</label>
                <textarea
                    {{--            id="content" --}}
                    rows="4"
                    wire:model.defer="content"
                    id="editor"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>
                @error('content') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        @endif

        {{--    <div>--}}
        {{--        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Родитель</label>--}}
        {{--        <select id="parent_id" wire:model.defer="parent_id"--}}
        {{--                class="w-full rounded-md border border-gray-300 px-3 py-2 bg-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">--}}
        {{--            <option value="">Выберите родителя</option>--}}
        {{--            @foreach($parents as $parent)--}}
        {{--                <option value="{{ $parent['id'] }}">{{ $parent['name'] ?? $parent['title'] ?? 'Родитель #' . $parent['id'] }}</option>--}}
        {{--            @endforeach--}}
        {{--        </select>--}}
        {{--        @error('parent_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror--}}
        {{--    </div>--}}

        {{--    <div>--}}
        {{--        <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Порядок</label>--}}
        {{--        <input id="order" type="number" min="0" wire:model.defer="order"--}}
        {{--               class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />--}}
        {{--        @error('order') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror--}}
        {{--    </div>--}}

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
