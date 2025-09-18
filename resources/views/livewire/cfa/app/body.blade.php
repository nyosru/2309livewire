<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Центр Финансовой Аналитики</title>
    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet">
    @livewireStyles

    <!-- Обязательный (и достаточный) тег для браузеров -->
    <link type="image/x-icon" rel="shortcut icon" href="/cfa/favicons/favicon.ico">

    <!-- Дополнительные иконки для десктопных браузеров -->
    <link type="image/png" sizes="16x16" rel="icon" href="/cfa/favicons/icons/favicon-16x16.png">
    <link type="image/png" sizes="32x32" rel="icon" href="/cfa/favicons/icons/favicon-32x32.png">
    <link type="image/png" sizes="96x96" rel="icon" href="/cfa/favicons/icons/favicon-96x96.png">
    <link type="image/png" sizes="120x120" rel="icon" href="/cfa/favicons/icons/favicon-120x120.png">

    <!-- Иконки для Android -->
    <link type="image/png" sizes="72x72" rel="icon" href="/cfa/favicons/icons/android-icon-72x72.png">
    <link type="image/png" sizes="96x96" rel="icon" href="/cfa/favicons/icons/android-icon-96x96.png">
    <link type="image/png" sizes="144x144" rel="icon" href="/cfa/favicons/icons/android-icon-144x144.png">
    <link type="image/png" sizes="192x192" rel="icon" href="/cfa/favicons/icons/android-icon-192x192.png">
    <link type="image/png" sizes="512x512" rel="icon" href="/cfa/favicons/icons/android-icon-512x512.png">
    <link rel="manifest" href="/cfa/favicons/manifest.json">

    <!-- Иконки для iOS (Apple) -->
    <link sizes="57x57" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-57x57.png">
    <link sizes="60x60" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-60x60.png">
    <link sizes="72x72" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-72x72.png">
    <link sizes="76x76" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-76x76.png">
    <link sizes="114x114" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-114x114.png">
    <link sizes="120x120" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-120x120.png">
    <link sizes="144x144" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-144x144.png">
    <link sizes="152x152" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-152x152.png">
    <link sizes="180x180" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-180x180.png">

    <!-- Иконки для MacOS (Apple) -->
    <link color="#e52037" rel="mask-icon" href="/cfa/favicons/icons/safari-pinned-tab.svg">

    <!-- Иконки и цвета для плиток Windows -->
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="msapplication-TileImage" content="/cfa/favicons/icons/mstile-144x144.png">
    <meta name="msapplication-square70x70logo" content="/cfa/favicons/icons/mstile-70x70.png">
    <meta name="msapplication-square150x150logo" content="/cfa/favicons/icons/mstile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/cfa/favicons/icons/mstile-310x310.png">
    <meta name="msapplication-square310x310logo" content="/cfa/favicons/icons/mstile-310x150.png">
    <meta name="application-name" content="Центр Финансовой Аналитики">
    <meta name="msapplication-config" content="/cfa/favicons/browserconfig.xml">

</head>
<body>

<livewire:app.navigation/>

{{ $slot }}

<livewire:app.footer/>

@livewireScripts

</body>
</html>
