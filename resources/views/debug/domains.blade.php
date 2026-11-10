<?php

use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Debug page — domains inventory for container 2309livewire
|--------------------------------------------------------------------------
|
| Accessible only while config('app.debug') === true.
| Route: GET /debug/domains   (name: debug.domains)
|
*/

$flattened = collect($categories)->flatten(1)->toArray();

$commented = [
    ['value' => 'управлятор.рф',            'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'xn--80ae1ambgeod9j.xn--p1ai', 'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'php-cat.com',               'env' => 'prod', 'note' => 'historical; commented in routes/web.php / web.domainwaiter.php'],
    ['value' => 'domainwaiter.com',          'env' => 'prod', 'note' => 'historical; commented in routes/web.domainwaiter.php'],
    ['value' => 'bu72.ru',                   'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'vk.files.php-cat.com',      'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'продукты72.рф',             'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'xn--72-jlcysfhth6f.xn--p1ai', 'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'приватизациягаража.рф',     'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'xn--80aaaaahj0aehcc8fojz5e1i.xn--p1ai', 'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'земельныйкадастр.рф',       'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'xn--80aalcakqihin5bmo2koa.xn--p1ai', 'env' => 'prod', 'note' => 'historical; commented in routes/web.php'],
    ['value' => 'livewire.php-cat.com',      'env' => 'prod', 'note' => 'historical; commented in routes/web.uprav.php / web.domainwaiter.php'],
];

$services = [
    ['host' => 'db_mysql',    'port' => '3306', 'role' => 'MySQL (DB_DATABASE=2309livewire, root)', 'note' => 'linke-d container db'],
    ['host' => '127.0.0.1',   'port' => '6379', 'role' => 'Redis', 'note' => 'REDIS_HOST / REDIS_PORT'],
    ['host' => '127.0.0.1',   'port' => '11211', 'role' => 'Memcached', 'note' => 'MEMCACHED_HOST'],
    ['host' => 'mailpit',     'port' => '1025', 'role' => 'Mailpit (SMTP)', 'note' => 'MAIL_HOST / MAIL_PORT'],
    ['host' => '—',           'port' => '—',    'role' => 'Pusher', 'note' => 'PUSHER_HOST empty (Swoole/websock не поднят)'],
    ['host' => 'xn--72-dlcqkkbw9at8k.xn--p1ai', 'port' => '—', 'role' => 'MAX webhook', 'note' => 'MAX_WEBHOOK_URL -> /api/max/webhook'],
];

$appEnvLabel = Str::upper(config('app.env'));
$debugLabel  = config('app.debug') ? 'ВКЛЮЧЕНО (true)' : 'ВЫКЛЮЧЕНО (false)';

$currentDomains = [];
$productionDomains = [];

foreach ($categories as $key => $cat) {
    $label = $cat['label'] ?? $key;
    foreach ($cat['items'] as $item) {
        // attach module label to each row for display
        $item['module'] = $label;
        if ($item['env'] === 'local') {
            $currentDomains[] = $item;
        } else {
            $productionDomains[] = $item;
        }
    }
}

// sort by module label, then domain value
usort($currentDomains, function ($a, $b) {
    return strcmp($a['module'], $b['module']) ?: strcmp($a['value'], $b['value']);
});
usort($productionDomains, function ($a, $b) {
    return strcmp($a['module'], $b['module']) ?: strcmp($a['value'], $b['value']);
});

$currentDomains = array_values($currentDomains);
$productionDomains = array_values($productionDomains);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Диагностика контейнера 2309livewire — домены</title>
    <style>
        :root {
            --fg: var(--foreground);
            --muted: var(--muted-foreground);
            --accent: var(--accent);
            --border: var(--border);
            --card: var(--card);
        }
        * { box-sizing: border-box; }
        body {
            color: var(--fg);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans", sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 24px 16px 64px;
        }
        .wrap { max-width: 1100px; margin: 0 auto; }
        h1 { font-size: 22px; margin: 0 0 4px; }
        h2 { font-size: 16px; margin: 22px 0 8px; padding-bottom: 6px; border-bottom: 1px solid var(--border); }
        .sub { color: var(--muted); margin: 0 0 16px; }
        .badge {
            display: inline-block; padding: 2px 8px; border-radius: 6px;
            background: #b91c1c; color: #fff; font-size: 12px; font-weight: 700; letter-spacing: .5px;
        }
        .card {
            background: var(--card); border: 1px solid var(--border); border-radius: 10px; padding: 16px 18px;
        }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap: 16px; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { text-align: left; padding: 9px 10px; border-bottom: 1px solid var(--border); vertical-align: top; }
        th { color: var(--muted); font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; }
        tr:last-child td { border-bottom: none; }
        .mono { font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 13px; white-space: nowrap; }
        .tag {
            display: inline-block; padding: 1px 7px; border-radius: 5px; font-size: 12px; font-weight: 700;
        }
        .tag-local { background: #0d47a1; color: #fff; }
        .tag-prod  { background: #1b5e20; color: #fff; }
        .foot { margin-top: 24px; color: var(--muted); font-size: 13px; }
        .warn { border: 1px solid #b91c1c; background: #fef2f2; border-radius: 10px; padding: 12px 16px; }
        .warn strong { color: #b91c1c; }
    </style>
</head>
<body>
<div class="wrap">

    <div class="warn">
        <strong>ДИАГНОСТИЧЕСКАЯ СТРАНИЦА. Доступна только при APP_DEBUG=true.</strong>
        <div style="margin-top:6px;">APP_ENV={{ $appEnvLabel }} &nbsp;|&nbsp; APP_DEBUG={{ $debugLabel }} &nbsp;|&nbsp; APP_URL={{ $config['app.url'] }}</div>
    </div>

    <div class="card">
        <h1>Домены, используемые в контейнере 2309livewire</h1>
        <p class="sub">
            Список доменов (хостов), зарегистрированных как маршруты в Laravel-приложении
            (<code>routes/</code>), + сервисы-сопряжения из <code>.env</code>.
            Каждый домен показан с привязкой к окружению и исходнику.
            <p class="sub" style="margin-top:6px;">Нажимая на название домена, откроется этот хост в новой вкладке.</p>
        </p>
    </div>

    <div class="card">
        <h2>Активные домены — <span class="mono">local</span></h2>
        <p class="sub" style="margin:0 0 8px;">Что разрешается в текущем окружении.</p>
        <table>
            <thead><tr><th>Домен</th><th>Модуль</th><th>Примечание</th></tr></thead>
            <tbody>
                @foreach($currentDomains as $d)
                <tr>
                    <td class="mono"><a href="//{{ $d['value'] }}" target="_blank" rel="noopener noreferrer">{{ $d['value'] }}</a></td>
                    <td>{{ $d['module'] ?? '' }}</td>
                    <td>{{ $d['note'] ?? '' }}</td>
                </tr>
                @endforeach
                @if(!$currentDomains)
                <tr><td colspan="3">Нет локальных доменов.</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Активные домены — <span class="mono">prod</span></h2>
        <p class="sub" style="margin:0 0 8px;">Публичные домены приложения (продакшн).</p>
        <table>
            <thead><tr><th>Домен</th><th>Модуль</th><th>Примечание</th></tr></thead>
            <tbody>
                @foreach($productionDomains as $d)
                <tr>
                    <td class="mono"><a href="//{{ $d['value'] }}" target="_blank" rel="noopener noreferrer">{{ $d['value'] }}</a></td>
                    <td>{{ $d['module'] ?? '' }}</td>
                    <td>{{ $d['note'] ?? '' }}</td>
                </tr>
                @endforeach
                @if(!$productionDomains)
                <tr><td colspan="3">Нет продакшн-доменов.</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Комментарии (исторически заданные, не активны)</h2>
        <p class="sub" style="margin:0 0 8px;">Домены, встречающиеся в коде, но выключенные комментарием.</p>
        <table>
            <thead><tr><th>Домен</th><th>Окружение</th><th>Примечание</th></tr></thead>
            <tbody>
                @foreach($commented as $c)
                <tr>
                    <td class="mono">{{ $c['value'] }}</td>
                    <td><span class="tag" style="background:#b45309;color:#fff;">hold</span></td>
                    <td>{{ $c['note'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Сервисы-сопряжения (из <code>.env</code>)</h2>
        <p class="sub" style="margin:0 0 8px;">Внешние хосты, на которые ссылается контейнер.</p>
        <table>
            <thead><tr><th>Хост</th><th>Порт</th><th>Роль</th><th>Примечание</th></tr></thead>
            <tbody>
                @foreach($services as $s)
                <tr>
                    <td class="mono">{{ $s['host'] }}</td>
                    <td class="mono">{{ $s['port'] }}</td>
                    <td>{{ $s['role'] }}</td>
                    <td>{{ $s['note'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="foot">
        Сгенерировано из <code>routes/</code> Laravel-приложения контейнера 2309livewire.
        Динамические домены разрешаются в зависимости от <code>request()->getHost()</code> / окружения, поэтому
        в таблице показаны как локальные, так и продакшн-варианты.
    </p>
</div>
</body>
</html>
