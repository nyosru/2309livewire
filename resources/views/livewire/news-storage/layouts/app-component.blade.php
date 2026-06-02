<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{{ $title ?? 'News Storage' }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
