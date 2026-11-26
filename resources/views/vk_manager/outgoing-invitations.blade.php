<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Исходящие заявки в друзья VK</title>
    @livewireStyles
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f3f6fa;color:#17212b;font:16px/1.5 Arial,sans-serif}.wrap{max-width:1050px;margin:auto;padding:24px 18px 60px}header{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap}h1{font-size:30px;margin:5px 0}.muted{color:#627386}.nav,.actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}.button{display:inline-block;border:0;border-radius:9px;padding:10px 14px;background:#0878f9;color:white;text-decoration:none;font:700 16px Arial,sans-serif;cursor:pointer}.button.secondary{background:#e6edf5;color:#26394b}.button:disabled{opacity:.6;cursor:wait}.panel,.person{background:#fff;border:1px solid #dce3eb;border-radius:14px}.panel{padding:18px;margin:18px 0}.filters{display:grid;grid-template-columns:repeat(4,minmax(130px,1fr));gap:12px;align-items:end}.field label{display:block;font-weight:700;margin-bottom:5px}.field input,.field select{width:100%;min-height:42px;padding:8px 10px;border:1px solid #ccd6e0;border-radius:8px;background:white;color:#17212b;font-size:16px}.message{margin:14px 0;padding:12px 14px;border-radius:10px;background:#e8f7ed}.message.error{background:#fff0ed;color:#a52a1a}.people{display:grid;gap:10px}.person{display:grid;grid-template-columns:56px minmax(0,1fr) auto;align-items:center;gap:12px;padding:12px}.person img{width:52px;height:52px;border-radius:50%;object-fit:cover;background:#e9eef4}.name{font-weight:700}.status{margin-top:4px;color:#627386;overflow-wrap:anywhere}.status.success{color:#247344}.status.error{color:#a52a1a}.empty{padding:18px;color:#627386;text-align:center}.tiny{font-size:14px}@media(max-width:700px){.filters{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:460px){.filters{grid-template-columns:1fr}.person{grid-template-columns:48px minmax(0,1fr)}.person .actions{grid-column:2}.person img{width:44px;height:44px}.wrap{padding:16px 12px}}
    </style>
</head>
<body>
<main class="wrap">
    <header>
        <div><div class="muted">{{ auth()->user()->name }}</div><h1>Исходящие заявки в друзья</h1></div>
        <nav class="nav"><a class="button secondary" href="/">Друзья и подписчики</a><a class="button secondary" href="/history">История аккаунта</a></nav>
    </header>

    <livewire:vk-manager.outgoing-invitations />

    <footer class="muted tiny" style="text-align:center;margin-top:28px"><a href="https://php-cat.com" style="color:inherit">Создание сайта</a></footer>
</main>
@livewireScripts
</body>
</html>
