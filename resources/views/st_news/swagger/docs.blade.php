<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API — Самые Тюменские Новости</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">
    <style>
        :root { --stn-orange: #f97316; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Roboto, "Segoe UI", sans-serif; background: #fff; }

        /* Верхняя панель — селектор тем/API справа наверху (не на сайте, а внутри Swagger) */
        .stn-swagger-topbar {
            position: sticky;
            top: 0;
            z-index: 25;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 10px 18px;
            background: #0f172a;
            color: #fff;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .05);
        }
        .stn-swagger-topbar .brand {
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; font-weight: 600; letter-spacing: .2px;
        }
        .stn-swagger-topbar .brand .dot {
            width: 10px; height: 10px; border-radius: 50%; background: var(--stn-orange);
        }
        .stn-swagger-topbar .switcher {
            display: flex; align-items: center; gap: 10px;
        }
        .stn-swagger-topbar .switcher .label {
            font-size: 12px; text-transform: uppercase; letter-spacing: .6px; opacity: .65;
        }
        .stn-swagger-topbar select {
            background: #1e293b;
            color: #fff;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 7px 12px;
            font-size: 14px;
            cursor: pointer;
            outline: none;
        }
        .stn-swagger-topbar select:focus { border-color: var(--stn-orange); }

        #swagger-ui { max-width: 1200px; margin: 0 auto; padding: 8px 16px 80px; }
        /* Акцент заголовка спецификации в цвет STN */
        #swagger-ui .topbar { display: none; }
        #swagger-ui .info .title small { background: var(--stn-orange); }
    </style>
</head>
<body>

<div class="stn-swagger-topbar">
    <div class="brand">
        <span class="dot"></span>
        <span>Документация API</span>
    </div>

    {{-- Селектор тем API — справа наверху --}}
    <div class="switcher">
        <span class="label">Тема / API</span>
        <select id="stn-theme-select">
            @foreach($themes as $key => $theme)
                <option value="{{ $key }}" @selected($key === (string) $active)>{{ $theme['title'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<div id="swagger-ui"></div>

<script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
<script>
    // Карта тем: ключ => url спецификации
    const SPECS = @json(array_map(fn ($t) => $t['url'], $themes));
    const DEFAULT_THEME = @json($active);

    let bundle = null;

    function render(theme) {
        const url = SPECS[theme] || SPECS[DEFAULT_THEME];
        if (bundle) { bundle.destroy(); }
        bundle = SwaggerUIBundle({
            url: url,
            dom_id: '#swagger-ui',
            deepLinking: true,
            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIBundle.SwaggerUIStandalonePreset,
            ],
            layout: 'BaseLayout',
            withCredentials: true,
        });
    }

    render(window.location.search.includes('theme=' + DEFAULT_THEME) ? DEFAULT_THEME : DEFAULT_THEME);

    document.getElementById('stn-theme-select').addEventListener('change', (e) => {
        render(e.target.value);
        history.replaceState(null, '', '?theme=' + encodeURIComponent(e.target.value));
    });
</script>

</body>
</html>
