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

    <div class="w-full md:w-[400px] mx-auto">


    @if (session()->has('message'))
        <div class="alert alert-success mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4 max-w-md">


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

        <div>
            <label class="block font-semibold mb-1">Контент</label>
            <textarea wire:model.defer="content" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
            @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>


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
