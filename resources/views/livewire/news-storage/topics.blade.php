<div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold text-gray-900">Темы новостей</h1>
        <a href="{{ route('news-storage.admin.news') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">К общему списку новостей</a>
    </div>

    @if($message)
        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-sm text-green-800">{{ $message }}</div>
    @endif

    <form wire:submit="save" class="mb-8 grid grid-cols-1 gap-4 rounded-lg bg-white p-5 shadow-sm md:grid-cols-2">
        <h2 class="text-lg font-semibold md:col-span-2">{{ $editingId ? 'Изменить тему' : 'Добавить тему' }}</h2>
        <label class="block text-sm text-gray-700">
            Название на русском
            <input wire:model="name_ru" type="text" class="mt-1 w-full rounded border-gray-300 text-sm shadow-sm">
            @error('name_ru') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </label>
        <label class="block text-sm text-gray-700">
            Название на английском
            <input wire:model="name_en" type="text" class="mt-1 w-full rounded border-gray-300 text-sm shadow-sm">
            @error('name_en') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </label>
        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input wire:model="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600">
            Тема доступна для выбора
        </label>
        <div class="flex items-end gap-2">
            <button type="submit" class="rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Сохранить</button>
            @if($editingId)
                <button type="button" wire:click="cancelEdit" class="rounded px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">Отмена</button>
            @endif
        </div>
    </form>

    <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow-sm">
        @forelse($topics as $topic)
            <div class="flex flex-wrap items-center justify-between gap-4 p-4">
                <div>
                    <div class="flex flex-wrap items-center gap-2">
                        <h2 class="font-semibold text-gray-900">{{ $topic->name_ru }}</h2>
                        <span class="text-sm text-gray-500">{{ $topic->name_en }}</span>
                        <span class="rounded-full px-2 py-0.5 text-sm {{ $topic->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                            {{ $topic->is_active ? 'Активна' : 'Отключена' }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Новостей с этой темой: {{ $topic->news_count }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" wire:click="edit({{ $topic->id }})" class="rounded px-3 py-1.5 text-sm text-indigo-600 hover:bg-indigo-50">Изменить</button>
                    <button type="button" wire:click="toggleActive({{ $topic->id }})" class="rounded px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100">
                        {{ $topic->is_active ? 'Отключить' : 'Включить' }}
                    </button>
                    <button type="button" wire:click="delete({{ $topic->id }})" wire:confirm="Удалить тему? Она также исчезнет у связанных новостей." class="rounded px-3 py-1.5 text-sm text-red-600 hover:bg-red-50">Удалить</button>
                </div>
            </div>
        @empty
            <p class="p-6 text-sm text-gray-500">Темы пока не добавлены.</p>
        @endforelse
    </div>
</div>
