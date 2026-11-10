@component('livewire.news-storage.layouts.app-component', ['title' => 'Вход в админку'])
    <section class="mx-auto mt-10 max-w-xl rounded-xl border border-neutral-200 bg-white p-6 shadow-sm">
        <p class="text-sm font-semibold uppercase tracking-widest text-orange-500">СамыеТюменскиеНовости.рф</p>
        <h1 class="mt-2 text-3xl font-bold text-neutral-900">Вход в административный интерфейс</h1>

        @auth
            <p class="mt-4 text-neutral-700">Вы вошли как <strong>{{ auth()->user()->name }}</strong>. Доступ к редакционному интерфейсу пока не предоставлен.</p>
            <p class="mt-2 text-sm text-neutral-500">Запрос зафиксирован. Администратор увидит ваш VK ID: <strong>{{ auth()->user()->vk_id ?? 'не получен' }}</strong> и сможет назначить роль.</p>
            <form method="post" action="/admin/logout" class="mt-6">@csrf<button type="submit" class="rounded-md border border-neutral-300 px-4 py-2 text-sm font-semibold text-neutral-700 hover:bg-neutral-50">Выйти и сменить аккаунт</button></form>
        @else
            <p class="mt-4 text-neutral-700">Войдите через ВКонтакте. Если доступ ещё не выдан, ваш запрос появится в списке у администратора.</p>
            <a href="/admin/auth/vk" class="mt-6 inline-flex rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Войти через ВКонтакте</a>
        @endauth

        @if(session('error'))<p class="mt-4 text-sm text-red-600">{{ session('error') }}</p>@endif
    </section>
@endcomponent
