<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ЮраМанник! Самые вкусные манники в Тюмени!</title>

    <link type="image/x-icon" href="/phpcat/favcat.ico" rel="shortcut icon" />

    <!-- Fonts -->
{{--    <link rel="preconnect" href="https://fonts.bunny.net">--}}
{{--    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />--}}
    <link rel="stylesheet" href="/css/output.css?v=1" />
{{--    <script src="https://cdn.tailwindcss.com/3.4.16"></script>--}}
{{--    <script src="https://cdn.tailwindcss.com/3.4.16"></script>--}}
{{--    <script>--}}
{{--        tailwind.config = {--}}
{{--            darkMode: "class",--}}
{{--            theme: {--}}
{{--                fontFamily: {--}}
{{--                    // sans: ["Roboto", "sans-serif"],--}}
{{--                    sans: ["monospace"],--}}
{{--                    // body: ["Roboto", "sans-serif"],--}}
{{--                    body: ["monospace"],--}}
{{--                    mono: ["ui-monospace", "monospace"],--}}
{{--                },--}}
{{--            },--}}
{{--            corePlugins: {--}}
{{--                preflight: false,--}}
{{--            },--}}
{{--        };--}}
{{--    </script>--}}

    @livewireStyles

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://ЮраМанник.рф">
    <meta property="og:type" content="website">
    <meta property="og:title" content="ЮраМанник.рф - самые вкусные манники в Тюмени!">
    <meta property="og:description" content="настоящее воплощение простоты и уюта">

{{--    <meta property="og:image" content="https://php-cat.com/phpcat/preview_link_phpcat_for_fb.jpg">--}}
    <meta property="og:image" content="https://xn--80aayihhat9j.xn--p1ai/mannik/preview_link_for_fb.jpg">

    <!-- VK Meta Tags -->
    <meta property="vk:image"  content="https://xn--80aayihhat9j.xn--p1ai/mannik/preview_link_for_vk.jpg" />

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="ЮраМанник.рф">
    <meta property="twitter:url" content="https://xn--80aayihhat9j.xn--p1ai">
    <meta name="twitter:title" content="ЮраМанник.рф - самые вкусные манники в Тюмени!">
    <meta name="twitter:description" content="настоящее воплощение простоты и уюта">
    <meta name="twitter:image" content="https://xn--80aayihhat9j.xn--p1ai/mannik/preview_link_for_vk.jpg">

</head>

<body class="antialiased">

    <header>
        @include('mannik.layouts.header')
    </header>
    <main style="min-height:80vh;">
        @yield('content')
        {{-- {{ $_SERVER['HTTP_HOST'] ?? 'x' }} --}}
    </main>
    @include('mannik.layouts.footer')

{{--    <!-- Yandex.Metrika counter -->--}}
{{--    <script type="text/javascript" >--}}
{{--        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};--}}
{{--            m[i].l=1*new Date();--}}
{{--            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}--}}
{{--            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})--}}
{{--        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");--}}

{{--        ym(76358443, "init", {--}}
{{--            clickmap:true,--}}
{{--            trackLinks:true,--}}
{{--            accurateTrackBounce:true--}}
{{--        });--}}
{{--    </script>--}}
{{--    <noscript><div><img src="https://mc.yandex.ru/watch/76358443" style="position:absolute; left:-9999px;" alt="" /></div></noscript>--}}
{{--    <!-- /Yandex.Metrika counter -->--}}

</body>

{{--<script src="/bg/three.min.js"></script>--}}
{{--<script src="/bg/bg-22.js"></script>--}}

{{--<script src="/app0.js"></script>--}}

{{--<script src="/bg/bg-24.js"></script>--}}
{{--<script src="/bg/bg-42.js"></script>--}}
{{--<style>#bg-42 {--}}
{{--        min-height: 520px;--}}
{{--        margin: 20px 0;--}}
{{--    }</style>--}}

</html>
