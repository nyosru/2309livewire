<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Инструкция — управление VK</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f3f6fa;color:#17212b;font:16px/1.6 Arial,sans-serif}.wrap{max-width:1000px;margin:0 auto;padding:24px 18px 48px}header{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:20px}h1{font-size:30px;margin:8px 0}.button{display:inline-block;background:#0878f9;color:#fff;text-decoration:none;border:0;border-radius:9px;padding:11px 15px;font-size:16px;font-weight:700}.panel{background:#fff;border:1px solid #dce3eb;border-radius:14px;padding:20px;margin:16px 0}.panel h2:first-child{margin-top:0}.guide h2{font-size:23px;margin:22px 0 10px}.guide h3{font-size:19px}.guide p,.guide li{font-size:16px}.guide a{color:#0868d7}.guide pre{overflow:auto;background:#f1f4f8;padding:14px;border-radius:8px;font-size:14px}.guide code{font-size:14px}.guide table{border-collapse:collapse;display:block;overflow:auto}.guide th,.guide td{border:1px solid #dce3eb;padding:8px;text-align:left}.muted{color:#627386;font-size:14px}footer{text-align:center;margin-top:28px}
    </style>
</head>
<body>
<main class="wrap">
    <header>
        <div>
            <p class="muted" style="margin:0">Управление аккаунтом ВКонтакте</p>
            <h1>Инструкция</h1>
        </div>
        <nav style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <a class="button" href="/">Друзья и подписчики</a>
            <a class="button" href="#agent-instructions">Описание для агентов</a>
        </nav>
    </header>

    <section class="panel guide" id="agent-instructions" aria-labelledby="agent-instructions-title">
        <h2 id="agent-instructions-title">Описание для агентов</h2>
        {!! $agentGuideHtml !!}
    </section>

    <section class="panel guide" aria-label="Остальная инструкция">
        {!! $otherGuideHtml !!}
    </section>

    <footer class="muted"><a href="https://php-cat.com" style="color:inherit">Создание сайта</a></footer>
</main>
</body>
</html>
