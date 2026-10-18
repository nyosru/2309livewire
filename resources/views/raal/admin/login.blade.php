<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>Вход в управление проектами — РААЛ</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Unbounded:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/raal-admin.css">
</head>
<body class="login-page">
<main class="login-card">
    <a class="admin-brand" href="{{ route('raal.index') }}"><span>Р</span><b>РААЛ</b></a>
    <p class="admin-kicker">/ Управление проектами</p>
    <h1>Вход в админку</h1>
    <p>Добавляйте проекты, обновляйте предложения для инвесторов, фотографии и порядок карточек на сайте.</p>
    <form class="password-login" action="{{ route('raal.admin.login.submit') }}" method="post">
        @csrf
        <label for="admin-password">Пароль</label>
        <input id="admin-password" type="password" name="password" autocomplete="current-password" required autofocus>
        @error('password')<span class="login-error">{{ $message }}</span>@enderror
        <button type="submit">Войти в админку <span>↗</span></button>
    </form>
    <small>Пароль хранится в защищённой конфигурации сайта.</small>
</main>
</body>
</html>
