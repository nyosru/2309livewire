<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Сергей Бакланов — гипнолог, Тюмень и онлайн</title>
    <meta name="description"
          content="Гипнолог Сергей Бакланов. Индивидуальная работа со страхами, тревогой, стрессом, самооценкой и психосоматическими запросами. Бесплатная консультация.">
    <meta name="theme-color" content="#111a1a">
    <link rel="stylesheet" href="/boba/site.css">
{{--    <link rel="stylesheet" href="/css/output.css?v=1" />--}}
    <script src="/boba/site.js" defer></script>
</head>
<body>
<header class="topbar wrap">
    <a class="brand" href="#top" aria-label="боба.рф — гипнолог Сергей Бакланов"><span class="brand-oval">боба.рф</span><span
            class="brand-copy"><strong>Сергей Бакланов</strong><small>гипнолог</small></span></a>
    <nav aria-label="Основная навигация"><a href="#services">Направления</a><a href="#approach">Как проходит
            работа</a></nav>
    <button class="button button-small" type="button" data-consult="Бесплатная консультация">Записаться <span>↗</span>
    </button>
</header>

<main id="top">
    @if(session('boba_sent'))
        <div class="notice success" role="status">Спасибо! Заявка отправлена. Я свяжусь с вами по указанному номеру.
        </div>
    @elseif(session('boba_error'))
        <div class="notice error" role="alert">{{ session('boba_error') }}</div>
    @endif

    <section class="hero wrap">
        <div class="hero-copy">
            <p class="eyebrow"><span class="eyebrow-line"></span> ИНДИВИДУАЛЬНАЯ РАБОТА · ОНЛАЙН И ОЧНО</p>
            <h1>Меняться<br>можно <em>бережно.</em></h1>
            <p class="hero-lead">Помогаю разобраться с внутренним напряжением и найти новый способ справляться с тем,
                что мешает жить свободнее.</p>
            <div class="hero-actions">
                <button class="button" type="button" data-consult="Бесплатная консультация">Бесплатная консультация
                    <span>↗</span></button>
                <a class="under-link" href="#services">Посмотреть направления <span>↓</span></a></div>
            <p class="hero-footnote">Сначала обсудим ваш запрос — без обязательств и обещаний результата.</p>
        </div>
        <div class="hero-art" aria-label="Абстрактная иллюстрация спокойного внутреннего пространства" role="img">
            <div class="orb orb-one"></div>
            <div class="orb orb-two"></div>
            <div class="orbit orbit-one"></div>
            <div class="orbit orbit-two"></div>
            <div class="art-note"><span
                    class="art-note-dot"></span><span>Внимание к вашему<br><strong>опыту и темпу</strong></span></div>
            <div class="art-index">01 <span>—</span> 04</div>
        </div>
    </section>

    <div class="ticker" aria-hidden="true">
        <span>ВНИМАНИЕ К СЕБЕ</span><b>✳</b><span>БЕРЕЖНЫЙ ДИАЛОГ</span><b>✳</b><span>ВАШ ТЕМП</span><b>✳</b><span>НОВЫЙ ВЗГЛЯД</span><b>✳</b>
    </div>

    <section class="section wrap" id="services">
        <div class="section-head">
            <div><p class="eyebrow">С ЧЕМ МОЖНО ОБРАТИТЬСЯ</p>
                <h2>Направления<br><em>работы</em></h2></div>
            <p class="section-intro">Каждая история индивидуальна. На бесплатной консультации мы уточним, подходит ли
                гипнотерапевтическая работа под ваш запрос.</p></div>
        <div class="service-grid">
            <article class="service-card"><span class="card-number">01</span><span class="card-icon">↗</span>
                <h3>Страхи и фобии</h3>
                <p>Страх общения и знакомств, публичных выступлений, осуждения, темноты, поездок и другие ситуации,
                    вызывающие сильное напряжение.</p>
                <button class="card-link" type="button" data-consult="Страхи и фобии">Бесплатная консультация
                    <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">02</span><span class="card-icon">◌</span>
                <h3>Тревога и стресс</h3>
                <p>Тревожность, хронический стресс, усталость, внутреннее беспокойство и трудности с расслаблением.</p>
                <button class="card-link" type="button" data-consult="Тревога и стресс">Бесплатная консультация
                    <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">03</span><span class="card-icon">✳</span>
                <h3>Эмоции и напряжение</h3>
                <p>Эмоциональная скованность, телесные зажимы, раздражение, злость и чувства, которым трудно найти
                    выход.</p>
                <button class="card-link" type="button" data-consult="Эмоции и напряжение">Бесплатная консультация
                    <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">04</span><span class="card-icon">⌁</span>
                <h3>Самооценка и личные стратегии</h3>
                <p>Неуверенность, самокритика, повторяющиеся способы действовать и сложности в отношениях с собой и
                    окружающими.</p>
                <button class="card-link" type="button" data-consult="Самооценка и личные стратегии">Бесплатная
                    консультация <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">05</span><span class="card-icon">◎</span>
                <h3>Психосоматические запросы</h3>
                <p>Телесный дискомфорт, аллергические реакции и трудности сексуального характера, если они связаны с
                    эмоциональным напряжением. Не заменяет диагностику и лечение у врача.</p>
                <button class="card-link" type="button" data-consult="Психосоматические запросы">Бесплатная консультация
                    <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">06</span><span class="card-icon">↝</span>
                <h3>Потери и незавершённые истории</h3>
                <p>Тяжёлое переживание расставания, обиды, воспоминания и повторяющиеся мысли, от которых сложно
                    переключиться.</p>
                <button class="card-link" type="button" data-consult="Потери и незавершённые истории">Бесплатная
                    консультация <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">07</span><span class="card-icon">⌘</span>
                <h3>Навязчивые мысли и действия</h3>
                <p>Повторяющиеся мысли и действия, трудности речи, в том числе заикание. Обсудим влияние на жизнь и
                    подходящий формат помощи.</p>
                <button class="card-link" type="button" data-consult="Навязчивые мысли и действия">Бесплатная
                    консультация <span>↗</span></button>
            </article>
            <article class="service-card"><span class="card-number">08</span><span class="card-icon">✧</span>
                <h3>Личный и бизнес-коучинг</h3>
                <p>Ограничивающие сценарии, трудности с целями, решениями, уверенностью и балансом между работой и
                    личной жизнью.</p>
                <button class="card-link" type="button" data-consult="Личный и бизнес-коучинг">Бесплатная консультация
                    <span>↗</span></button>
            </article>
        </div>
        <p class="scope-note">Я не работаю с психическими расстройствами, зависимостями и семейной терапией.
            Гипнотерапия не заменяет помощь врача или психотерапевта. Если вы уже наблюдаетесь у специалиста, сообщите
            об этом на консультации.</p>
    </section>

    <section class="approach" id="approach">
        <div class="wrap approach-inner">
            <div><p class="eyebrow">ПОНЯТНЫЙ ПЕРВЫЙ ШАГ</p>
                <h2>Как проходит<br><em>знакомство</em></h2>
                <p class="approach-copy">Бесплатная консультация нужна, чтобы спокойно описать ситуацию, задать вопросы
                    и понять, подойдёт ли вам такой формат работы.</p>
                <button class="button" type="button" data-consult="Бесплатная консультация">Обсудить мой запрос
                    <span>↗</span></button>
            </div>
            <ol class="steps">
                <li><span>01</span>
                    <div><h3>Вы оставляете заявку</h3>
                        <p>Телефон и несколько слов о том, что вас беспокоит.</p></div>
                </li>
                <li><span>02</span>
                    <div><h3>Я связываюсь с вами</h3>
                        <p>Уточним удобное время и формат — онлайн или очно.</p></div>
                </li>
                <li><span>03</span>
                    <div><h3>Обсуждаем ситуацию</h3>
                        <p>Вы задаёте вопросы, а мы определяем следующий шаг без обязательств.</p></div>
                </li>
            </ol>
        </div>
    </section>

</main>

<x-boba.footer />

<dialog class="consult-dialog" id="consult-dialog" aria-labelledby="dialog-title">
    <div class="dialog-heading">
        <div><p class="eyebrow">БЕСПЛАТНО И БЕЗ ОБЯЗАТЕЛЬСТВ</p>
            <h2 id="dialog-title">Расскажите<br><em>о запросе</em></h2></div>
        <button class="close-button" type="button" data-close aria-label="Закрыть форму">×</button>
    </div>
    <p class="dialog-intro">Оставьте номер и коротко опишите ситуацию. Я свяжусь с вами лично.</p>
    <form method="post" action="{{ url('/consultation') }}" id="consult-form">
        @csrf
        <input type="hidden" name="service" id="service-input" value="Бесплатная консультация">
        <label>Телефон<input name="phone" type="tel" inputmode="tel" autocomplete="tel" required maxlength="22"
                             placeholder="+7 (___) ___-__-__" pattern="[+0-9()\s-]{10,22}"></label>
        <label>Кратко о вашем запросе<textarea name="request" rows="3" required minlength="10" maxlength="2000"
                                               placeholder="Что хотелось бы изменить или обсудить?"></textarea></label>
        <label class="check-row"><input type="checkbox" name="consent" value="1" required><span>Согласен(на), чтобы Сергей связался со мной по этой заявке. Номер и описание запроса будут переданы в рабочий аккаунт ВКонтакте для обработки заявки.</span></label>
        <div class="discount-option"><label class="check-row"><input type="checkbox" name="discount" value="1"
                                                                     id="discount-check"><span>Хочу участвовать в еженедельном розыгрыше скидки 50%.</span></label>
            <p>Если вы участвуете, для участия потребуется разрешить видеозапись встречи и её использование для показа и
                просмотра.</p><label class="check-row video-consent" hidden><input type="checkbox" name="video_consent"
                                                                                   value="1" id="video-consent"><span>Разрешаю видеозапись встречи и её использование для показа и просмотра.</span></label>
        </div>
        <label class="honeypot" aria-hidden="true">Сайт<input name="website" tabindex="-1" autocomplete="off"></label>
        @if($errors->any())
            <div class="form-errors" role="alert">@foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach</div>
        @endif
        <button class="button submit-button" type="submit">Отправить заявку <span>↗</span></button>
        <small class="form-note">Нажимая «Отправить», вы соглашаетесь на использование данных только для ответа на эту
            заявку.</small>
    </form>
</dialog>
@if($errors->any())
    <script>window.addEventListener('DOMContentLoaded', () => document.querySelector('#consult-dialog').showModal());</script>
@endif
</body>
</html>
