<div class="w-full lg:w-8/12 mx-auto py-10" >
    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0 pb-2">
        <h2 class="text-2xl bold">Пуни конвертер (доменов написанных по русски)</h2>
    </div>
    <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-4 sm:space-y-0">
        <!-- Поле ввода домена -->
        <div class="flex-1">
            <label for="domain" class="block text-gray-700">Домен</label>
            <input type="text" id="domain" wire:model.live="domain" class="w-full p-2 border rounded"
                   placeholder="Введите домен">
        </div>

        <!-- Поле ввода закодированного домена -->
        <div class="flex-1">
            <label for="encodedDomain" class="block text-gray-700">Закодированный домен (Punycode)</label>
            <input type="text" id="encodedDomain" wire:model.live="encodedDomain" class="w-full p-2 border rounded"
                   placeholder="Введите закодированный домен">
        </div>
    </div>
</div>
