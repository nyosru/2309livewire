<div>
    <h2 class="text-xl font-bold mb-4">Проверка доменов из Caddyfile</h2>



    <input
        class="border-solid border border-green-200 px-2 py-1"
        wire:model="domen" type="text" />
    <button
        class="bg-green-300 px-2 py-1 rounded"
        wire:click="scanDomen" type="button" >просканить домен</button>

    {{ $result_scan_domain ?? '-' }}

    {{-- Кнопки для загрузки и проверки доменов --}}
    <div class="mb-4">
        <button wire:click="parseCaddyfile" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">
            Загрузить домены
        </button>

        @if(!empty($domains))
            <button wire:click="checkDomains" class="bg-green-500 text-white px-4 py-2 rounded">
                Проверить домены
            </button>
        @endif
    </div>

    {{-- Таблица для отображения доменов и статусов --}}
    @if(!empty($domains))
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2 text-left">Домен</th>
                <th class="border px-4 py-2 text-left">Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach($domains as $domain)
                <tr class="
                        @if(isset($results[$domain]))
                            @if($results[$domain]['reachable'] && $results[$domain]['ssl_valid'])
                                bg-green-100
                            @else
                                bg-red-100
                            @endif
                        @else
                            bg-gray-100
                        @endif
                    ">
                    <td class="border px-4 py-2">
                        <a href="http://{{ $domain }}" target="_blank" >
                        {{ $domain }}
                        </a>
                    </td>
                    <td class="border px-4 py-2">
                        @if(isset($results[$domain]))
                            {{-- Статус доступности домена --}}
                            @if($results[$domain]['reachable'])
                                <span class="text-green-600">Доступен</span>
                            @else
                                <span class="text-red-600">Не доступен</span>
                            @endif
                            |
                            {{-- Статус SSL сертификата --}}
                            SSL:
                            @if($results[$domain]['ssl_valid'])
                                <span class="text-green-600">Валиден</span>
                            @else
                                <span class="text-red-600">Не валиден</span>
                            @endif
                        @else
                            <span class="text-gray-500">Не проверено</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
