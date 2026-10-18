<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title', 'Проекты') — РААЛ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Unbounded:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/raal-admin.css">
</head>
<body>
<header class="admin-header">
    <a class="admin-brand" href="{{ route('raal.admin.projects.index') }}"><span>Р</span><b>РААЛ</b><small>Управление проектами</small></a>
    <nav>
        <a href="{{ route('raal.index') }}" target="_blank">Открыть сайт ↗</a>
        <form action="{{ route('raal.admin.logout') }}" method="post">@csrf<button type="submit">Выйти</button></form>
    </nav>
</header>

<main class="admin-main">
    @if(session('success'))
        <div class="admin-notice">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="admin-errors">
            <b>Проверьте заполнение формы:</b>
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    @yield('content')
</main>
<script src="/js/raal-admin.js" defer></script>
</body>
</html>
