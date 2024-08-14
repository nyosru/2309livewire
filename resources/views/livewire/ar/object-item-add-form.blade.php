<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-md">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-200 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4">
        <button wire:click="toggleForm"
                class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ $showForm ? 'Скрыть форму' : 'Показать форму' }}
        </button>
    </div>

    @if ($showForm)
        <form wire:submit.prevent="submit" class="space-y-4">
            <div>
                <label for="nomer" class="block text-gray-700 font-medium">Номер</label>
                <input type="text" id="nomer" wire:model="nomer"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                @error('nomer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="adres" class="block text-gray-700 font-medium">Адрес</label>

                <label>
                    <input type="radio" name="adres_list" wire:model.live="adres_list" value="new">
                    новый
                </label><br/>

                @if($adres_list == 'new')
                    <input type="text" id="adres" wire:model="adres"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"/>
                    <br/>
                @endif

                @foreach($uniqueAddresses as $address)
                    <label>
                        <input type="radio" name="adres_list" wire:model.live="adres_list"
                               value="{{ $address->adres }}">
                        {{ $address->adres }}
                    </label><br/>
                @endforeach

                @error('adres') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="opis" class="block text-gray-700 font-medium">Описание</label>
                <textarea id="opis" wire:model="opis"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                @error('opis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Добавить
                </button>
            </div>

        </form>
    @endif
</div>
