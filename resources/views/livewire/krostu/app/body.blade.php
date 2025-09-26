<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>Центр Финансовой Аналитики</title>

{{--    <link href="/krostu/animate.min.css" rel="stylesheet">--}}
{{--    <link href="/krostu/bootstrap.min.css" rel="stylesheet">--}}

    @if(1==1)
    <link href="/css/output.css?v={{ filemtime(public_path('/css/output.css')) }}" rel="stylesheet">
    @livewireStyles

    <!-- Обязательный (и достаточный) тег для браузеров -->
    <link type="image/x-icon" rel="shortcut icon" href="//krostu/favicons/favicon.ico">

    <!-- Дополнительные иконки для десктопных браузеров -->
    <link type="image/png" sizes="16x16" rel="icon" href="/krostu/favicons/favicon-16x16.png">
    <link type="image/png" sizes="32x32" rel="icon" href="/krostu/favicons/favicon-32x32.png">
{{--    <link type="image/png" sizes="96x96" rel="icon" href="/krostu/favicons/favicon-96x96.png">--}}
{{--    <link type="image/png" sizes="120x120" rel="icon" href="/cfa/favicons/icons/favicon-120x120.png">--}}

    <!-- Иконки для Android -->
{{--    <link type="image/png" sizes="72x72" rel="icon" href="/cfa/favicons/icons/android-icon-72x72.png">--}}
{{--    <link type="image/png" sizes="96x96" rel="icon" href="/cfa/favicons/icons/android-icon-96x96.png">--}}
{{--    <link type="image/png" sizes="144x144" rel="icon" href="/cfa/favicons/icons/android-icon-144x144.png">--}}
    <link type="image/png" sizes="192x192" rel="icon" href="/krostu/favicons/android-icon-192x192.png">
{{--    <link type="image/png" sizes="512x512" rel="icon" href="/cfa/favicons/icons/android-icon-512x512.png">--}}
    <link rel="manifest" href="/krostu/favicons/site.manifest">

    <!-- Иконки для iOS (Apple) -->
{{--    <link sizes="57x57" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-57x57.png">--}}
{{--    <link sizes="60x60" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-60x60.png">--}}
{{--    <link sizes="72x72" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-72x72.png">--}}
{{--    <link sizes="76x76" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-76x76.png">--}}
{{--    <link sizes="114x114" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-114x114.png">--}}
{{--    <link sizes="120x120" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-120x120.png">--}}
{{--    <link sizes="144x144" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-144x144.png">--}}
{{--    <link sizes="152x152" rel="apple-touch-icon" href="/cfa/favicons/icons/apple-touch-icon-152x152.png">--}}
    <link sizes="180x180" rel="apple-touch-icon" href="/krostu/favicons/apple-touch-icon.png">

    <!-- Иконки для MacOS (Apple) -->
{{--    <link color="#e52037" rel="mask-icon" href="/cfa/favicons/icons/safari-pinned-tab.svg">--}}

    <!-- Иконки и цвета для плиток Windows -->
{{--    <meta name="msapplication-TileColor" content="#2b5797">--}}
{{--    <meta name="msapplication-TileImage" content="/cfa/favicons/icons/mstile-144x144.png">--}}
{{--    <meta name="msapplication-square70x70logo" content="/cfa/favicons/icons/mstile-70x70.png">--}}
{{--    <meta name="msapplication-square150x150logo" content="/cfa/favicons/icons/mstile-150x150.png">--}}
{{--    <meta name="msapplication-wide310x150logo" content="/cfa/favicons/icons/mstile-310x310.png">--}}
{{--    <meta name="msapplication-square310x310logo" content="/cfa/favicons/icons/mstile-310x150.png">--}}
{{--    <meta name="application-name" content="Центр Финансовой Аналитики">--}}
{{--    <meta name="msapplication-config" content="/cfa/favicons/browserconfig.xml">--}}


        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="https://kRostu.com">
        <meta property="og:type" content="website">
        <meta property="og:title" content="kRostu.com сервис макретолога Сергея Бакланова">
        <meta property="og:description" content="Производим осмотр бизнеса, соц.сетей и сайта, формируем советы, контролируем их реализованность">

        <meta property="og:image" content="https://php-cat.com/krostu/preview_link_for_fb.jpg">

        <!-- VK Meta Tags -->
        <meta property="vk:image"  content="https://php-cat.com/krostu/preview_link_for_vk.jpg" />

        <!-- Twitter Meta Tags -->

        <meta property="twitter:domain" content="krostu.com">
        <meta property="twitter:url" content="https://kRostu.com">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="kRostu.com сервис маркетолога Сергея Бакланова">
        <meta name="twitter:description" content="Производим осмотр бизнеса, соц.сетей и сайта, формируем советы, контролируем их реализованность">
        <meta name="twitter:image" content="https://php-cat.com/krostu/preview_link_for_fb.jpg">


    @endif
</head>
<body style="font-size: 130%;">

{{--<livewire:krostu.app.navigation/>--}}
<livewire:krostu.app.header/>

{{ $slot }}

<livewire:krostu.app.footer/>

@livewireScripts

{{--<!-- Yandex.Metrika counter -->--}}
{{--<script type="text/javascript">--}}
{{--    (function(m,e,t,r,i,k,a){--}}
{{--        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};--}}
{{--        m[i].l=1*new Date();--}}
{{--        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}--}}
{{--        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)--}}
{{--    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=104224527', 'ym');--}}

{{--    ym(104224527, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", accurateTrackBounce:true, trackLinks:true});--}}
{{--</script>--}}
{{--<noscript><div><img src="https://mc.yandex.ru/watch/104224527" style="position:absolute; left:-9999px;" alt="" /></div></noscript>--}}
{{--<!-- /Yandex.Metrika counter -->--}}

</body>
</html>
