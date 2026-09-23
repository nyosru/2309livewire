<style>[x-cloak]{display:none!important}</style>

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

            <div class="grid grid-cols-2 gap-4 max-w-[400px]">
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

            <div class="mb-4">
                <label class="block mb-1">Фото (перетащите или выберите, до 10 штук)</label>

                <div id="cup-dropzone"
                     x-data="{ progress: false, pct: 0 }"
                     @@livewire-upload-start="progress = true; pct = 0"
                     @@livewire-upload-progress="pct = $event.detail.progress"
                     @@livewire-upload-finish="pct = 100; setTimeout(() => progress = false, 800)"
                     @@livewire-upload-error="progress = false"
                     @@livewire-upload-cancel="progress = false"
                     class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 transition">
                    <input id="cup-images" type="file" wire:model="img" multiple accept="image/*" class="hidden">

                    @if( count($img) )
                        <div class="flex flex-wrap gap-2 mb-3" wire:loading.class="opacity-50" wire:target="img">
                            @foreach( $img as $f )
                                <img src="{{ $f->temporaryUrl() }}" class="w-20 h-20 object-cover rounded" loading="lazy"/>
                            @endforeach
                        </div>
                    @endif

                    <div x-show="progress" x-cloak class="mb-2 text-left max-w-[400px] mx-auto">
                        <div class="h-2 bg-gray-200 rounded overflow-hidden">
                            <div class="h-full bg-blue-600 transition-all duration-150"
                                 :style="'width:' + pct + '%'"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 text-center">
                            Загрузка фото... <b x-text="Math.round(pct)"></b>%
                        </div>
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

    <h2 class="font-bold text-lg mb-4">Все кружки ({{ $cups->count() }})</h2>

    <div class="columns-1 md:columns-2 lg:columns-3 gap-4">
        @foreach( $cups as $cup )
            <div class="border border-gray-200 rounded-lg shadow p-4 mb-4 break-inside-avoid">
                <div class="flex items-start gap-4">
                    @if( $cup->photos->isNotEmpty() )
                        <img src="{{ $cup->photos->first()->mini_url }}"
                             class="w-20 h-20 object-cover rounded" loading="lazy"/>
                    @endif
                    <div class="flex-1">
                        <div class="font-bold">{{ $cup->name }}</div>
                        @if( $cup->lat && $cup->lon )
                            <div class="text-xs text-gray-500">{{ $cup->lat }}, {{ $cup->lon }}</div>
                        @endif
                        @if( $cup->opis )
                            <div class="text-sm text-gray-600">{{ $cup->opis }}</div>
                        @endif
                    </div>
                </div>

                @if( $cup->photos->isNotEmpty() )
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach( $cup->photos as $photo )
                            <div class="relative">
                                <a href="{{ $photo->url }}" target="_blank">
                                    <img src="{{ $photo->mini_url }}"
                                         class="w-16 h-16 object-cover rounded" loading="lazy"
                                         title="{{ $photo->link ? 'ссылка' : $photo->image }}"/>
                                </a>
                                <button wire:click="deletePhoto({{ $photo->id }})"
                                        title="Удалить фото"
                                        class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 text-xs leading-none">
                                    x
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex gap-2 mt-4">
                    <button wire:click="edit({{ $cup->id }})"
                            class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                        Редактировать
                    </button>
                    <button wire:click="delete({{ $cup->id }})"
                            wire:confirm="Удалить кружку «{{ $cup->name }}»?"
                            class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                        Удалить
                    </button>
                </div>
            </div>
        @endforeach
    </div>

</div>