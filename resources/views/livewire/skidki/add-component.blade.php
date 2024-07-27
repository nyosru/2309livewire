<div>
    <form wire:submit.prevent="addSkidka"
    >
        <div class="mt-3 mb-3">
            <label for="date">Дата</label>
            <input type="date" id="date" wire:model="dater"
                   class="border border-2"
            >
            @error('dater') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">

            <div class="flex mx-auto w-full max-w-[600px]">
                <div class="w-1/2 xbg-blue-500 p-4">


                    <label for="type">Тип (выберите из списка)</label>

                    @foreach( $list_type as $k => $l )
                        <label class="block">
                            <input type="radio" wire:model.live="type_list" value="{{ $k }}">
                            {{ $l['name'] }}
                        </label>
                    @endforeach

                    <label class="block">
                        <input type="radio" wire:model.live="type_list" value="" selected>
                        введу ниже в поле
                    </label>

                </div>
                <div class="w-1/2 xbg-green-500 p-4 text-left">

                    @if( !empty( $list_type[$type_list] ) )
                        Выбран вариант:
                        <br/>
                        <b class="bg-green-400 p-1 block">{{ $list_type[$type_list]['name'] }}</b>
                        {!! $list_type[$type_list]['opis'] !!}
                    @endif
                </div>
            </div>
            <br/>


            <label for="type">Вводите тип тут</label>
            <input type="text" id="type" wire:model="type"
                   class="border border-2"
            >
            @error('type') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="phone">Телефон</label>
            <input type="text" id="phone" wire:model="phone"
                   class="border border-2"
            >
            @error('phone') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="author">Автор</label>
            <input type="text" id="author" wire:model="author"
                   class="border border-2"
            >
            @error('author') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Добавить</button>
    </form>

</div>
