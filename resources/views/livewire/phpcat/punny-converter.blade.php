<div class="
bg-gradient-to-tr from-white via-red-100 via-40% to-orange-400
">
    <div class="w-full lg:w-8/12 mx-auto py-10">
        <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 pb-2">
            <h2 class="text-2xl bold">Пуни конвертер (доменов написанных по русски)</h2>
        </div>

        <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
            <!-- Поле ввода домена -->
            <div class="flex-1 hidden md:!flex">
                <img src="/icon/converter.png" class="max-h-[100px] mx-auto"/>
            </div>
            <div class="flex-1 relative">
                <label for="domain" class="block text-gray-700">Домен</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input type="text" id="domain" wire:model.live="domain"
                           class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                           placeholder="Домен **.рф">
                    @if(!empty($domain))
                    <img src="/icon/copy.svg"
                         title="копировать в буфер обмена"
                         onclick="copyToClipboard('domain')"
                         class="absolute inset-y-0 right-[5px] flex items-center mt-[4px] h-[25px] opacity-20 hover:opacity-50 cursor-pointer"
                    />
                    @endif
                </div>
            </div>

            <!-- Поле ввода закодированного домена -->
            <div class="flex-1 relative">
                <label for="encodedDomain" class="block text-gray-700">Закодированный домен (Punycode)</label>
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input type="text" id="encodedDomain" wire:model.live="encodedDomain"
                           class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                           placeholder="Закодированный домен">
                    @if(!empty($encodedDomain))
                        <img src="/icon/copy.svg"

                             title="копировать в буфер обмена"
                             onclick="copyToClipboard('encodedDomain')"
                             class="absolute inset-y-0 right-[5px] flex items-center mt-[4px] h-[25px] opacity-20 hover:opacity-50 cursor-pointer"
                        />
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    function copyToClipboard(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Для мобильных устройств

        document.execCommand('copy');
        alert('Скопировано: ' + copyText.value);
    }
</script>



