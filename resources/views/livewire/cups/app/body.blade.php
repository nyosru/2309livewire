<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, maximum-scale=1"/>
    <link rel="shortcut icon" href="/storage/krugi/favicon.png" type="image/png"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="/css/output.css?v13"/>

    @livewireStyles
</head>
<body class="font-sans antialiased">

<div class="p-2 bg-orange-300 rounded-lg shadow-md" style="z-index:10; position: fixed; bottom: 10px; right: 10px;">
    Создание
    сайта <a href="https://php-cat.com" class="underline" target="_blank">php-cat.com</a>
</div>

{{ $slot }}

@livewireScripts

{{--<!-- Yandex.Metrika counter -->--}}
{{--<script type="text/javascript">--}}
{{--    (function (m, e, t, r, i, k, a) {--}}
{{--        m[i] = m[i] || function () {--}}
{{--            (m[i].a = m[i].a || []).push(arguments)--}}
{{--        };--}}
{{--        m[i].l = 1 * new Date();--}}
{{--        for (var j = 0; j < document.scripts.length; j++) {--}}
{{--            if (document.scripts[j].src === r) {--}}
{{--                return;--}}
{{--            }--}}
{{--        }--}}
{{--        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)--}}
{{--    })--}}
{{--    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");--}}

{{--    ym(96033624, "init", {--}}
{{--        clickmap: true,--}}
{{--        trackLinks: true,--}}
{{--        accurateTrackBounce: true--}}
{{--    });--}}
{{--</script>--}}
{{--<noscript><div><img src="https://mc.yandex.ru/watch/96033624" style="position:absolute; left:-9999px;" alt=""/></div></noscript>--}}
{{--<!-- /Yandex.Metrika counter -->--}}
</body>
</html>