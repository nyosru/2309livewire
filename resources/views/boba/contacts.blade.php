<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Контакты — боба.рф</title>
    <meta name="description" content="Контакты Сергея Бакланова: электронная почта, телефон и форма сообщения.">
    <meta name="theme-color" content="#f5f6f1">
    <link rel="stylesheet" href="/boba/site.css">
</head>
<body>
<header class="topbar wrap">
    <a class="brand" href="/" aria-label="боба.рф — Сергей Бакланов">
        <span class="brand-oval">боба.рф</span>
        <span class="brand-copy"><strong>Сергей Бакланов</strong><small>психосоматика</small></span>
    </a>
    <a class="button button-small" href="/">На главную</a>
</header>

<main class="contact-page wrap">
    <p class="eyebrow"><span class="eyebrow-line"></span> СВЯЗЬ СО МНОЙ</p>
    <h1>Контакты</h1>
    <p class="contact-lead">Все вопросы пишите на указанную электронную почту либо отправляйте через форму на сайте. Сообщение из формы придёт мне в рабочий аккаунт ВКонтакте.</p>

    <div class="contact-methods">
        <a class="contact-method" href="mailto:boba@php-cat.ru"><span>Электронная почта</span><strong>boba@php-cat.ru</strong></a>
        <a class="contact-method" href="tel:+79324722289"><span>Телефон</span><strong>8-932-472-22-89</strong></a>
        <a class="contact-method" href="https://max.ru/" target="_blank" rel="noopener noreferrer"><span>Мессенджер</span><strong>Написать в MAX ↗</strong><small>В MAX найдите меня по номеру телефона.</small></a>
    </div>

    <section class="contact-form-card" aria-labelledby="contact-form-title">
        <h2 id="contact-form-title">Отправить сообщение</h2>
        <p>Оставьте контакт для ответа и напишите, что хотели бы обсудить.</p>
        @if(session('contact_sent'))
            <div class="contact-status" role="status">Сообщение отправлено. Я свяжусь с вами по указанным контактам.</div>
        @elseif(session('contact_error'))
            <div class="contact-status contact-status-error" role="alert">{{ session('contact_error') }}</div>
        @endif
        <form method="post" action="{{ url('/contacts') }}" class="contact-form">
            @csrf
            <label>Ваше имя <span class="contact-optional">необязательно</span><input name="name" type="text" autocomplete="name" maxlength="120" value="{{ old('name') }}"></label>
            <div class="contact-inputs">
                <label>Телефон <span class="contact-optional">если нет email</span><input name="phone" type="tel" inputmode="tel" autocomplete="tel" maxlength="30" value="{{ old('phone') }}" placeholder="8-932-472-22-89"></label>
                <label>Электронная почта <span class="contact-optional">если нет телефона</span><input name="email" type="email" autocomplete="email" maxlength="254" value="{{ old('email') }}" placeholder="name@example.ru"></label>
            </div>
            <label>Сообщение<textarea name="message" rows="5" required minlength="10" maxlength="3000" placeholder="Напишите ваш вопрос или сообщение">{{ old('message') }}</textarea></label>
            <label class="check-row contact-consent"><input type="checkbox" name="consent" value="1" required @checked(old('consent'))><span>Согласен(на), чтобы мои контактные данные и сообщение были переданы в рабочий аккаунт ВКонтакте для ответа на обращение.</span></label>
            <label class="honeypot" aria-hidden="true">Сайт<input name="website" tabindex="-1" autocomplete="off"></label>
            @if($errors->any())
                <div class="form-errors" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
            @endif
            <button class="button submit-button" type="submit">Отправить сообщение <span>↗</span></button>
            <small class="form-note">Контактные данные будут использованы, чтобы ответить на это сообщение.</small>
        </form>
    </section>
</main>

<x-boba.footer />
</body>
</html>
