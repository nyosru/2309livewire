<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Записи диктофона')</title>
    <style>
        :root { --bg:#f4f6f8; --card:#fff; --ink:#1c2430; --muted:#6b7785; --line:#e3e8ee; --accent:#2563eb; --accent-soft:#e8f0ff; --danger:#dc2626; --danger-soft:#feecec; }
        * { box-sizing: border-box; }
        body { margin:0; font:16px/1.55 -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif; color:var(--ink); background:var(--bg); }
        a { color:var(--accent); text-decoration:none; }
        a:hover { text-decoration:underline; }
        .wrap { max-width:1100px; margin:0 auto; padding:28px 18px 60px; }
        header { margin-bottom:22px; }
        h1 { margin:0 0 6px; font-size:28px; letter-spacing:-.02em; }
        h2 { margin:0 0 12px; font-size:20px; letter-spacing:-.01em; }
        .sub { color:var(--muted); margin:0; font-size:14px; word-break:break-all; }
        .stats { display:flex; gap:10px; flex-wrap:wrap; margin:16px 0 22px; }
        .pill { background:var(--accent-soft); color:#1e40af; padding:6px 12px; border-radius:999px; font-size:13px; font-weight:600; }
        .alert { background:#fff4e5; border:1px solid #ffd9a8; color:#7a4a00; padding:14px 16px; border-radius:12px; }
        .panel { background:var(--card); border:1px solid var(--line); border-radius:14px; padding:16px 18px; margin-bottom:18px; }
        .list { display:grid; gap:14px; }
        .card { background:var(--card); border:1px solid var(--line); border-radius:14px; padding:16px 18px; }
        .top { display:flex; gap:14px; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; }
        .name { font-weight:700; font-size:17px; margin:0 0 4px; word-break:break-all; }
        .meta { color:var(--muted); font-size:13px; display:flex; gap:12px; flex-wrap:wrap; }
        .links { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .btn, button.btn { display:inline-block; padding:7px 12px; border-radius:9px; border:1px solid var(--line); background:#fafbfc; color:var(--ink); font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; line-height:1.3; }
        .btn:hover, button.btn:hover { background:#f0f4f8; text-decoration:none; }
        .btn-primary { background:var(--accent); border-color:var(--accent); color:#fff; }
        .btn-primary:hover { background:#1d4ed8; }
        .btn-danger { background:var(--danger-soft); border-color:#f7caca; color:var(--danger); }
        .btn-danger:hover { background:#fde2e2; }
        audio { width:100%; margin-top:12px; height:38px; }
        .content-block { margin:12px 0 0; }
        .block-label { font-size:12px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.04em; margin:0 0 6px; }
        .scroll-block { max-height:300px; overflow:auto; padding:12px 14px; background:#f7f9fb; border:1px solid #edf1f5; border-radius:10px; color:#334155; font-size:14px; white-space:pre-wrap; }
        .tags-row { display:flex; flex-wrap:wrap; gap:8px; align-items:center; margin-top:12px; }
        .tag { display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:999px; background:var(--accent-soft); color:#1e40af; font-size:13px; font-weight:600; }
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
        footer { margin-top:30px; color:var(--muted); font-size:13px; }
        footer a { color:var(--muted); text-decoration:underline; }
        @media (max-width:640px){ h1{font-size:24px;} .card,.panel{padding:14px;} .inline-form{width:100%;} .inline-form input[type="text"]{min-width:0; flex:1;} }
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
</body>
</html>
