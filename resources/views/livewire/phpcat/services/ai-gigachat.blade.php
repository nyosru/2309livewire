<div class="bg-gradient-to-br from-blue-50 to-blue-100">
<div class="ai-gigachat-container max-w-4xl mx-auto py-[7vh] px-6
{{--bg-white rounded-lg shadow-lg--}}
">
    <div class="flex items-center justify-center
    mb-6
    ">
        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-3">
            <span class="text-white font-bold text-xl">AI</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-800">AI Assistant ( МЛ ИИ будущее уже тут, поговори с машинкой! можно интегрировать в сайты)</h1>
    </div>

    @if(!$this->hasValidCredentials())
        <div class="
{{--        mb-6 --}}
        p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-md">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <strong>Демо-режим</strong>
                    <p class="mt-1 text-sm">Для работы с GigaChat API необходимо настроить учетные данные.</p>
                    <p class="text-sm mt-1">
                        <a href="https://developers.sber.ru/docs/redirect?uniq_id=getGigaAccessToken"
                           target="_blank"
                           class="text-blue-600 hover:text-blue-800 underline">
                            Получить Client ID и Client Secret →
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Форма вопроса -->
    <div class="mb-6">
        <form wire:submit.prevent="askQuestion">
            <div class="mb-4">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                    💡 Задайте вопрос о чём угодно:
                </label>
                <textarea
                    wire:model="question"
                    id="question"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                    placeholder="Например: Как создать компонент в Laravel Livewire? Какие лучшие практики PHP? Как работает Eloquent ORM?"
                    required
                    {{ $isLoading ? 'disabled' : '' }}
                ></textarea>
                @error('question')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 flex-wrap">
                <button
                    type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 transition-all duration-200 flex items-center"
                    wire:loading.attr="disabled"
                    {{ $isLoading ? 'disabled' : '' }}
                >
                    <span wire:loading.remove>🚀 Отправить вопрос</span>
                    <span wire:loading>
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Обработка...
                    </span>
                </button>

                <button
                    type="button"
                    wire:click="clearForm"
                    class="px-6 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200"
                    {{ $isLoading ? 'disabled' : '' }}
                >
                    🗑️ Очистить
                </button>

                @if(!$this->hasValidCredentials())
                    <div class="flex gap-2 ml-auto">
                        <button type="button" wire:click="tryExample('laravel')" class="px-4 py-2.5 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm">
                            Laravel
                        </button>
                        <button type="button" wire:click="tryExample('livewire')" class="px-4 py-2.5 bg-purple-500 text-white rounded-lg hover:bg-purple-600 text-sm">
                            Livewire
                        </button>
                        <button type="button" wire:click="tryExample('php')" class="px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 text-sm">
                            PHP
                        </button>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Сообщение об ошибке -->
    @if($error)
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <strong>Ошибка</strong>
                    <p class="mt-1">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Ответ -->
    @if($answer)
        <div class="answer-section bg-gray-50 p-6 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    Ответ
                </h2>
                @if($showDemoWarning)
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    Демо-режим
                </span>
                @endif
            </div>

            <div class="prose max-w-none text-gray-700">
                @php
                    $lines = explode("\n", $answer);
                    $isBold = false;
                @endphp

                @foreach($lines as $line)
                    @if(str_starts_with(trim($line), '**') && str_ends_with(trim($line), '**'))
                        <h3 class="text-lg font-semibold mb-3 text-blue-800">
                            {{ trim($line, '**') }}
                        </h3>
                    @elseif(!empty(trim($line)))
                        <p class="mb-3 leading-relaxed">{{ $line }}</p>
                    @else
                        <div class="my-3"></div>
                    @endif
                @endforeach
            </div>

            @if($showDemoWarning)
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <strong>Это демо-ответ</strong>. Для получения реальных ответов от GigaChat
                            <a href="https://developers.sber.ru/docs/redirect?uniq_id=getGigaAccessToken"
                               target="_blank"
                               class="underline hover:text-blue-900">
                                получите учетные данные
                            </a>
                            и добавьте их в .env файл.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif


<style>
    .ai-gigachat-container {
        /*min-height: 500px;*/
    }

    .prose {
        line-height: 1.6;
    }

    .prose p {
        margin-bottom: 1em;
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
</div>
</div>
