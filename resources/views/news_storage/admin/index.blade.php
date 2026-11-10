@component('livewire.news-storage.layouts.app-component', ['title' => 'Административный интерфейс'])
    <section class="mx-auto mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-orange-500">Административный интерфейс</p>
                <h1 class="mt-1 text-3xl font-bold text-neutral-900">Новости Тюмени</h1>
                <p class="mt-2 text-neutral-600">Вы вошли как {{ auth()->user()->name }}: {{ $access->role === 'administrator' ? 'администратор' : 'модератор' }}.</p>
            </div>
            <form method="post" action="/admin/logout">@csrf<button type="submit" class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50">Выйти</button></form>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @if($access->canManage())
                <a href="/admin/news" class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:border-blue-400">
                    <h2 class="text-xl font-semibold text-neutral-900">Редакционный список</h2>
                    <p class="mt-2 text-sm text-neutral-600">Все новости, статусы публикации и редакционные поля.</p>
                </a>
                <a href="/admin/stn-news" class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:border-blue-400">
                    <h2 class="text-xl font-semibold text-neutral-900">Управление новостями</h2>
                    <p class="mt-2 text-sm text-neutral-600">Новости STN, публикация, скрытие и медиа.</p>
                </a>
            @endif
            <a href="/admin/moderation" class="rounded-xl border border-neutral-200 bg-white p-5 shadow-sm hover:border-blue-400">
                <h2 class="text-xl font-semibold text-neutral-900">Модерация</h2>
                <p class="mt-2 text-sm text-neutral-600">Проверка и решение по ожидающим новостям.</p>
            </a>
        </div>

        @if($access->canManage())
            <section class="mt-10 overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-sm">
                <div class="border-b border-neutral-200 px-5 py-4">
                    <h2 class="text-xl font-semibold text-neutral-900">Доступ сотрудников</h2>
                    <p class="mt-1 text-sm text-neutral-600">Здесь появляются все пользователи, которые вошли через ВКонтакте и запросили доступ.</p>
                </div>
                @if(session('status'))<p class="mx-5 mt-4 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700">{{ session('status') }}</p>@endif
                @if($errors->has('role'))<p class="mx-5 mt-4 rounded-md bg-red-50 px-3 py-2 text-sm text-red-700">{{ $errors->first('role') }}</p>@endif
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-neutral-50 text-xs uppercase text-neutral-500"><tr><th class="px-5 py-3">Пользователь</th><th class="px-5 py-3">VK ID</th><th class="px-5 py-3">Последний вход</th><th class="px-5 py-3">Роль</th><th class="px-5 py-3"></th></tr></thead>
                        <tbody class="divide-y divide-neutral-100">
                            @forelse($requests as $request)
                                <tr>
                                    <td class="px-5 py-3 font-medium text-neutral-900">{{ $request->user?->name ?? 'Удалённый пользователь' }}</td>
                                    <td class="px-5 py-3 text-neutral-600">{{ $request->vk_id ?? '—' }}</td>
                                    <td class="px-5 py-3 text-neutral-600">{{ $request->last_login_at?->format('d.m.Y H:i') ?? '—' }}</td>
                                    <td class="px-5 py-3"><form method="post" action="/admin/access/{{ $request->id }}" class="flex items-center gap-2">@csrf @method('PUT')
                                        <select name="role" class="rounded-md border-neutral-300 text-sm">
                                            <option value="" @selected(!$request->role)>Нет доступа</option>
                                            <option value="moderator" @selected($request->role === 'moderator')>Модератор</option>
                                            <option value="administrator" @selected($request->role === 'administrator')>Администратор</option>
                                        </select>
                                    </td><td class="px-5 py-3"><button type="submit" class="rounded-md bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-blue-700">Сохранить</button></form></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-6 text-neutral-500">Запросов на доступ пока нет.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </section>
@endcomponent
