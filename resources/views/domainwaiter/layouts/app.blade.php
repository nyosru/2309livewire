<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DomainWaiter</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css"/>
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

{{--    <script src="/bg/bg-2.js"></script>--}}

{{--    <style>--}}
{{--        #bg-2 {--}}
{{--            width: 100%;--}}
{{--            height: 520px;--}}
{{--            margin: 20px 0;--}}
{{--        }--}}

{{--        #bg-42 {--}}
{{--            min-height: 520px;--}}
{{--            margin: 20px 0;--}}
{{--        }--}}
{{--    </style>--}}

    @livewireStyles
</head>

<body class="antialiased">
{{--<div id="bg-2"></div>--}}
<header>
    @include('domainwaiter.layouts.header')
</header>
<main style="min-height:80vh;">
    @yield('content')
    {{-- {{ $_SERVER['HTTP_HOST'] ?? 'x' }} --}}
</main>
@include('domainwaiter.layouts.footer')

{{--<!-- Yandex.Metrika counter -->--}}
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(96032899, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/96032899" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
{{--<!-- /Yandex.Metrika counter -->--}}

</body>

{{--<script src="/bg/three.min.js"></script>--}}
{{--<script src="/bg/bg-22.js"></script>--}}

{{--<script src="/bg/bg-24.js"></script>--}}
{{--<script src="/bg/bg-42.js"></script>--}}



</html>
