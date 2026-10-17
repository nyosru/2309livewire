<div class="min-h-screen">
    <header class="border-b border-gray-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-4 px-4 py-4 sm:px-6">
            <a href="{{ route('phpcat.admin') }}" class="text-xl font-bold text-blue-700">
                Админка
            </a>

            @if ($authorized)
                <nav class="flex flex-1 items-center gap-2" aria-label="Разделы админки">
                    <a href="#services"
                       class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
                        Управление сервисами
                    </a>
                </nav>

                <div class="ml-auto flex items-center gap-3">
                    <span class="text-sm text-green-700">Доступ открыт</span>
                    <button type="button" wire:click="logout"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50">
                        Выйти
                    </button>
                </div>
            @else
                <form wire:submit="login" class="ml-auto flex w-full flex-wrap items-start gap-2 sm:w-auto">
                    <div>
                        <label for="admin-password" class="sr-only">Пароль</label>
                        <input id="admin-password" type="password" wire:model="password"
                               autocomplete="current-password" placeholder="Пароль"
                               class="w-full rounded-lg border border-gray-300 px-4 py-2 sm:w-64">
                        @error('password')
                            <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit"
                            class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700">
                        Войти
                    </button>
                </form>
            @endif
        </div>
    </header>

    @if ($authorized)
        <main id="services" class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Управление сервисами</h1>
                    <p class="mt-1 text-sm text-gray-600">Записи блока «Удобные сервисы» на главной странице.</p>
                </div>
                <a href="{{ route('phpcat.index') }}" target="_blank"
                   class="rounded-lg border border-blue-300 px-4 py-2 text-blue-700 hover:bg-blue-50">
                    Открыть сайт
                </a>
            </div>

            @if (session()->has('success'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <section class="mb-8 rounded-xl bg-white p-5 shadow-sm sm:p-6">
                <h2 class="mb-5 text-lg font-bold">
                    {{ $editId ? 'Редактирование сервиса #' . $editId : 'Новый сервис' }}
                </h2>

                <form wire:submit="save" class="space-y-5">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="service-title" class="mb-1 block font-medium">Название *</label>
                            <input id="service-title" type="text" wire:model="title"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            @error('title') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label for="service-state" class="mb-1 block font-medium">Отображение</label>
                            <select id="service-state" wire:model="onoff"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2">
                                <option value="on">Показывать</option>
                                <option value="off">Скрыть</option>
                            </select>
                            @error('onoff') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label for="service-link" class="mb-1 block font-medium">Ссылка</label>
                            <input id="service-link" type="text" wire:model="link" placeholder="https://example.com или /page"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            @error('link') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label for="service-link-title" class="mb-1 block font-medium">Подпись ссылки</label>
                            <input id="service-link-title" type="text" wire:model="linkTitle"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            @error('linkTitle') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="service-image" class="mb-1 block font-medium">URL изображения</label>
                        <input id="service-image" type="text" wire:model="imgUrl" placeholder="https://example.com/image.jpg или /logo/image.svg"
                               class="w-full rounded-lg border border-gray-300 px-3 py-2">
                        @error('imgUrl') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="service-description" class="mb-1 block font-medium">Описание *</label>
                        <textarea id="service-description" wire:model="opis" rows="5"
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2"></textarea>
                        @error('opis') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                                class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50">
                            {{ $editId ? 'Сохранить изменения' : 'Добавить сервис' }}
                        </button>
                        @if ($editId)
                            <button type="button" wire:click="cancelEdit"
                                    class="rounded-lg border border-gray-300 px-5 py-2 hover:bg-gray-50">
                                Отмена
                            </button>
                        @endif
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4 sm:px-6">
                    <h2 class="text-lg font-bold">Все сервисы ({{ $services->count() }})</h2>
                </div>

                @if ($services->isEmpty())
                    <div class="px-5 py-10 text-center text-gray-500">Записей пока нет.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 text-left text-sm text-gray-600">
                                <tr>
                                    <th class="px-5 py-3 font-medium">Сервис</th>
                                    <th class="px-5 py-3 font-medium">Ссылка</th>
                                    <th class="px-5 py-3 font-medium">Статус</th>
                                    <th class="px-5 py-3 text-right font-medium">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($services as $service)
                                    <tr wire:key="service-{{ $service->id }}" class="align-top">
                                        <td class="px-5 py-4">
                                            <div class="flex min-w-64 gap-3">
                                                @if ($service->img_url)
                                                    <img src="{{ $service->img_url }}" alt=""
                                                         class="h-14 w-14 rounded-lg bg-gray-100 object-contain">
                                                @endif
                                                <div>
                                                    <div class="font-semibold">{{ $service->title }}</div>
                                                    <div class="mt-1 max-w-xl whitespace-pre-line text-sm text-gray-600">{{ $service->opis }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm">
                                            @if ($service->link)
                                                <a href="{{ $service->link }}" target="_blank"
                                                   class="break-all text-blue-700 hover:underline">
                                                    {{ $service->link_title ?: $service->link }}
                                                </a>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <button type="button"
                                                    wire:click="toggleVisibility({{ $service->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="toggleVisibility({{ $service->id }})"
                                                    title="Нажмите, чтобы изменить видимость"
                                                    class="rounded-full px-3 py-1 text-sm transition disabled:opacity-50 {{ $service->onoff === 'on' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                                {{ $service->onoff === 'on' ? 'Показывается' : 'Скрыт' }}
                                            </button>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex justify-end gap-2">
                                                <button type="button" wire:click="edit({{ $service->id }})"
                                                        class="rounded-lg bg-amber-500 px-3 py-2 text-sm font-medium text-white hover:bg-amber-600">
                                                    Изменить
                                                </button>
                                                <button type="button" wire:click="delete({{ $service->id }})"
                                                        wire:confirm="Удалить сервис «{{ $service->title }}»?"
                                                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                                                    Удалить
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    @else
        <main class="mx-auto max-w-xl px-4 py-20 text-center">
            <div class="rounded-xl bg-white p-8 shadow-sm">
                <h1 class="text-2xl font-bold">Вход в админку</h1>
                <p class="mt-3 text-gray-600">Введите пароль в поле в верхней части страницы.</p>
            </div>
        </main>
    @endif
</div>
