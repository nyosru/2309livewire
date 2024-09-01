<div class="text-[1rem]">
    <!-- Toggle Button -->
    <button wire:click="toggleForm"
            style="line-height: 25px;"
            class="float-right
            m-0 px-2 py-0
            bg-indigo-200 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
        @if ($isFormVisible)
            Скрыть форму
        @else
            + арендатор
        @endif
    </button>

    @if ($isFormVisible)
        <div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-md"
             style="z-index: 50; position: absolute; xtop: 5px; left: 5px; right: 5px;">

            <abbr  title="скрыть форму" class="float-right mx-2"
                   style="cursor:pointer;"
                   wire:click="toggleForm">X</abbr>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Form -->
            <form wire:submit.prevent="submit" class="space-y-4">

                <!-- Имя -->
                {{--                <div>--}}
                {{--                    <label for="name" class="block text-gray-700 font-medium">Имя</label>--}}
                {{--                    <input type="text" id="name" wire:model="name"--}}
                {{--                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>--}}
                {{--                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror--}}
                {{--                </div>--}}
                <!-- Имя -->
                <div class="flex items-center space-x-4">
                    <label for="name" class="text-gray-700 font-medium w-1/4">Имя</label>
                    <input type="text" id="name" wire:model="name"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Телефон -->
                <div class="flex items-center space-x-4">
                    <label for="phone"
                           class="text-gray-700 font-medium w-1/4"
                    >Телефон</label>
                    <input type="text" id="phone" wire:model="phone"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Дополнительный телефон -->
                <div class="flex items-center space-x-4">
                    <label for="phone2"
                           class="text-gray-700 font-medium w-1/4"
                    >Доп. телефон</label>
                    <input type="text" id="phone2" wire:model="phone2"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                @error('phone2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <!-- Описание -->
                <div>
                    <label for="opis" class="block text-gray-700 font-medium">Описание</label>
                    <textarea id="opis" wire:model="opis"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    @error('opis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                @if (!$now_object)
                    <!-- Объект -->
                    <div>
                        <label for="ar_object_id" class="block text-gray-700 font-medium">Объект</label>
                        <select id="ar_object_id" wire:model="ar_object_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Выберите объект</option>
                            @foreach ($arObjects as $object)
                                <option value="{{ $object->id }}">{{ $object->nomer }} - {{ $object->adres }}</option>
                            @endforeach
                        </select>
                        @error('ar_object_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                @endif

                <!-- Цена -->
                <div class="flex items-center space-x-4">
                    <label for="price" class="text-gray-700 font-medium w-1/4">Цена</label>
                    <input type="text" id="price" wire:model="price"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Дата начала -->
                <div class="flex items-center space-x-4">
                    <label for="date_start" class="text-gray-700 font-medium w-1/4">Дата начала</label>
                    <input type="date" id="date_start" wire:model="date_start"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                    @error('date_start') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Описание цены -->
                <div>
                    <label for="price_opis" class="block text-gray-700 font-medium">Описание цены</label>
                    <textarea id="price_opis" wire:model="price_opis"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                    @error('price_opis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Кнопка отправки -->
                <div>
                    <button type="submit"
                            class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Добавить
                    </button>
                </div>
            </form>
        </div>
    @endif

</div>
