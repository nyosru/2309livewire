<div class="min-h-screen">
    <header class="border-b border-gray-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-4 px-4 py-4 sm:px-6">
            <a href="{{ route('phpcat.rental-sites.admin') }}" class="text-xl font-bold text-blue-700">Админка сайтов в аренду</a>

            @if ($authorized)
                <div class="ml-auto flex items-center gap-3">
                    <span class="text-sm text-green-700">Доступ открыт</span>
                    <button type="button" wire:click="logout" class="rounded-lg border border-gray-300 px-4 py-2 text-sm hover:bg-gray-50">Выйти</button>
                </div>
            @else
                <form wire:submit="login" class="ml-auto flex w-full flex-wrap items-start gap-2 sm:w-auto">
                    <div>
                        <label for="rental-admin-password" class="sr-only">Пароль</label>
                        <input id="rental-admin-password" type="password" wire:model="password" autocomplete="current-password" placeholder="Пароль" class="w-full rounded-lg border border-gray-300 px-4 py-2 sm:w-64">
                        @error('password') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700">Войти</button>
                </form>
            @endif
        </div>
    </header>

    @if ($authorized)
        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold">Готовые сайты и домены</h1>
                    <p class="mt-1 text-sm text-gray-600">Эти карточки отображаются в блоке аренды на главной странице.</p>
                </div>
                <a href="{{ route('phpcat.index') }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-blue-300 px-4 py-2 text-blue-700 hover:bg-blue-50">Открыть сайт</a>
            </div>

            @if (session()->has('success'))
                <div class="mb-6 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">{{ session('success') }}</div>
            @endif

            <section class="mb-8 rounded-xl bg-white p-5 shadow-sm sm:p-6">
                <h2 class="mb-5 text-lg font-bold">{{ $editId ? 'Редактирование карточки #'.$editId : 'Новая карточка' }}</h2>
                <form wire:submit="save" class="space-y-5">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="rental-domain" class="mb-1 block font-medium">Домен *</label>
                            <input id="rental-domain" type="text" wire:model="domain" placeholder="пример.рф" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            @error('domain') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="rental-category" class="mb-1 block font-medium">Категория</label>
                            <input id="rental-category" type="text" wire:model="category" placeholder="СПОРТ" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            @error('category') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="rental-sort" class="mb-1 block font-medium">Порядок показа</label>
                            <input id="rental-sort" type="number" min="0" wire:model="sortOrder" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            @error('sortOrder') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div>
                        <label for="rental-description" class="mb-1 block font-medium">Краткое описание *</label>
                        <textarea id="rental-description" wire:model="description" rows="3" class="w-full rounded-lg border border-gray-300 px-3 py-2"></textarea>
                        @error('description') <div class="mt-1 text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center gap-2"><input type="checkbox" wire:model="isRented" class="rounded border-gray-300"> Домен сдан в аренду</label>
                        <label class="inline-flex items-center gap-2"><input type="checkbox" wire:model="isVisible" class="rounded border-gray-300"> Показывать на сайте</label>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="submit" wire:loading.attr="disabled" wire:target="save" class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50">{{ $editId ? 'Сохранить изменения' : 'Добавить сайт' }}</button>
                        @if ($editId)
                            <button type="button" wire:click="cancelEdit" class="rounded-lg border border-gray-300 px-5 py-2 hover:bg-gray-50">Отмена</button>
                        @endif
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-xl bg-white shadow-sm">
                <div class="border-b border-gray-200 px-5 py-4 sm:px-6"><h2 class="text-lg font-bold">Все сайты ({{ $sites->count() }})</h2></div>
                @if ($sites->isEmpty())
                    <div class="px-5 py-10 text-center text-gray-500">Записей пока нет.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 text-left text-sm text-gray-600"><tr><th class="px-5 py-3 font-medium">Домен и описание</th><th class="px-5 py-3 font-medium">Аренда</th><th class="px-5 py-3 font-medium">Публикация</th><th class="px-5 py-3 font-medium">Порядок</th><th class="px-5 py-3 text-right font-medium">Действия</th></tr></thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($sites as $site)
                                    <tr wire:key="rental-admin-site-{{ $site->id }}" class="align-top">
                                        <td class="px-5 py-4"><a href="{{ $site->url() }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-blue-700 hover:underline">{{ $site->domain }}</a><div class="mt-1 max-w-xl text-sm text-gray-600">{{ $site->description }}</div></td>
                                        <td class="px-5 py-4">{{ $site->is_rented ? 'Сдан в аренду' : 'Свободен' }}</td>
                                        <td class="px-5 py-4">{{ $site->is_visible ? 'Показывается' : 'Скрыт' }}</td>
                                        <td class="px-5 py-4">{{ $site->sort_order }}</td>
                                        <td class="px-5 py-4 text-right"><div class="flex justify-end gap-2"><button type="button" wire:click="edit({{ $site->id }})" class="rounded-lg border border-gray-300 px-3 py-1.5 text-sm hover:bg-gray-50">Изменить</button><button type="button" wire:click="delete({{ $site->id }})" wire:confirm="Удалить карточку {{ $site->domain }}?" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm text-red-700 hover:bg-red-50">Удалить</button></div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    @endif
</div>
