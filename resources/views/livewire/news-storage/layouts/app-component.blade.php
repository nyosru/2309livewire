<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{{ $title ?? 'Самые Тюменские Новости' }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Самые Тюменские Новости — актуальные новости, события и афиша Тюмени и Тюменской области.">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="Самые Тюменские Новости">
    <meta property="og:title" content="{{ $title ?? 'Самые Тюменские Новости' }}">
    <meta property="og:description" content="Самые Тюменские Новости — актуальные новости, события и афиша Тюмени и Тюменской области.">
    <meta property="og:image" content="https://news.api.php-cat.ru/news-storage/social-cover.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'Самые Тюменские Новости' }}">
    <meta name="twitter:description" content="Самые Тюменские Новости — актуальные новости, события и афиша Тюмени и Тюменской области.">
    <meta name="twitter:image" content="https://news.api.php-cat.ru/news-storage/social-cover.png">
    <link rel="icon" type="image/svg+xml" href="/news-storage/favicon.svg?v=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet" />
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100">
    @include('livewire.news-storage.layouts.header')
    <main>
        {{ $slot }}
    </main>
    @include('livewire.news-storage.layouts.footer')
    @livewireScripts
</body>
</html>
