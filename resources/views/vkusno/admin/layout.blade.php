<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Управление кафе') — Вкусняжки72</title>
    <link rel="icon" href="/vkusno/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/vkusno/cafe.css">
    <link rel="stylesheet" href="/vkusno/admin.css">
</head>
<body>
<header class="admin-topbar">
    <a href="/"><img src="/vkusno/logo.svg" alt="Вкусняжки72 — на сайт" width="240" height="55"></a>
    <span>Управление кафе</span>
    @auth
    <form method="post" action="/admin/logout">@csrf<button class="admin-button admin-button-light" type="submit">Выйти</button></form>
    @endauth
</header>
<main class="vadmin">
    @if(auth()->check() && \App\Models\Vkusno\Administrator::canManage(auth()->user()))
    <nav class="admin-nav" aria-label="Управление кафе">
        @foreach(['/admin/products' => 'Товары', '/admin/categories' => 'Категории', '/admin/sections' => 'Разделы меню', '/admin/orders' => 'Заказы'] as $path => $label)
        <a href="{{ $path }}" @if(request()->is(ltrim($path, '/').'*')) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
        @if(\App\Models\Vkusno\Administrator::isSuperAdmin(auth()->user()))<a href="/admin/settings" @if(request()->is('admin/settings*')) aria-current="page" @endif>Настройки</a><a href="/admin/access" @if(request()->is('admin/access*')) aria-current="page" @endif>Доступ к панели</a>@endif
        <a href="/">Открыть сайт ↗</a>
    </nav>
    @endif
    @if(session('status'))<p class="admin-notice" role="status">{{ session('status') }}</p>@endif
    @if(session('error'))<p class="admin-errors" role="alert">{{ session('error') }}</p>@endif
    @if($errors->any())<div class="admin-errors" role="alert"><p>Проверьте заполнение формы:</p><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    @yield('content')
</main>
</body>
</html>
