<div class="
bg-gradient-to-tr from-green-100 via-cyan-300 via-40% to-orange-400
">
    <div class="w-full lg:w-8/12 mx-auto py-10">
        <h2 class="text-2xl bold">
            Создание QR кода
        </h2>
    </div>

    <div class="flex flex-col  sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 pb-[5vh]">
        {{--        <div class="flex-1">--}}
        {{--            1--}}
        {{--        </div>--}}
        <div class="flex-1 text-center">
            <input type="text" wire:model="text"
                   class="border border-[#3b71ca] w-[350px]"
                   placeholder="Ссылка для кодирования (с https://)"
            /><br/>
            <button
                    class="bg-success px-2 py-1 rounded text-white"
                    wire:click="generate"
            >Создать
            </button>
        </div>

        <div class="flex-1 text-center">

            {{--            qr код--}}
            @if( !empty($img) )
                <img src="{{ $img }}" class="inline"/><br/>
                {{ $img_url }}
            @endif

        </div>

    </div>
</div>
