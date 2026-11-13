<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>История аккаунта — VK</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f3f6fa;color:#17212b;font:16px/1.5 Arial,sans-serif}.wrap{max-width:1050px;margin:0 auto;padding:24px 18px 70px}header{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;margin-bottom:18px}h1{font-size:30px;margin:6px 0}h2{font-size:22px;margin:0 0 8px}h3{font-size:19px;margin:22px 0 6px}h4{font-size:16px;margin:0 0 12px}.muted{color:#627386;font-size:14px}.panel{background:#fff;border:1px solid #dce3eb;border-radius:14px;padding:20px;margin:16px 0}.button{display:inline-block;border:0;border-radius:9px;background:#0878f9;color:#fff;text-decoration:none;padding:11px 15px;font-size:16px;font-weight:700;cursor:pointer}.button.secondary{background:#e6edf5;color:#26394b}.search-row{display:flex;align-items:flex-end;gap:10px;margin-top:14px}.search-field{position:relative;flex:1;min-width:0}.search-field label{display:block;font-size:14px;font-weight:700;margin-bottom:6px}.search-field input{width:100%;padding:11px 12px;border:1px solid #ccd6e0;border-radius:9px;font-size:16px}.suggestions{position:absolute;top:100%;left:0;right:0;z-index:10;max-height:320px;overflow:auto;background:#fff;border:1px solid #ccd6e0;border-radius:9px;box-shadow:0 10px 25px #17212b22}.suggestions button{display:flex;align-items:center;gap:10px;width:100%;padding:9px 12px;border:0;border-bottom:1px solid #edf0f3;background:#fff;text-align:left;cursor:pointer;font-size:15px}.suggestions button:hover{background:#f3f7fc}.suggestions img,.person-heading img{width:42px;height:42px;object-fit:cover;border-radius:50%;background:#e9eef4}.suggestions strong,.suggestions small{display:block}.suggestions small{color:#627386;font-size:14px;margin-top:2px}.selected-hint{margin:10px 0 0}.message{padding:11px 13px;margin:12px 0 0;border-radius:9px}.error{background:#fff0ed;color:#a52a1a}.person-heading{display:flex;align-items:center;gap:13px}.person-heading h2{margin:0 0 2px}.person-heading p{margin:0}.person-heading a{color:#0868d7}.data-card{margin-top:14px;padding:15px;border:1px solid #e2e8ef;border-radius:10px;background:#fbfcfe}.data-card h4{margin-bottom:8px}.data-card dl,.event-data dl{margin:0}.data-item{display:grid;grid-template-columns:minmax(170px,260px) minmax(0,1fr);gap:12px;padding:7px 0;border-bottom:1px solid #edf0f3}.data-item:last-child{border-bottom:0}.data-item dt{color:#627386;font-size:14px}.data-item dd{margin:0;min-width:0;overflow-wrap:anywhere}.data-item pre{margin:0;white-space:pre-wrap;overflow-wrap:anywhere;font:14px/1.45 ui-monospace,SFMono-Regular,Menlo,monospace;background:#f1f4f8;padding:9px;border-radius:7px}.timeline-panel>p{margin:0 0 14px}.timeline-event{position:relative;display:grid;grid-template-columns:170px minmax(0,1fr);gap:14px;padding:14px 0;border-top:1px solid #e2e8ef}.timeline-event time{font-size:14px;font-weight:700;color:#405468;white-space:nowrap}.event-content{display:flex;flex-direction:column;align-items:flex-start;gap:6px;min-width:0}.event-source,.event-obsolete,.event-current{font-size:14px;color:#627386}.event-current{color:#247547}.event-data{width:100%;margin-top:4px}.event-data summary{font-size:14px;color:#0868d7;cursor:pointer}.event-data dl{margin-top:7px}.event-data .data-item{grid-template-columns:minmax(145px,210px) minmax(0,1fr)}footer{text-align:center;margin-top:28px;font-size:14px}footer a{color:inherit}@media(max-width:620px){.wrap{padding:16px 12px 50px}.search-row{align-items:stretch;flex-direction:column}.search-row .button{width:100%}.timeline-event{grid-template-columns:1fr;gap:6px}.data-item,.event-data .data-item{grid-template-columns:1fr;gap:3px}.panel{padding:15px}}
    </style>
    @livewireStyles
</head>
<body>
<main class="wrap">
    <header>
        <div>
            <p class="muted" style="margin:0">{{ auth()->user()->name }}</p>
            <h1>История аккаунта</h1>
        </div>
        <nav style="display:flex;gap:8px;flex-wrap:wrap">
            <a class="button secondary" href="/">Друзья и подписчики</a>
            <a class="button secondary" href="/instructions">Инструкция</a>
        </nav>
    </header>

    <livewire:vk.account-history />

    <footer><a href="https://php-cat.com">Создание сайта</a></footer>
</main>
@livewireScripts
</body>
</html>
