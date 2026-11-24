<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Дерево проектов')</title>
    <link rel="stylesheet" href="/css/output.css?v=1">
    <style>
        :root { --bg:#f4f6f8; --card:#fff; --ink:#1c2430; --muted:#6b7785; --line:#e3e8ee; --accent:#2563eb; --accent-soft:#e8f0ff; --danger:#dc2626; --danger-soft:#feecec; }
        * { box-sizing: border-box; }
        body { margin:0; font:16px/1.55 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif; color:var(--ink); background:var(--bg); }
        a { color:var(--accent); text-decoration:none; }
        a:hover { text-decoration:underline; }
        .wrap { max-width:1680px; margin:0 auto; padding:28px 18px 60px; }
        header { margin-bottom:22px; }
        h1 { margin:0 0 6px; font-size:28px; letter-spacing:-.02em; }
        h2 { margin:0 0 12px; font-size:20px; letter-spacing:-.01em; }
        .sub { color:var(--muted); margin:0; font-size:14px; word-break:break-all; }
        .stats { display:flex; gap:10px; flex-wrap:wrap; margin:16px 0 22px; }
        .pill { background:var(--accent-soft); color:#1e40af; padding:6px 12px; border-radius:999px; font-size:14px; font-weight:600; }
        .alert { background:#fff4e5; border:1px solid #ffd9a8; color:#7a4a00; padding:14px 16px; border-radius:12px; }
        .panel { background:var(--card); border:1px solid var(--line); border-radius:14px; padding:16px 18px; margin-bottom:18px; }
        .list { display:grid; gap:14px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:14px; padding:16px 18px; }
        .name { font-weight:700; font-size:17px; margin:0 0 4px; word-break:break-all; }
        .meta { color:var(--muted); font-size:14px; display:flex; gap:12px; flex-wrap:wrap; }
        .links { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .btn, button.btn { display:inline-block; padding:7px 12px; border-radius:9px; border:1px solid var(--line); background:#fafbfc; color:var(--ink); font-size:14px; font-weight:600; cursor:pointer; font-family:inherit; line-height:1.3; }
        .btn:hover, button.btn:hover { background:#f0f4f8; text-decoration:none; }
        .btn-primary { background:var(--accent); border-color:var(--accent); color:#fff; }
        .btn-primary:hover { background:#1d4ed8; }
        .btn-danger { background:var(--danger-soft); border-color:#f7caca; color:var(--danger); }
        .btn-danger:hover { background:#fde2e2; }
        audio { width:100%; margin-top:12px; height:38px; }
        .content-block { margin:12px 0 0; }
        .block-label { font-size:14px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.04em; margin:0 0 6px; }
        .scroll-block { max-height:300px; overflow:auto; padding:12px 14px; background:#f7f9fb; border:1px solid #edf1f5; border-radius:10px; color:#334155; font-size:14px; white-space:pre-wrap; }
        .tag { display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:999px; background:var(--accent-soft); color:#1e40af; font-size:14px; font-weight:600; }
        .tag form { margin:0; }
        .tag-remove { border:none; background:transparent; color:#1e40af; cursor:pointer; font-size:15px; line-height:1; padding:0 0 0 2px; }
        .tag-remove:hover { color:var(--danger); }
        .inline-form { display:inline-flex; gap:8px; align-items:center; flex-wrap:wrap; margin:0; }
        .inline-form input[type="text"], .inline-form select { padding:7px 10px; border:1px solid var(--line); border-radius:9px; font:inherit; font-size:14px; background:#fff; color:var(--ink); }
        .inline-form input[type="text"] { min-width:180px; }
        .tag-admin-list { display:grid; gap:10px; margin-top:12px; }
        .tag-admin-item { display:flex; gap:8px; align-items:center; flex-wrap:wrap; padding:10px 12px; border:1px solid var(--line); border-radius:10px; background:#fafbfc; }
        .muted { color:var(--muted); font-size:14px; }
        hr.sep { border:none; border-top:1px solid var(--line); margin:14px 0; }
        footer { margin-top:30px; color:var(--muted); font-size:14px; }
        footer a { color:var(--muted); text-decoration:underline; }
        @media (max-width:640px){ h1{font-size:24px;} .card,.panel{padding:14px;} .inline-form{width:100%;} .inline-form input[type="text"]{min-width:0; flex:1;} }
    </style>
    <style>
        .workspace { display:grid; grid-template-columns:minmax(360px, .95fr) minmax(400px, 1.25fr); gap:26px; align-items:start; }
        .section-heading { display:flex; align-items:center; justify-content:space-between; gap:16px; margin-bottom:16px; }
        .section-heading h2 { margin:0; }
        .tree-panel { padding:22px; background:#fff; border:1px solid var(--line); border-radius:16px; }
        .tree { list-style:none; padding:0; margin:0; }
        .tree .tree { margin-left:13px; padding:0 0 8px 22px; border-left:2px solid #ccd9ee; }
        .branch { position:relative; margin:0 0 18px; scroll-margin-top:20px; }
        .tree .tree > .branch:before { content:''; position:absolute; bottom:25px; left:-24px; width:22px; border-top:2px solid #ccd9ee; }
        .branch-heading { background:#f3f6fc; border:1px solid #dde5f3; border-radius:12px; padding:12px 14px; }
        .branch:target > .branch-heading { outline:2px solid var(--accent); }
        .branch-name { display:flex; gap:9px; align-items:center; font-weight:700; font-size:18px; overflow-wrap:anywhere; }
        .branch-dot { width:12px; height:12px; border:3px solid var(--accent); background:#fff; border-radius:50%; flex:none; }
        .branch-info { display:flex; flex-wrap:wrap; gap:6px 14px; color:var(--muted); font-size:14px; margin:5px 0 10px; }
        summary { cursor:pointer; font-weight:600; }
        details > form { margin-top:12px; }
        .branch-form { display:grid; gap:10px; }
        label { display:grid; gap:5px; font-size:14px; font-weight:600; }
        input, select { min-width:0; max-width:100%; padding:9px 10px; font:inherit; font-size:14px; color:var(--ink); background:#fff; border:1px solid #cbd5e1; border-radius:8px; }
        .branch-actions { display:flex; flex-wrap:wrap; gap:8px 18px; font-size:14px; }
        .branch-actions details { flex:1; min-width:125px; }
        .branch-recordings { margin:12px 0 12px 5px; border-left:2px solid #dce5f3; padding-left:14px; display:grid; gap:10px; }
        .record-date { color:var(--muted); font-size:14px; font-weight:400; display:block; }
        .assignment { display:flex; align-items:end; gap:8px; margin-top:14px; flex-wrap:wrap; }
        .assignment label { flex:1; min-width:160px; }
        .filters { display:flex; flex-wrap:wrap; gap:10px; align-items:end; }
        .filters label:first-child { flex:1; }
        .empty { padding:28px 16px; text-align:center; color:var(--muted); background:#fff; border:1px dashed #cad5e3; border-radius:12px; }
        .pagination { display:flex; justify-content:center; align-items:center; gap:14px; margin:22px 0; }
        .notice { padding:12px 16px; margin:0 0 18px; background:#e7f6f0; border-radius:10px; color:#207458; }
        .tag-manager { margin-top:26px; }
        .text-preview { margin-top:12px; }
        .text-preview .scroll-block { min-height:50px; }
        .alert { margin-bottom:16px; }
        @media(max-width:1000px) { .workspace { grid-template-columns:1fr; } .tree-panel { padding:16px; } }
        @media(max-width:480px) { .wrap { padding:18px 12px 40px; } .tree .tree { padding-left:14px; margin-left:4px; } .tree .tree > .branch:before { left:-16px; width:14px; } .branch-actions { display:block; } .branch-actions details { margin-top:8px; } }
    </style>
    @stack('head')
</head>
<body>
<div class="wrap">
    @yield('content')
    <footer>
        <a href="https://php-cat.com" target="_blank" rel="noopener">Создание сайта</a>
    </footer>
</div>
<script>
    document.addEventListener('toggle', async function (event) {
        const details = event.target;
        if (!details.matches('details[data-text-url]') || !details.open || details.dataset.loaded) return;
        const output = details.querySelector('.scroll-block');
        output.textContent = 'Загрузка…';
        try {
            const response = await fetch(details.dataset.textUrl);
            if (!response.ok) throw new Error('load');
            output.textContent = await response.text();
            details.dataset.loaded = 'true';
        } catch (_) { output.textContent = 'Не удалось загрузить текст. Закройте и откройте блок для повтора.'; }
    }, true);
</script>
</body>
</html>
