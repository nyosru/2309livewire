<div class="w-full lg:w-8/12 mx-auto py-10">
    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 pb-2">
        <h2 class="text-2xl bold">Пуни&nbsp;конвертер (доменов написанных по&nbsp;русски)</h2>
    </div>

    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
        <!-- Поле ввода домена -->
        <div class="flex-1 hidden md:!flex">
            <img src="/icon/converter.png" class="max-h-[100px] mx-auto" />
        </div>
        <div class="flex-1 relative">
            <label for="domain" class="block text-gray-700">Домен</label>
            <input type="text" id="domain" wire:model.live="domain" class="w-full p-2 border rounded"
                   placeholder="Введите домен">
            <button
                title="копировать в буфер обмена"
                onclick="copyToClipboard('domain')" class="absolute right-2 top-9 p-1 bg-gray-200 border rounded">
                Коп
            </button>
        </div>

        <!-- Поле ввода закодированного домена -->
        <div class="flex-1 relative">
            <label for="encodedDomain" class="block text-gray-700">Закодированный домен (Punycode)</label>
            <input type="text" id="encodedDomain" wire:model.live="encodedDomain" class="w-full p-2 border rounded"
                   placeholder="Введите закодированный домен">
            <button
                title="копировать в буфер обмена"
                onclick="copyToClipboard('encodedDomain')" class="absolute right-2 top-9 p-1 bg-gray-200 border rounded">
                Коп
            </button>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Для мобильных устройств

        document.execCommand("copy");
        alert("Скопировано: " + copyText.value);
    }
</script>
