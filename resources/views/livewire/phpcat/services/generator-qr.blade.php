<div class="bg-gradient-to-tr from-green-100 via-cyan-300 via-40% to-orange-400">
    <div class="w-full lg:w-8/12 mx-auto py-10">
        <h2 class="text-2xl bold">Создание QR кода</h2>
    </div>

    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 pb-[5vh]">
        <div class="flex-1 text-center">
            <select wire:model.live="type" class="border border-[#3b71ca] w-[350px] px-2 py-1 mb-4">
                <option value="url">Ссылка на сайт</option>
                <option value="email">Отправить email</option>
                <option value="sms">Отправить SMS</option>
{{--                <option value="vcard">Визитка (vCard)</option>--}}
            </select><br/>

            <!-- Поля для URL -->
            @if ($type === 'url')
                <input type="text" wire:model="text" class="border border-[#3b71ca] w-[350px] px-2 py-1" placeholder="Ссылка на сайт (с https://)"/><br/>

                <!-- Поля для Email -->
            @elseif ($type === 'email')
                <input type="text" wire:model="email" class="border border-[#3b71ca] w-[350px] px-2 py-1" placeholder="E-mail"/><br/>
                <input type="text" wire:model="emailSubject" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Тема сообщения"/><br/>
                <textarea wire:model="emailMessage" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Текст сообщения"></textarea><br/>

                <!-- Поля для SMS -->
            @elseif ($type === 'sms')
                <input type="text" wire:model="phone" class="border border-[#3b71ca] w-[350px] px-2 py-1" placeholder="Номер телефона"/><br/>
                <textarea wire:model="smsMessage" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Текст SMS"></textarea><br/>

                <!-- Поля для vCard -->
            @elseif ($type === 'vcard')
                <input type="text" wire:model="firstName" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Имя"/><br/>
                <input type="text" wire:model="lastName" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Фамилия"/><br/>
                <input type="text" wire:model="phone" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Номер телефона"/><br/>
                <input type="email" wire:model="email" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Электронная почта"/><br/>
                <input type="text" wire:model="company" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Компания"/><br/>
                <input type="text" wire:model="jobTitle" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Должность"/><br/>
                <input type="text" wire:model="address" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Адрес"/><br/>
                <input type="text" wire:model="website" class="border border-[#3b71ca] w-[350px] px-2 py-1 mt-2" placeholder="Веб-сайт"/><br/>
            @endif

            <button class="bg-success px-2 py-1 rounded text-white mt-2" wire:click="generate">Создать</button>
        </div>

        <div class="flex-1 text-center">
            <div wire:loading wire:target="generate" class="p-2 bg-yellow-300">Готовлю QR код...</div>
            <br/>
            @if(!empty($img))
                <img src="{{ $img }}" class="inline"/><br/>
                {{ $img_url }}
            @endif
        </div>
    </div>
</div>
