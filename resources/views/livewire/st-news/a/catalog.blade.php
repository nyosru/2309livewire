<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Список каталогов</h2>

    @if($categories->isEmpty())
        <p class="text-gray-500">Нет каталогов для отображения</p>
    @else
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border border-gray-300">Название категории</th>
                <th class="px-4 py-2 border border-gray-300">URL категории</th>
                <th class="px-4 py-2 border border-gray-300">Последнее сканирование</th>
                <th class="px-4 py-2 border border-gray-300">Статус сканирования</th>
                <th class="px-4 py-2 border border-gray-300">Действие</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr class="{{ $category->scan_status ? 'bg-green-100' : '' }} text-center">
                    <td class="px-4 py-2 border border-gray-300">{{ $category->category_name }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        <a href="{{ $category->category_url }}" class="text-blue-500" target="_blank">
                            {{ $category->category_url }}
                        </a>
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        {{ $category->last_scan ? $category->last_scan : 'Не сканировалось' }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        {{ $category->scan_status ? 'Включен' : 'Выключен' }}
                    </td>
                    <td class="px-4 py-2 border border-gray-300">
                        {{-- Кнопка вкл/выкл статуса сканирования --}}
                        <button
                            wire:click="toggleScanStatus({{ $category->id }})"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            {{ $category->scan_status ? 'Выключить' : 'Включить' }} сканирование
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
