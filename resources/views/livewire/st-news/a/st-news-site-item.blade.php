<li class="py-2 border-b border-gray-300">
    <strong>Название:</strong> {{ $site->site_name }}<br>
    <strong>URL:</strong>
    <a href="{{ $site->site_url }}" class="text-blue-500" target="_blank">{{ $site->site_url }}</a><br>
    <strong>Статус сканирования:</strong>
    {{ $site->scan_status ? 'Включен' : 'Выключен' }}<br>

    <strong>URL парсинга категории:</strong>
    @if($site->category_parsing_url)
        <a href="{{ $site->category_parsing_url }}" class="text-blue-500" target="_blank">{{ $site->category_parsing_url }}</a><br>
    @else
        Не указан<br>
    @endif

    <strong>Время до автопубликации:</strong>
    @if($site->time_to_auto_publish !== null)
        {{ $site->time_to_auto_publish }} минут<br>
    @else
        Не установлено<br>
    @endif

    <strong>Модерация при загрузке:</strong>
    {{ $site->moderation_on_upload ? 'Включена' : 'Выключена' }}<br>

    {{-- Кнопка для включения/выключения статуса сканирования --}}
    <button
        wire:click="toggleScanStatus"
        class="mt-2 px-4 py-2 bg-{{ $site->scan_status ? 'red' : 'green' }}-500 text-white rounded">
        {{ $site->scan_status ? 'Выключить' : 'Включить' }} сканирование
    </button>

    {{-- Кнопка для включения/выключения модерации при загрузке --}}
    <button
        wire:click="toggleModerationOnUpload"
        class="mt-2 ml-4 px-4 py-2 bg-{{ $site->moderation_on_upload ? 'red' : 'green' }}-500 text-white rounded">
        {{ $site->moderation_on_upload ? 'Выключить' : 'Включить' }} АвтоМодерацию
    </button>
</li>
