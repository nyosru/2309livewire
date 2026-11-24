<div>
{{--    <div class="block bg-blue-200">--}}
        <div class="container mx-auto py-5">
            <h1 class="text-[2rem] font-bold">Проверка контрагентов по ИНН и ОГРН</h1>
        </div>
{{--    </div>--}}

    <div class="container mx-auto py-5">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <p class="mb-5 text-gray-600">
                Данные ЕГРЮЛ и ЕГРИП
{{--                из сервиса--}}
{{--                <a href="https://checko.ru" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Чекко</a>--}}
                .
                Выберите, что ищем, введите номер и нажмите «Найти».
            </p>

            <form wire:submit.prevent="search" class="flex flex-col gap-4 md:flex-row md:items-end">
                <div class="md:w-1/3">
                    <label for="checko-target" class="mb-2 block text-sm font-medium text-gray-700">Что ищем</label>
                    <select
                        id="checko-target"
                        wire:model="target"
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                        @foreach ($targets as $key => $definition)
                            <option value="{{ $key }}">{{ $definition['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-1">
                    <label for="checko-number" class="mb-2 block text-sm font-medium text-gray-700">Номер</label>
                    <input
                        id="checko-number"
                        type="text"
                        inputmode="numeric"
                        autocomplete="off"
                        wire:model="number"
                        placeholder="{{ $targets[$target]['placeholder'] ?? '' }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                    @error('number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-blue-600 px-6 py-2.5 font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 md:w-auto"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Найти</span>
                        <span wire:loading>Ищем...</span>
                    </button>
                </div>
            </form>

            @if ($error)
                <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ $error }}
                </div>
            @endif

            @if ($result)
                <div class="mt-6 border-t border-gray-200 pt-5">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900">Результат: {{ $queryLabel }}</h2>

                    <dl class="grid grid-cols-1 gap-x-8 gap-y-3 md:grid-cols-2">
                        @foreach ($this->summary() as $label => $value)
                            <div class="flex flex-col border-b border-gray-100 pb-2">
                                <dt class="text-sm text-gray-500">{{ $label }}</dt>
                                <dd class="text-gray-900">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <details class="mt-5 text-sm text-gray-600">
                        <summary class="cursor-pointer text-blue-600 hover:underline">Показать полный ответ (все данные)</summary>
                        <pre class="mt-3 max-h-96 overflow-auto rounded-lg bg-gray-900 p-4 text-xs leading-relaxed text-gray-100">{{ json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                    </details>
                </div>
            @endif
        </div>
    </div>
</div>
