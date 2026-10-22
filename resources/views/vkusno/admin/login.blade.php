@extends('vkusno.admin.layout')
@section('title', 'Вход в панель')
@section('content')
<section class="admin-card admin-login">
    <p class="eyebrow">ВКУСНЯЖКИ72</p>
    <h1>Управление кафе</h1>
    <p>Товары, категории меню и полученные заказы — в одном месте.</p>
    @auth
        <div class="admin-errors">У вашего аккаунта пока нет доступа к панели. Попросите суперадминистратора разрешить вход через VK или MAX. @if(auth()->user()->vk_id)Ваш VK ID: <strong>{{ auth()->user()->vk_id }}</strong>.@endif</div>
        <form method="post" action="/admin/logout">@csrf<button class="admin-button" type="submit">Выйти и сменить аккаунт</button></form>
    @else
        <section class="admin-login-method" aria-labelledby="max-login-heading">
            <h2 id="max-login-heading">Вход через MAX</h2>
            @if($maxBotUrl)
                <div class="admin-max-bot-notice">
                    <p><strong>Перед первым входом зайдите в бота MAX, нажмите «Начать», затем «Поделиться телефоном».</strong> Отсканируйте QR-код или нажмите на него, чтобы открыть бота. После подтверждения телефона вернитесь сюда и запросите код — он придёт в этот чат.</p>
                    <a class="admin-max-bot-qr" href="{{ $maxBotUrl }}" target="_blank" rel="noopener" aria-label="Открыть бота MAX в новой вкладке">
                        <img src="{{ $maxBotQr }}" width="180" height="180" alt="QR-код для перехода в бота MAX">
                        <span>Открыть бота MAX ↗</span>
                    </a>
                </div>
            @endif
            <p>Введите телефон и получите одноразовый код в MAX. Аккаунт ВКонтакте не нужен.</p>
            @if(!$maxReady)<p class="admin-muted">Вход через MAX пока не подключён. Обратитесь к администратору.</p>@endif
            @if(session('vkusno_max_challenge') && $maxReady)
                <p>Введите код для {{ session('vkusno_max_challenge.masked_phone') }}. Он действует 5 минут.</p>
                <form class="admin-form" method="post" action="/admin/auth/max/verify">
                    @csrf
                    <label>Одноразовый код<input name="max_code" type="text" inputmode="numeric" autocomplete="one-time-code" pattern="[0-9]{6}" minlength="6" maxlength="6" placeholder="000000" required autofocus></label>
                    <button class="admin-button admin-max" type="submit">Войти</button>
                </form>
                <div class="admin-actions">
                    <form method="post" action="/admin/auth/max/request">@csrf<input type="hidden" name="phone" value="{{ session('vkusno_max_challenge.phone') }}"><button class="admin-button admin-button-secondary" type="submit">Отправить повторно</button></form>
                    <form method="post" action="/admin/auth/max/reset">@csrf<button class="admin-button admin-button-secondary" type="submit">Изменить номер</button></form>
                </div>
            @else
                <form class="admin-form" method="post" action="/admin/auth/max/request">
                    @csrf
                    <label>Номер телефона<input name="phone" type="tel" autocomplete="tel" value="{{ old('phone') }}" placeholder="+7 (___) ___-__-__" maxlength="32" required @disabled(!$maxReady)></label>
                    <button class="admin-button admin-max" type="submit" @disabled(!$maxReady)>Зайти</button>
                </form>
            @endif
            @if($maxBotUrl)<p class="admin-muted">Для получения доступа передайте суперадминистратору только свой телефон. Вводить MAX ID не нужно.</p>@endif
        </section>
        <section class="admin-login-method" aria-labelledby="vk-login-heading"><h2 id="vk-login-heading">Вход через ВКонтакте</h2>
        <a class="admin-button admin-vk" href="/admin/auth/vk">Войти через ВКонтакте</a>
        <p class="admin-muted">Вход доступен суперадминистратору и аккаунтам, которым он выдал доступ.</p></section>
    @endauth
</section>
@endsection
