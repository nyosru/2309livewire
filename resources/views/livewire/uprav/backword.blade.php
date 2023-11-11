<div>
    <h2 class="text-[2rem] font-mono font-bold pb-3 mb-3">
        Отправить Сообщение
    </h2>

    @if( !empty($warning) )
        <div wire:transition class="alert bg-yellow-300 px-5 py-2 rounded">  {{ $warning }}  </div>
    @else
        {{--    backword--}}
        <form wire:submit="save">
            <label class="block mb-3">
                <b>Как Вас зовут</b>
                <input type="text" wire:model="names" class="w-full border border-b-4 mt-2" required/>
                @error('names')
                <div wire:transition class="alert bg-yellow-300 px-5 py-2 rounded">
                    {{ $message }}
                </div>
                @enderror
            </label>
            <label class="block mb-3">
                <b>Контактный телеграм или телефон</b>
                <input type="text" name="contact" wire:model="contact" class="w-full border border-b-4 mt-2" required/>
                @error('contact')
                <div wire:transition class="alert bg-yellow-300 px-5 py-2 rounded">
                    {{ $message }}
                </div>
                @enderror
            </label>
            <label class="block mb-3">
                <b>Сообщение</b>
                <textarea name="message" wire:model="message" rows=6 class="w-full rounded border border-b-4 mt-2"
                          required></textarea>
                @error('message')
                <div wire:transition class="alert bg-yellow-300 px-5 py-2 rounded">
                    {{ $message }}
                </div>
                @enderror
            </label>

            <div wire:loading class="bg-yellow-300 px-6 py-3">
                {{--                <span wire:transition>--}}
                Отправляю данные ...
                {{--                    </span>--}}
            </div>
            {{--            @if( $loading == true)--}}
            {{--                <div wire:transition>--}}
            {{--                    ... загружаю ...--}}
            {{--                </div>--}}
            {{--            @else--}}
            <button type="submit" class="button bg-blue-600 hover:bg-blue-800 rounded-lg px-4 py-2 text-white">
                Отправить
            </button>
            {{--            @endif--}}


        </form>
    @endif

</div>
