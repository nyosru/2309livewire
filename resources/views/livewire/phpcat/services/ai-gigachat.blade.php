<div class="ai-gigachat-container max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">PHP Cat - AI Assistant</h1>

    <!-- Форма вопроса -->
    <div class="mb-6">
        <form wire:submit.prevent="askQuestion">
            <div class="mb-4">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                    Задайте вопрос о PHP, Laravel или разработке:
                </label>
                <textarea
                    wire:model="question"
                    id="question"
                    rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Например: Как создать компонент в Laravel Livewire?"
                    required
                    {{ $isLoading ? 'disabled' : '' }}
                ></textarea>
                @error('question')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                    wire:loading.attr="disabled"
                    {{ $isLoading ? 'disabled' : '' }}
                >
                    <span wire:loading.remove>Отправить вопрос</span>
                    <span wire:loading>Обработка...</span>
                </button>

                <button
                    type="button"
                    wire:click="clearForm"
                    class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    {{ $isLoading ? 'disabled' : '' }}
                >
                    Очистить
                </button>
            </div>
        </form>
    </div>

    <!-- Индикатор загрузки -->
    @if($isLoading)
        <div class="mb-6 text-center">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-2 text-gray-600">ИИ обрабатывает ваш запрос...</p>
        </div>
    @endif

    <!-- Сообщение об ошибке -->
    @if($error)
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
            <strong>Ошибка:</strong> {{ $error }}

            @if(str_contains($error, '400'))
                <div class="mt-2 text-sm">
                    <p>Возможные причины:</p>
                    <ul class="list-disc list-inside ml-4">
                        <li>Неверные учетные данные GigaChat</li>
                        <li>Истек срок действия client_id или client_secret</li>
                        <li>Проблемы с доступом к API GigaChat</li>
                    </ul>
                    <p class="mt-2">Проверьте правильность GIGACHAT_CLIENT_ID и GIGACHAT_CLIENT_SECRET в .env файле.</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Ответ -->
    @if($answer)
        <div class="answer-section bg-gray-50 p-6 rounded-md border border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Ответ:</h2>
            <div class="prose max-w-none">
                {!! nl2br(e($answer)) !!}
            </div>
        </div>
    @endif
</div>
