<div>
    <h2 class="text-xl font-bold mb-4">Получение доменов из Caddy</h2>

    {{-- Кнопка для получения доменов --}}
    <button wire:click="fetchCaddyDomains" class="bg-blue-500 text-white px-4 py-2 rounded">
        Загрузить домены из Caddy
    </button>

    {{-- Список доменов --}}
    @if(!empty($domains))
        <h3 class="mt-4 text-lg font-semibold">Найденные домены</h3>
        <table class="table-auto w-full mt-4">
            <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Домен</th>
                <th class="px-4 py-2">IP адрес</th>
                <th class="px-4 py-2">Доступность</th>
                <th class="px-4 py-2">SSL валиден</th>
                <th class="px-4 py-2">SSL истекает</th>
                <th class="px-4 py-2">Логи</th>
            </tr>
            </thead>
            <tbody>
            @foreach($results as $domain => $info)
                <tr class="@if($info['reachable']) bg-green-100 @else bg-red-100 @endif">
                    <td class="border px-4 py-2">{{ $domain }}</td>
                    <td class="border px-4 py-2">{{ $info['ip_address'] ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">
                        @if($info['reachable'])
                            <span class="text-green-600">Доступен</span>
                        @else
                            <span class="text-red-600">Не доступен</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        @if($info['ssl_valid'])
                            <span class="text-green-600">Да</span>
                        @else
                            <span class="text-red-600">Нет</span>
                        @endif
                    </td>
                    <td class="border px-4 py-2">{{ $info['ssl_expiry'] ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">
                        <ul>
                            @foreach($info['log_entries'] as $log)
                                <li>{{ $log }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{-- Кнопка для проверки доменов --}}
        <button wire:click="checkDomains" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">
            Проверить домены
        </button>
    @endif
</div>
