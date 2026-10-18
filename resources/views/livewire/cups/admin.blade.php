<div class="container-fluid mx-auto max-w-7xl px-5 py-10">

    <h1 class="text-xl mb-5"><b>Управление кружками</b></h1>

    @if( session()->has('success') )
        <div class="bg-green-100 border border-green-400 text-green-800 p-3 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-6 mb-10">
        <h2 class="font-bold text-lg mb-4">
            {{ $editId ? 'Редактировать кружку #' . $editId : 'Добавить кружку' }}
        </h2>

        <form wire:submit.prevent="save" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block mb-1">Название</label>
                <input type="text" wire:model="name"
                       class="border border-2 w-full max-w-[400px] px-2 py-1">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-1">Адрес места</label>
                <div class="flex max-w-[820px] flex-col gap-2 sm:flex-row">
                    <input type="text" wire:model="address"
                           placeholder="Например: Россия, Тюменская область, пгт Боровский"
                           class="min-w-0 flex-1 border-2 border-gray-300 px-2 py-1">
                    <button type="button"
                            wire:click="findCoordinates"
                            wire:loading.attr="disabled"
                            wire:target="findCoordinates"
                            class="whitespace-nowrap rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700 disabled:cursor-wait disabled:opacity-60">
                        <span wire:loading.remove wire:target="findCoordinates">Найти координаты</span>
                        <span wire:loading wire:target="findCoordinates">Ищу…</span>
                    </button>
                </div>
                @error('address') <span class="mt-1 block text-sm text-red-500">{{ $message }}</span> @enderror
                @if( $geocodeResult )
                    <div class="mt-2 max-w-[820px] rounded bg-green-100 px-3 py-2 text-sm text-green-800">
                        Найдено: {{ $geocodeResult }}
                    </div>
                @endif
            </div>

            <div class="grid max-w-[400px] grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block mb-1">Широта (lat)</label>
                    <input type="text" wire:model="lat" class="border border-2 w-full px-2 py-1">
                    @error('lat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1">Долгота (lon)</label>
                    <input type="text" wire:model="lon" class="border border-2 w-full px-2 py-1">
                    @error('lon') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Описание</label>
                <textarea wire:model="opis" rows="3"
                          class="border border-2 w-full max-w-[400px] px-2 py-1"></textarea>
                @error('opis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6 max-w-[820px] rounded-lg border border-orange-200 bg-orange-50 p-4">
                <div class="mb-4 flex items-center gap-2">
                    <input id="show-advertisement" type="checkbox" wire:model="showAdvertisement"
                           class="h-4 w-4 rounded border-gray-300 text-orange-600">
                    <label for="show-advertisement" class="font-semibold">Показывать рекламный блок у последней кружки</label>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Рекламный текст</label>
                    <textarea wire:model="advertisingText" rows="3"
                              class="w-full border-2 border-gray-300 px-2 py-1"></textarea>
                    @error('advertisingText') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Рекламный адрес</label>
                    <input type="text" wire:model="advertisingAddress"
                           placeholder="Адрес для ссылки на Яндекс.Карты"
                           class="w-full border-2 border-gray-300 px-2 py-1">
                    @error('advertisingAddress') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1">Рекламный телефон</label>
                    <input type="tel" wire:model="advertisingPhone"
                           placeholder="+7 999 123-45-67"
                           class="w-full max-w-[400px] border-2 border-gray-300 px-2 py-1">
                    @error('advertisingPhone') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Фото (перетащите или выберите, до 10 штук, каждое до 12 МБ)</label>

                <div id="cup-dropzone"
                     class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 transition">
                    <input id="cup-images" type="file" wire:model="img" multiple accept="image/*" class="hidden">

                    @if( count($img) )
                        <div class="flex flex-wrap gap-2 mb-3" wire:loading.class="opacity-50" wire:target="img">
                            @foreach( $img as $f )
                                <img src="{{ $f->temporaryUrl() }}" class="w-20 h-20 object-cover rounded" loading="lazy"/>
                            @endforeach
                        </div>
                    @endif

                    <div wire:loading wire:target="img" class="text-blue-600 text-sm mb-2 flex items-center justify-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Загрузка фото...
                    </div>

                    <span class="text-gray-500">Перетащите фото сюда или кликните для выбора</span>
                    @error('img') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                    @error('img.*') <span class="text-red-500 text-sm block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="mt-3">
                    <label class="block mb-1">... или ссылка на картинку</label>
                    <input type="text" wire:model="photoLink" placeholder="https://..."
                           class="border border-2 w-full max-w-[400px] px-2 py-1">
                    @error('photoLink') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <script>
                    (function () {
                        var dz = document.getElementById('cup-dropzone');
                        var input = document.getElementById('cup-images');
                        if (!dz || !input) {
                            return;
                        }

                        dz.addEventListener('click', function () {
                            input.click();
                        });

                        ['dragenter', 'dragover'].forEach(function (ev) {
                            dz.addEventListener(ev, function (e) {
                                e.preventDefault();
                                dz.classList.add('bg-blue-50', 'border-blue-500');
                            });
                        });

                        ['dragleave', 'drop'].forEach(function (ev) {
                            dz.addEventListener(ev, function (e) {
                                e.preventDefault();
                                dz.classList.remove('bg-blue-50', 'border-blue-500');
                            });
                        });

                        dz.addEventListener('drop', function (e) {
                            if (!e.dataTransfer || !e.dataTransfer.files.length) {
                                return;
                            }
                            var dt = new DataTransfer();
                            Array.from(e.dataTransfer.files).forEach(function (f) {
                                dt.items.add(f);
                            });
                            input.files = dt.files;
                            input.dispatchEvent(new Event('change', { bubbles: true }));
                        });
                    })();
                </script>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        wire:loading.attr="disabled" wire:target="save, img"
                        class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <span wire:loading.remove wire:target="save">
                        {{ $editId ? 'Сохранить' : 'Добавить' }}
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        Сохранение...
                    </span>
                </button>
                @if( $editId )
                    <button type="button" wire:click="cancelEdit"
                            class="bg-gray-400 text-white px-4 py-2 rounded">
                        Отмена
                    </button>
                @endif
            </div>
        </form>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
        <h2 class="font-bold text-lg">Текущие записи ({{ $cups->count() }})</h2>
        <span class="text-sm text-gray-500">Скрыто: {{ $cups->where('is_hidden', true)->count() }}</span>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow">
        <table class="w-full min-w-[1250px] border-collapse text-left text-sm">
            <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-3 font-semibold">ID</th>
                <th class="px-4 py-3 font-semibold">Запись</th>
                <th class="px-4 py-3 font-semibold">Адрес и координаты</th>
                <th class="px-4 py-3 font-semibold">Реклама</th>
                <th class="px-4 py-3 font-semibold">Фотографии</th>
                <th class="px-4 py-3 font-semibold">Действия</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse( $cups as $cup )
                <tr wire:key="cup-row-{{ $cup->id }}"
                    @class(['align-top', 'bg-gray-50 opacity-60' => $cup->is_hidden])>
                    <td class="px-4 py-4 text-gray-500">{{ $cup->id }}</td>
                    <td class="px-4 py-4 min-w-64">
                        <div class="font-bold text-base">{{ $cup->name }}</div>
                        @if( $cup->is_hidden )
                            <span class="mt-1 inline-block rounded bg-gray-600 px-2 py-0.5 text-xs text-white">Скрыта</span>
                        @endif
                        @if( $cup->opis )
                            <div class="mt-2 whitespace-pre-line text-gray-600">{{ $cup->opis }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-4 min-w-64">
                        @if( $cup->address )
                            <div class="mb-2">{{ $cup->address }}</div>
                        @else
                            <div class="mb-2 text-gray-400">Адрес не указан</div>
                        @endif

                        @if( $cup->lat && $cup->lon )
                            <div class="font-mono text-xs text-gray-500">
                                {{ $cup->lat }}, {{ $cup->lon }}
                            </div>
                        @else
                            <div class="text-xs text-red-500">Координаты не указаны</div>
                        @endif
                    </td>
                    <td class="px-4 py-4 min-w-72">
                        <label class="flex cursor-pointer items-start gap-2 font-medium text-gray-800">
                            <input type="checkbox"
                                   wire:click="toggleAdvertisement({{ $cup->id }})"
                                   wire:loading.attr="disabled"
                                   wire:target="toggleAdvertisement({{ $cup->id }})"
                                   @checked($cup->show_advertisement)
                                   class="mt-0.5 h-4 w-4 rounded border-gray-300 text-orange-600 disabled:cursor-wait disabled:opacity-60">
                            <span>Показывать рекламный блок у&nbsp;последней кружки</span>
                        </label>

                        <div class="mt-3 space-y-2 text-gray-600">
                            @if( $cup->advertising_text )
                                <div title="{{ $cup->advertising_text }}">
                                    <span class="font-semibold text-gray-700">Текст:</span>
                                    {{ mb_substr($cup->advertising_text, 0, 100) }}@if( mb_strlen($cup->advertising_text) > 100 )…@endif
                                </div>
                            @else
                                <div class="text-gray-400">Рекламный текст не&nbsp;указан</div>
                            @endif

                            @if( $cup->advertising_address )
                                <div>
                                    <span class="font-semibold text-gray-700">Адрес:</span>
                                    {{ $cup->advertising_address }}
                                </div>
                            @else
                                <div class="text-gray-400">Рекламный адрес не&nbsp;указан</div>
                            @endif

                            @if( $cup->advertising_phone )
                                <div>
                                    <span class="font-semibold text-gray-700">Телефон:</span>
                                    {{ $cup->advertising_phone }}
                                </div>
                            @else
                                <div class="text-gray-400">Рекламный телефон не&nbsp;указан</div>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-4 min-w-[320px]">
                        @if( $cup->photos->isNotEmpty() )
                            <div class="flex flex-wrap gap-3">
                                @foreach( $cup->photos as $photo )
                                    <div class="relative" wire:key="cup-photo-{{ $photo->id }}">
                                        <a href="{{ $photo->url }}" target="_blank" rel="noopener">
                                            <img src="{{ $photo->mini_url }}"
                                                 class="h-20 w-20 rounded border object-cover {{ $loop->first ? 'border-orange-500 border-2' : 'border-gray-200' }}"
                                                 loading="lazy"
                                                 alt="{{ $cup->name }}"
                                                 title="{{ $photo->link ? 'Фото по ссылке' : $photo->image }}"/>
                                        </a>
                                        @if( $loop->first )
                                            <span class="absolute bottom-0 left-0 bg-orange-500 px-1 text-xs text-white">Первая</span>
                                        @endif
                                        <button type="button"
                                                wire:click="deletePhoto({{ $photo->id }})"
                                                wire:confirm="Удалить эту фотографию?"
                                                title="Удалить фото"
                                                aria-label="Удалить фото"
                                                class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-red-600 text-base font-bold leading-none text-white shadow hover:bg-red-700">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400">Нет фотографий</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex flex-col items-start gap-2">
                            <button type="button" wire:click="edit({{ $cup->id }})"
                                    class="text-blue-700 underline hover:text-blue-900">
                                Редактировать
                            </button>
                            <button type="button" wire:click="toggleHidden({{ $cup->id }})"
                                    class="text-gray-700 underline hover:text-gray-900">
                                {{ $cup->is_hidden ? 'Показать' : 'Скрыть' }}
                            </button>
                            <button type="button" wire:click="delete({{ $cup->id }})"
                                    wire:confirm="Удалить кружку «{{ $cup->name }}» и все её фотографии?"
                                    class="text-red-700 underline hover:text-red-900">
                                Удалить
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">Записей пока нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>
