<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>php-cat.com создание и поддержка сайтов и служб</title>

    <link type="image/x-icon" href="/phpcat/favcat.ico" rel="shortcut icon" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                fontFamily: {
                    sans: ["Roboto", "sans-serif"],
                    body: ["Roboto", "sans-serif"],
                    mono: ["ui-monospace", "monospace"],
                },
            },
            corePlugins: {
                preflight: false,
            },
        };
    </script>

    @livewireStyles

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://php-cat.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="php-cat.com Сергей Бакланов программист">
    <meta property="og:description" content="Домашняя страничка Сергея Бакланова программиста">

    <meta property="og:image" content="https://php-cat.com/phpcat/preview_link_phpcat_for_fb.jpg">

    <!-- VK Meta Tags -->
    <meta property="vk:image"  content="https://php-cat.com/phpcat/preview_link_phpcat_for_vk.jpg" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="php-cat.com">
    <meta property="twitter:url" content="https://php-cat.com">
    <meta name="twitter:title" content="php-cat.com Сергей Бакланов программист">
    <meta name="twitter:description" content="Домашняя страничка Сергея Бакланова программиста">
    <meta name="twitter:image" content="https://php-cat.com/phpcat/preview_link_phpcat_for_vk.jpg">

</head>

<body class="antialiased">

    <header>
        @include('phpcat.layouts.header')
    </header>
    <main style="min-height:80vh;">
        @yield('content')
        {{-- {{ $_SERVER['HTTP_HOST'] ?? 'x' }} --}}
    </main>
    @include('phpcat.layouts.footer')
</body>

<script src="/bg/three.min.js"></script>
<script src="/bg/bg-22.js"></script>

{{--<script src="/bg/bg-24.js"></script>--}}
{{--<script src="/bg/bg-42.js"></script>--}}
<style>#bg-42 {
        min-height: 520px;
        margin: 20px 0;
    }</style>
</html>
