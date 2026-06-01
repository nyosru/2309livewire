<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Упс ... отправим вас на работающий сайт</title>

    <link type="image/x-icon" href="/phpcat/favcat.ico" rel="shortcut icon"/>

    <!-- Fonts -->
    <link href="/fonts/figtree/figtree.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet"/>

    <link rel="stylesheet" href="/css/output.css?v=1"/>
    @livewireStyles

    <!-- Meta -->
    <meta property="og:url" content="https://{{ $domain_ru  }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Сайт скоро будет">
    <meta property="og:description" content="">
    <meta property="og:image" content="https://php-cat.com/zaglushka/preview_link_for_fb.jpg">
    <meta property="vk:image" content="https://php-cat.com/zaglushka/preview_link_for_vk.jpg"/>
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="">
    <meta property="twitter:url" content="https://{{ $domain_ru  }}">
    <meta name="twitter:title" content="Сайт скоро будет">
    <meta name="twitter:description" content="">
    <meta name="twitter:image" content="https://php-cat.com/zaglushka/preview_link_for_vk.jpg">

</head>

<body>

<div id="cloud111" class="absolute inset-0">&nbsp;</div>

<div class=" z-50 min-h-[100vh] w-screen flex items-center justify-center">
    <div class="
absolute
{{--top-[30%]--}}
 bg-white
 backdrop-blur-sm
text-blue-900 text-center
px-8 py-6 rounded-lg shadow-xl
min-w-[320px]
">
{{--        {{ $domain_ru  }}--}}
        <h1 class="text-xl font-bold mb-2">Сайт временно недоступен</h1>
        <p class="mb-4">Через <span id="timer" class="font-mono font-bold text-red-600">10</span> секунд вы будете
            автоматически перенаправлены<br>на наш рабочий сайт <a href="https://{{ $domainRedirect }}"
                                                                   class="underline text-blue-700">{{ $domainRedirect }}</a>
        </p>
        <p class="text-sm text-gray-700">Если переадресация не произошла — нажмите <a
                href="https://{{ $domainRedirect }}" class="underline text-blue-700">на ссылку</a>.</p>
    </div>
</div>

<script src="/bg/cloud01/three.r134.min.js"></script>
<script src="/bg/cloud01/vanta.clouds.min.js"></script>
<script>
    VANTA.CLOUDS({
        el: "#cloud111",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 600.00,
        minWidth: 800.00
    });

    let seconds = 10;
    const timerEl = document.getElementById("timer");
    const interval = setInterval(() => {
        seconds--;
        timerEl.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(interval);

            if ('{{ $domainRedirect }}') {
                window.location.href = 'https://' + '{{ $domainRedirect }}';
            }

        }
    }, 1000);
</script>

</body>
</html>
