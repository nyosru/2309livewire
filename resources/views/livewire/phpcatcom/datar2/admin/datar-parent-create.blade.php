<div >

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




@if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">


{{--        <div>--}}
{{--            <label>Родитель</label>--}}
{{--            <select wire:model.defer="parent_id">--}}
{{--                <option value="">Выберите родителя</option>--}}
{{--                @foreach($parents as $parent)--}}
{{--                    <option value="{{ $parent['id'] }}">{{ $parent['name'] ?? $parent['title'] ?? 'Родитель #'.$parent['id'] }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            @error('parent_id') <span class="error">{{ $message }}</span> @enderror--}}
{{--        </div>--}}

        <div>
            <label>Заголовок</label>
            <input type="text" wire:model.defer="title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        @if(1==2)
        <div>
            <label>Контент</label>
            <textarea wire:model.defer="content"></textarea>
            @error('content') <span class="error">{{ $message }}</span> @enderror
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

        @endif


{{--        <div>--}}
{{--            <label>Порядок</label>--}}
{{--            <input type="number" min="0" wire:model.defer="order">--}}
{{--            @error('order') <span class="error">{{ $message }}</span> @enderror--}}
{{--        </div>--}}

        <div>
            <label>
                <input type="checkbox" wire:model.defer="is_active">
                Активен
            </label>
            @error('is_active') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Создать</button>
    </form>
</div>
