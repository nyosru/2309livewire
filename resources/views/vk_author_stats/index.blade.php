<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Видео и клипы — статистика VK</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f2f5f9;color:#18212b;font:16px/1.5 Arial,sans-serif}.wrap{max-width:1120px;margin:0 auto;padding:28px 18px 54px}header{display:flex;justify-content:space-between;align-items:flex-start;gap:18px;flex-wrap:wrap;margin-bottom:22px}h1{font-size:30px;line-height:1.2;margin:3px 0 8px}.subtle{font-size:14px;color:#627386}.panel{background:white;border:1px solid #dce4ed;border-radius:15px;padding:20px;margin:16px 0}.toolbar{display:flex;align-items:end;gap:12px;flex-wrap:wrap}.toolbar label{display:block;font-weight:700;font-size:14px;margin-bottom:6px}.toolbar select,.button{min-height:44px;border:1px solid #cbd6e2;border-radius:9px;padding:9px 12px;font:inherit;background:#fff;color:#18212b}.button{display:inline-flex;align-items:center;justify-content:center;border:0;background:#0878f9;color:white;text-decoration:none;font-weight:700;cursor:pointer}.summary{display:flex;gap:12px;flex-wrap:wrap;margin:15px 0 0}.pill{border-radius:999px;background:#edf3fa;padding:7px 12px;font-size:14px}.alert{padding:12px 14px;border-radius:10px;background:#fff2dc;color:#714b00;margin:14px 0;font-size:15px}.section-title{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;margin:24px 0 10px}.section-title h2{font-size:22px;margin:0}.cards{display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:13px}.card{overflow:hidden;border:1px solid #dce4ed;border-radius:12px;background:white}.thumb{display:block;width:100%;aspect-ratio:16/9;object-fit:cover;background:#e8edf3}.card-body{padding:13px}.card-title{font-weight:700;color:#18212b;text-decoration:none;font-size:16px;line-height:1.4;display:block}.card-title:hover{color:#0868d7}.card-meta{display:flex;justify-content:space-between;gap:8px;align-items:center;margin-top:9px;color:#536579;font-size:14px}.views{font-weight:700;color:#18212b}.empty{text-align:center;padding:34px 16px;color:#536579}.empty strong{display:block;color:#18212b;font-size:18px;margin-bottom:5px}footer{text-align:center;margin-top:28px;font-size:14px}footer a{color:#536579}@media(max-width:600px){.wrap{padding:18px 12px 40px}h1{font-size:26px}.panel{padding:15px}.toolbar>*{width:100%}.toolbar select,.toolbar .button{width:100%}.cards{grid-template-columns:1fr}}
    </style>
</head>
<body>
<main class="wrap">
    <header>
        <div>
            <div class="subtle">Кабинет автора VK</div>
            <h1>Видео и клипы</h1>
            <div class="subtle">Текущие счётчики просмотров, сохранённые по дням</div>
        </div>
        @if($date->isSameDay($today))
            <a class="button" href="/?date={{ $today->toDateString() }}">Обновить страницу</a>
        @endif
    </header>

    <section class="panel">
        <form class="toolbar" method="get" action="/">
            <div>
                <label for="date">Дата снимка</label>
                <select id="date" name="date" onchange="this.form.submit()">
                    <option value="{{ $today->toDateString() }}" @selected($date->isSameDay($today))>Сегодня — {{ $today->format('d.m.Y') }}</option>
                    @foreach($availableDates as $availableDate)
                        @if($availableDate !== $today->toDateString())
                            <option value="{{ $availableDate }}" @selected($date->toDateString() === $availableDate)>{{ \Carbon\CarbonImmutable::parse($availableDate)->format('d.m.Y') }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <noscript><button class="button" type="submit">Показать</button></noscript>
        </form>
        <div class="summary">
            <span class="pill">Видео: {{ $videos->where('media_type', 'video')->count() }}</span>
            <span class="pill">Клипы: {{ $videos->where('media_type', 'clip')->count() }}</span>
            <span class="pill">Записей: {{ $videos->count() }}</span>
            @if($lastUpdated)
                <span class="pill">Снимок: {{ \Carbon\CarbonImmutable::parse($lastUpdated)->timezone(config('app.timezone'))->format('H:i') }}</span>
            @endif
        </div>
        @if($error)<div class="alert">{{ $error }}@if($videos->isNotEmpty()) Показаны сохранённые данные.@endif</div>@endif
    </section>

    @foreach(['video' => 'Видео', 'clip' => 'Клипы'] as $type => $label)
        @php($items = $videos->where('media_type', $type))
        <section>
            <div class="section-title"><h2>{{ $label }}</h2><span class="subtle">{{ $items->count() }} записей</span></div>
            @if($items->isEmpty())
                <div class="panel empty"><strong>Пока нет данных за этот день</strong>Откройте страницу сегодня после настройки ключа VK, чтобы сохранить первый снимок.</div>
            @else
                <div class="cards">
                    @foreach($items as $item)
                        <article class="card">
                            @if($item->thumbnail_url)<a href="{{ $item->video_url }}" target="_blank" rel="noopener"><img class="thumb" src="{{ $item->thumbnail_url }}" alt="" loading="lazy"></a>@endif
                            <div class="card-body">
                                <a class="card-title" href="{{ $item->video_url }}" target="_blank" rel="noopener">{{ $item->title }}</a>
                                <div class="card-meta">
                                    <span class="views">{{ number_format($item->views, 0, ',', ' ') }} просмотров</span>
                                    @if($item->published_at)<time datetime="{{ $item->published_at->toIso8601String() }}">{{ $item->published_at->timezone(config('app.timezone'))->format('d.m.Y') }}</time>@endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    @endforeach

    <footer><a href="https://php-cat.com">Создание сайта</a></footer>
</main>
</body>
</html>
