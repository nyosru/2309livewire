<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Катком — планируйте постепенно, делайте уверенно' }}</title>
    <meta name="description" content="Катком — простой подход к постепенному планированию дел с CRM ПроцессМастер.">
    <meta property="og:title" content="Катком — не всё сразу. Всё по шагам.">
    <meta property="og:description" content="Превращайте большие цели в понятные действия и двигайтесь без хаоса.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://xn--80atbijw.xn--p1ai/">
    <meta property="og:image" content="https://xn--80atbijw.xn--p1ai/catcom/og-preview.png">
    <meta property="og:image:secure_url" content="https://xn--80atbijw.xn--p1ai/catcom/og-preview.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Катком.рф — «Маленькие шаги!» Видимый прогресс! Большие результаты!">
    <meta property="vk:image" content="https://xn--80atbijw.xn--p1ai/catcom/og-preview.png">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="https://xn--80atbijw.xn--p1ai/catcom/og-preview.png">
    <link rel="canonical" href="https://xn--80atbijw.xn--p1ai/">
    <meta name="theme-color" content="#f4f1e8">

    <link rel="stylesheet" href="/css/catcom.css?v=1">
    @livewireStyles
</head>
<body>
    {{ $slot }}

    @livewireScripts
</body>
</html>
