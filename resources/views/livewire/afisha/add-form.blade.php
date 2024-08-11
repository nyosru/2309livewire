<div class="p-6 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Добавить Афишу</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-2 bg-green-500 text-white rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="addPoster" class="space-y-4" enctype="multipart/form-data">

        <div class="flex items-center space-x-4">
            <label for="title" class="w-40 text-right font-medium">Название:</label>
            <input type="text" id="title" wire:model="title"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="description" class="w-40 text-right font-medium">Краткое описание:</label>
            <textarea id="description" wire:model="description"
                      class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="link" class="w-40 text-right font-medium">Ссылка:</label>
            <input type="text" id="link" wire:model="link"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="event_date" class="w-40 text-right font-medium">Дата проведения:</label>
            <input type="date" id="event_date" wire:model="event_date"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('event_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="event_time" class="w-40 text-right font-medium">Время проведения (необязательно):</label>
            <input type="time" id="event_time" wire:model="event_time"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('event_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="end_date" class="w-40 text-right font-medium">Дата окончания:</label>
            <input type="date" id="end_date" wire:model="end_date"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="source_link" class="w-40 text-right font-medium">Ссылка на источник:</label>
            <input type="text" id="source_link" wire:model="source_link"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('source_link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center space-x-4">
            <label for="buy_tickets_link" class="w-40 text-right font-medium">Купить билеты:</label>
            <input type="text" id="buy_tickets_link" wire:model="buy_tickets_link"
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500">
            @error('buy_tickets_link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-wrap space-x-4">
            @for ($i = 1; $i <= 5; $i++)
                <div class="flex-1 mb-4">
                    <label for="link_{{ $i }}" class="block font-medium">Доп. ссылка {{ $i }}:</label>
                    <input type="text" id="link_{{ $i }}" wire:model="extra_links.{{ $i }}.link"
                           class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500"
                           placeholder="Введите ссылку">
                    <label for="text_{{ $i }}" class="block font-medium mt-2">Подпись {{ $i }}:</label>
                    <input type="text" id="text_{{ $i }}" wire:model="extra_links.{{ $i }}.text"
                           class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:border-gray-500"
                           placeholder="Введите подпись">
                </div>
            @endfor
        </div>

        <div class="flex items-center space-x-4">
            <label for="images" class="w-40 text-right font-medium">Изображения:</label>
            <input type="file" id="images" wire:model="images" multiple
                   class="flex-1 p-2 border border-gray-300 rounded focus:outline-none">
            @error('images.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none">
            Добавить Афишу
        </button>
    </form>
</div>
