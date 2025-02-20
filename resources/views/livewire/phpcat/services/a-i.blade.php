<div class="
bg-gradient-to-r from-white
{{--via-red-100 via-40% --}}
to-orange-100
">

    <div class="w-full lg:w-8/12 mx-auto py-10">
        <h2 class="text-2xl bold">AI ML Искусственный Интелект Роботы Будущее уже тут</h2>
    </div>

    <div class="w-full lg:w-8/12 mx-auto pb-10">
<div class="mx-auto">
    <div class="py-3">
    Отправте сообщение в искуственный Интелект!! и посмотрите что напишет<br/>
    можно использовать в своих сайтах, чат ботах, сервисах и всяких штуках! Делайте заказ!
    </div>
    <div class="flex flex-row space-x-3">
        <div class="w-1/2 text-center">
    <form wire:submit.prevent="send" >
        Отправте сообщение
        <input type="text" wire:model="msg"
        class="w-full border border-1 border-blue-400 px-2 py-1"
        />
        <button type="submit" class="bg-blue-400 rounded px-3 py-1 mt-1">Отправить</button>
    </form>
        </div>
        <div class="w-1/2">
            <b>Смотрим что напишет</b>
            <div wire:loading class="bg-yellow-400 p-2">
                Обрабатываю, шестерёнки на максимум...
            </div>
            <div class="border p-3 rounded bg-white">
                {{ $answer['result']['alternatives'][0]['message']['text'] ?? '-' }}
{{--                <br/>--}}
{{--                <pre class="text-sm">{{ print_r($answer ?? '[]') }}</pre>--}}
            </div>
    </div>
    </div>
</div>
</div>
</div>
