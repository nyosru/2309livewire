<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Земельный кадастр — межевание и юридическое сопровождение' }}</title>
    <meta name="description" content="Межевание, уточнение границ, оформление участков и юридическое сопровождение земельных вопросов. Разберём документы и предложим понятный план действий.">

    <meta property="og:title" content="Земельный кадастр — земля без спорных границ">
    <meta property="og:description" content="Кадастровые и юридические услуги по земельным вопросам с понятным результатом, сроками и стоимостью.">

    <meta property="og:type" content="website">
    <meta property="og:url" content="https://xn--80aalcakqihin5bmo2koa.xn--p1ai/">

    <link rel="canonical" href="https://xn--80aalcakqihin5bmo2koa.xn--p1ai/">
    <meta name="theme-color" content="#f4f0e6">

    <link rel="stylesheet" href="/css/zem_kadastr.css?v=4">
    @livewireStyles

</head>
<body>
    {{ $slot }}

    @livewireScripts
</body>
</html>
