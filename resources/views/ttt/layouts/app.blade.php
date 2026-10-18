<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Школа бильярда Александра Коновалова в Тюмени — TTT72</title>
    <meta name="description" content="Научитесь уверенно держать кий, точно бить и понимать игру уже с первых занятий — даже если раньше никогда не подходили к бильярдному столу.">
    <link rel="canonical" href="https://ttt72.ru/">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="TTT72 — школа бильярда">
    <meta property="og:url" content="https://ttt72.ru/">
    <meta property="og:title" content="Научитесь играть в бильярд уверенно — с нуля">
    <meta property="og:description" content="Александр Коновалов поставит технику, разберёт ошибки и поможет перейти от случайных ударов к осознанной игре.">
    <meta property="og:image" content="https://ttt72.ru/ttt/preview_link_for_fb.jpg">
    <meta property="og:image:secure_url" content="https://ttt72.ru/ttt/preview_link_for_fb.jpg">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="og:image:alt" content="Обучение игре в бильярд в школе TTT72">

    <meta property="vk:image" content="https://ttt72.ru/ttt/preview_link_for_vk.jpg">
    <link type="image/x-icon" href="/phpcat/favcat.ico" rel="shortcut icon" />
{{--    <!-- Fonts -->--}}
{{--    <link rel="preconnect" href="https://fonts.bunny.net">--}}
{{--    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />--}}
{{--    <link rel="stylesheet" href="/css/output.css?v=1" />--}}
    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet">
    <link href="/css/ttt.css?v={{ filemtime(public_path('/css/ttt.css')) }}" rel="stylesheet">
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

{{--    @livewireStyles--}}

</head>

<body class="ttt-site antialiased">

    <header>
        @include('ttt.layouts.header')
    </header>
    <main style="min-height:80vh;">
{{--        @yield('content')--}}
        {{ $slot }}
        {{-- {{ $_SERVER['HTTP_HOST'] ?? 'x' }} --}}
    </main>
    @include('ttt.layouts.footer')

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
