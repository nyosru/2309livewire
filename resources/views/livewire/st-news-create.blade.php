<div class="max-w-2xl mx-auto py-6">
    <h2 class="text-2xl font-semibold mb-4">Добавить новость</h2>

    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Заголовок</label>
            <input type="text" id="title" wire:model="title" class="w-full p-2 border rounded" />
            @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700">Контент</label>
            <textarea id="content" wire:model="content" class="w-full p-2 border rounded"></textarea>
            @error('content') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="published_at" class="block text-gray-700">Дата публикации</label>
            <input type="date" id="published_at" wire:model="published_at" class="w-full p-2 border rounded" />
            @error('published_at') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="photos" class="block text-gray-700">Фотографии</label>
            <input type="file" id="photos" wire:model="photos" multiple class="w-full p-2 border rounded" />
            @error('photos.*') <span class="text-red-500">{{ $message }}</span> @enderror

            @if ($photos)
                <div class="mt-4">
                    <p>Предварительный просмотр:</p>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($photos as $photo)
                            <img src="{{ $photo->temporaryUrl() }}" class="rounded">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
    </form>
</div>
