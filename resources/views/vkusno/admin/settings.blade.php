@extends('vkusno.admin.layout')
@section('title', 'Настройки сайта')
@section('content')
<h1>Настройки сайта</h1>
<form method="post" action="/admin/settings" class="admin-form">
    @csrf @method('PUT')
    <section class="admin-card">
        <h2>Контакты кафе</h2>
        <div class="admin-grid">
            <label>Телефон<input name="phone" type="tel" maxlength="50" value="{{ old('phone', $settings['phone']) }}"></label>
            <label>Адрес<input name="address" maxlength="500" required value="{{ old('address', $settings['address']) }}"></label>
            <label>Часы работы<input name="hours" maxlength="200" required value="{{ old('hours', $settings['hours']) }}"></label>
            <label>Часовой пояс<select name="timezone">@foreach(timezone_identifiers_list() as $timezone)<option value="{{ $timezone }}" @selected(old('timezone', $settings['timezone']) === $timezone)>{{ $timezone }}</option>@endforeach</select></label>
            <label>Ссылка на карту<input name="map_url" type="url" maxlength="2048" value="{{ old('map_url', $settings['map_url']) }}"></label>
            <label>Как добраться<input name="directions_url" type="url" maxlength="2048" value="{{ old('directions_url', $settings['directions_url']) }}"></label>
            <label>Ссылка на фотографии<input name="photos_url" type="url" maxlength="2048" value="{{ old('photos_url', $settings['photos_url']) }}"></label>
            <label>Количество мест<input name="seats" type="number" min="1" max="10000" required value="{{ old('seats', $settings['seats']) }}"></label>
        </div>
    </section>
    <section class="admin-card">
        <h2>Заказы и доставка</h2>
        <div class="admin-grid">
            <label>Доставка, ₽<input name="delivery_fee" type="number" min="0" max="100000" value="{{ old('delivery_fee', $settings['delivery_fee']) }}"><small class="admin-muted">Оставьте пустым, если стоимость нужно уточнять. 0 — бесплатная доставка.</small></label>
            <label>За сколько дней заказывать торт<input name="cake_lead_days" type="number" min="0" max="365" required value="{{ old('cake_lead_days', $settings['cake_lead_days']) }}"></label>
            <label>Предупреждение о предварительном меню<select name="demo_menu"><option value="1" @selected((string) old('demo_menu', (int) $settings['demo_menu']) === '1')>Показывать</option><option value="0" @selected((string) old('demo_menu', (int) $settings['demo_menu']) === '0')>Скрывать</option></select></label>
        </div>
        <label>Начинки тортов<textarea name="fillings_text" rows="6" maxlength="5000" required>{{ old('fillings_text', implode("\n", $settings['fillings'])) }}</textarea><small class="admin-muted">Каждую начинку укажите с новой строки.</small></label>
    </section>
    <section class="admin-card">
        <h2>Бот MAX</h2>
        <p class="admin-muted">Общий бот для сайтов и проектов на сервере. Изменение этих настроек действует для всех его подключений.</p>
        <div class="admin-grid">
            <label>Имя бота<input name="max_bot_username" maxlength="100" placeholder="se14535801_bot" value="{{ old('max_bot_username', $bot['bot_username']) }}"><small class="admin-muted">Без @ и https://max.ru/. Используется для ссылки и QR-кода.</small></label>
            <label>Вход через MAX<select name="max_auth_driver"><option value="disabled" @selected(old('max_auth_driver', $bot['auth_driver']) === 'disabled')>Выключен</option><option value="bot" @selected(old('max_auth_driver', $bot['auth_driver']) === 'bot')>Включён</option></select></label>
            <label>Новый токен бота<input name="max_bot_token" type="password" autocomplete="new-password" maxlength="1024"><small class="admin-muted">{{ $tokenConfigured ? 'Токен сохранён. Оставьте поле пустым, чтобы сохранить его.' : 'Токен пока не задан.' }}</small></label>
            <label>Новый секрет подключения<input name="max_webhook_secret" type="password" autocomplete="new-password" maxlength="256"><small class="admin-muted">{{ $secretConfigured ? 'Секрет сохранён. Пустое поле оставляет его без изменений.' : 'Секрет пока не задан.' }}</small></label>
        </div>
        <label>Адрес получения событий MAX<input name="max_webhook_url" type="url" maxlength="2048" value="{{ old('max_webhook_url', $bot['webhook_url']) }}" placeholder="https://ваш-сайт/api/max/webhook"><small class="admin-muted">Если меняете адрес или секрет, потребуется переподключить доставку событий бота.</small></label>
    </section>
    <button class="admin-button" type="submit">Сохранить настройки</button>
</form>
@endsection
