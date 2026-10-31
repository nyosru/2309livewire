<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Администрирование PHP-Cat</title>
    <link rel="stylesheet" href="/css/output.css?v=1">
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 antialiased">
    {{ $slot }}

    @livewireScripts
</body>
</html>
