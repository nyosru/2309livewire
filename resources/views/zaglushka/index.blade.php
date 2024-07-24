<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>php-cat.com звоните пишите</title>

    <link type="image/x-icon" href="/phpcat/favcat.ico" rel="shortcut icon"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css"/>
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                fontFamily: {
                    sans: ['Roboto', 'sans-serif'],
                    body: ['Roboto', 'sans-serif'],
                    mono: ['ui-monospace', 'monospace']
                }
            },
            corePlugins: {
                preflight: false
            }
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
    <meta property="vk:image" content="https://php-cat.com/phpcat/preview_link_phpcat_for_vk.jpg"/>

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="php-cat.com">
    <meta property="twitter:url" content="https://php-cat.com">
    <meta name="twitter:title" content="php-cat.com Сергей Бакланов программист">
    <meta name="twitter:description" content="Домашняя страничка Сергея Бакланова программиста">
    <meta name="twitter:image" content="https://php-cat.com/phpcat/preview_link_phpcat_for_vk.jpg">


    <style>
        /*#bg-42 {*/
        .up {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            xheight: 520px;
            xmin-height: 520px;
            xmargin: 20px 0;
            margin: 0;
        }

        /*#bg-42 .content{*/
        .up .content {
            position: fixed;
            top: 20%;
            left: 30%;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px 10px;
            padding: 10px 15px;
            font-size: 2rem;
        }

        @media screen and (max-width: 768px) {
            /*#bg-42 .content {*/
            .up .content {
                left: 0;
                width: 100%;
                border-radius: 0;
            }
        }

        /*#bg-42 .content_foot{*/
        .up .content_foot {
            position: fixed;
            bottom: 20px;
            right: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px 10px;
            padding: 10px 15px;
            font-size: 1rem;
        }
    </style>
    @if($nn == 42 )
        <script src="/demo/bg-anim/three.88.min.js"></script>
        <script src="/demo/bg-anim/bg-42.js"></script>
    @else
        @if($nn == 1 || $nn == 16 )
            <script src="/demo/webgl/three.min.js"></script>
        @else
            <script src="/demo/bg-anim/three.min.js"></script>
        @endif
        <script src="/demo/bg-anim/bg-{{ $nn }}.js"></script>
    @endif

</head>

<body class="antialiased">
<div style="z-index:5000;">{{ $nn }}</div>
@if(1==2)
    <header class="bg-gray-400">
        @if(1==2)
            @include('phpcat.layouts.header')
        @endif
        &nbsp;
    </header>
@endif
<main>
    {{--    <div  xstyle="min-height:80vh;" id="bg-42">--}}
    <div class="up" xstyle="min-height:80vh;" id="bg-{{ $nn }}">



        <div class="content" id="blockToHide" style="z-index:10;">
            <span id="hideBtn" style="z-index:100; cursor: pointer;" class="text-sm float-right"
                  title="Залипнуть по полной">x</span>
{{--            Сайт не доступен!<br/>--}}
            Внимательно смотрите в&nbsp;экран и&nbsp;не&nbsp;выключайте свет!
        </div>



        <button id="fullscreen-btn">Развернуть на весь экран</button>

        <script>
            document.getElementById('fullscreen-btn').addEventListener('click', function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    }
                }
            });
        </script>



        <div class="content_foot">
            <A class="text-blue-800 underline" href="https://php-cat.com" target="_blank">php-cat.com</a><br/>
            и телеграм <A class="text-blue-800 underline" href="https://t.me/phpcatcom" target="_blank">@phpcatcom</a>

{{--            <!-- Yandex.Metrika informer -->--}}
{{--            <a href="https://metrika.yandex.ru/stat/?id=97718675&amp;from=informer"--}}
{{--               target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/97718675/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"--}}
{{--                                                   style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="97718675" data-lang="ru" /></a>--}}
{{--            <!-- /Yandex.Metrika informer -->--}}

{{--            <!-- Yandex.Metrika counter -->--}}
{{--            <script type="text/javascript" >--}}
{{--                (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};--}}
{{--                    m[i].l=1*new Date();--}}
{{--                    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}--}}
{{--                    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})--}}
{{--                (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");--}}

{{--                ym(97718675, "init", {--}}
{{--                    clickmap:true,--}}
{{--                    trackLinks:true,--}}
{{--                    accurateTrackBounce:true--}}
{{--                });--}}
{{--            </script>--}}
{{--            <noscript><div><img src="https://mc.yandex.ru/watch/97718675" style="position:absolute; left:-9999px;" alt="" /></div></noscript>--}}
{{--            <!-- /Yandex.Metrika counter -->--}}

        </div>
    </div>

    @if(1==2)
        @yield('content')
        {{-- {{ $_SERVER['HTTP_HOST'] ?? 'x' }} --}}
    @endif
</main>

@if(1==2)
    @include('phpcat.layouts.footer')

    {{--    <!-- Yandex.Metrika counter -->--}}
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments);
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
                k, a);
        })
        (window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js', 'ym');

        ym(76358443, 'init', {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/76358443" style="position:absolute; left:-9999px;" alt=""/></div>
    </noscript>
    {{--    <!-- /Yandex.Metrika counter -->--}}

@endif


</body>


<style>
    /* Optional custom styles */
    .hidden {
        display: none;
    }
</style>

<script>
    const hideBtn = document.getElementById('hideBtn');
    const blockToHide = document.getElementById('blockToHide');

    hideBtn.addEventListener('click', function() {
        blockToHide.classList.toggle('hidden');
    });
</script>

{{--<script src="/app0.js"></script>--}}

{{--<script src="/bg/bg-24.js"></script>--}}
{{--<script src="/bg/bg-42.js"></script>--}}
</html>
