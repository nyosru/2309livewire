<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="РААЛ — Работа Алгоритмов. Проверяем идеи, запускаем проекты и превращаем работающий бизнес в управляемый актив.">
    <meta name="theme-color" content="#171914">
    <meta property="og:type" content="website">
    <meta property="og:title" content="РААЛ — Работа Алгоритмов">
    <meta property="og:description" content="Инвестиции в новые и работающие проекты. Из идеи — в управляемый бизнес.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ url('/images/raal/vk-link-preview.png') }}">
    <meta property="og:image:width" content="1733">
    <meta property="og:image:height" content="908">
    <meta property="og:image:alt" content="РААЛ — инвестиции в новые и работающие проекты">
    <title>РААЛ — Работа Алгоритмов</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Unbounded:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/raal.css">
    @livewireStyles
</head>
<body>
<header class="site-header">
    <x-raal.logo />
    <nav class="main-nav" aria-label="Основная навигация">
        <a href="#approach">Как работаем</a>
        <a href="#projects">Проекты</a>
        <a href="#contact">Контакты</a>
    </nav>
    <button class="header-action js-open-modal" type="button">Разобрать проект <span>↗</span></button>
</header>

<main id="top">
    <section class="hero">
{{--        <div class="hero-kicker reveal"><span></span> раал.рф — Работа Алгоритмов</div>--}}

        <div class="hero-grid">
            <div class="hero-copy reveal">
                <h1>Из идеи —<br>в&nbsp;управляемый <em>бизнес</em></h1>
                <p>Проверяем спрос и&nbsp;цифры до вложений. Затем запускаем, измеряем результат и&nbsp;развиваем то, что действительно работает.</p>
                <div class="hero-actions">
                    <button class="button button-primary js-open-modal" type="button">Разобрать вашу идею <span>↗</span></button>
                    <a class="text-link" href="#projects">Посмотреть, что уже работает <span>↓</span></a>
                </div>
            </div>
            <aside class="hero-card reveal" aria-label="Наш принцип">
                <div class="hero-card-top">
                    <span>01</span>
                    <span class="orbit" aria-hidden="true"></span>
                </div>
                <p>Сначала —<br>цифры. Потом — вложения.</p>
                <div class="hero-card-bottom">
                    <span>План</span><i></i><span>Действие</span><i></i><span>Результат</span>
                </div>
            </aside>
        </div>




    </section>

    <div class="hero-marquee" aria-hidden="true" style="color: black; margin-top:-15px;">
        <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
        <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
    </div>

    <section class="approach section" id="approach">

        <div class="section-heading reveal">
            <span class="eyebrow">/ Подход</span>
            <h2>От гипотезы —<br>к&nbsp;<em>доходному активу</em></h2>
            <p>Инвестируем не вслепую: у&nbsp;каждого этапа есть цель, ответственный и&nbsp;измеримый результат. Прогресс проекта виден всем участникам.</p>
        </div>
        <div class="route-list">
            <article class="route-item reveal">
                <span class="route-number">01</span>
                <div><h3>Проверяем</h3><p>Отвечаем на главный вопрос: кому и&nbsp;зачем нужен продукт. Оцениваем спрос, ресурсы, риски и&nbsp;экономику до вложений.</p></div>
                <span class="route-icon">⌁</span>
            </article>
            <article class="route-item reveal">
                <span class="route-number">02</span>
                <div><h3>Запускаем</h3><p>Делаем минимальную рабочую версию, получаем обратную связь и&nbsp;первые продажи — без преждевременных больших расходов.</p></div>
                <span class="route-icon">↗</span>
            </article>
            <article class="route-item reveal">
                <span class="route-number">03</span>
                <div><h3>Улучшаем точки контакта</h3><p>Оцифровываем процессы в&nbsp;CRM «ПроцессМастер», измеряем результат и&nbsp;улучшаем каждый контакт клиента с&nbsp;бизнесом.</p></div>
                <span class="route-icon">＋</span>
            </article>
            <article class="route-item reveal">
                <span class="route-number">04</span>
                <div><h3>Масштабируем результат</h3><p>Усиливаем прибыль работающего бизнеса, упаковываем франшизу или готовим понятный и&nbsp;управляемый актив к&nbsp;продаже.</p></div>
                <span class="route-icon">₽</span>
            </article>
        </div>



    </section>


    <div class="hero-marquee" aria-hidden="true" style="color: black; margin-top:-15px;">
        <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
        <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
    </div>


    <livewire:raal.projects />


    <div class="hero-marquee" aria-hidden="true" style="color: black; margin-bottom:15px;">
        <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
        <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
    </div>


    <section class="crm-callout section reveal">
        <div class="crm-symbol" aria-hidden="true"><span>●</span><span>●</span><span>●</span></div>
        <div><span class="eyebrow">/ Управление без хаоса</span><h2>Ведём каждый проект<br>в&nbsp;<em>ПроцессМастере</em></h2></div>
        <div class="crm-copy"><p>Это одна из ключевых точек контакта с&nbsp;инвестором: планы, договорённости, цифры и&nbsp;история решений всегда перед глазами.</p><a href="https://процессмастер.рф" target="_blank" rel="noopener">Посмотреть, как это работает <span>↗</span></a></div>
    </section>

    <section class="contact section" id="contact">
        <div class="contact-copy reveal">
            <span class="eyebrow">/ Давайте знакомиться</span>
            <h2>Есть идея<br>или ресурс?</h2>
            <p>На первой встрече определим сильные стороны проекта, ближайший разумный шаг и&nbsp;формат участия — без обязательств с&nbsp;вашей стороны.</p>
        </div>
        <div class="contact-action reveal">
            <button class="circle-button js-open-modal" type="button"><span>Разобрать<br>идею</span><b>↗</b></button>
            <p>Коротко и&nbsp;по делу:<br>цель, цифры, следующий шаг.</p>
        </div>


    </section>
</main>


<div class="hero-marquee" aria-hidden="true" style="color: black; margin-top:-15px;">
    <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
    <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
</div>


<footer>
    <x-raal.logo footer />
    <p>© {{ date('Y') }} РААЛ. Информация на сайте не является публичной офертой.</p>
    <a href="https://php-cat.com" target="_blank" rel="noopener">Создание сайта — php-cat.com ↗</a>
</footer>

<dialog class="consultation-modal" id="consultationModal" aria-labelledby="modalTitle">
    <button class="modal-close" type="button" aria-label="Закрыть">×</button>
    <div class="modal-step modal-form-step">
        <span class="eyebrow">/ Личная консультация</span>
        <h2 id="modalTitle">Разберём вашу идею по делу</h2>
        <p>Оставьте контакты и&nbsp;удобное время. На встрече определим потенциал проекта и&nbsp;ближайший разумный шаг.</p>
        <form action="{{ route('raal.consultation') }}" method="post" id="consultationForm">
            @csrf
            <input type="hidden" name="project" id="projectField">
            <label><span>Телефон</span><input type="tel" name="phone" autocomplete="tel" placeholder="+7 999 000-00-00" required></label>
            <label><span>Город</span><input type="text" name="city" autocomplete="address-level2" placeholder="Например, Тюмень" required></label>
            <label class="wide"><span>Когда удобно созвониться или встретиться?</span><textarea name="preferred_time" rows="3" placeholder="Например: в будни после 16:00, лучше созвониться" required></textarea></label>
            <label class="honeypot" aria-hidden="true">Сайт<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            <button class="button button-primary wide" type="submit">Договориться о&nbsp;встрече <span>↗</span></button>
            <p class="wide" id="consultationSubmitError" role="alert" hidden>Не получилось отправить заявку. Пожалуйста, попробуйте ещё раз.</p>
            <small class="wide">Нажимая кнопку, вы соглашаетесь на обработку указанных данных для связи с&nbsp;вами.</small>
        </form>
    </div>
    <div class="modal-step modal-success" hidden>
        <span class="success-mark">✓</span>
        <h2>Заявка принята</h2>
        <p>Свяжемся с&nbsp;вами и&nbsp;подтвердим удобное время.</p>
        <button class="button button-dark modal-done" type="button">Хорошо</button>
    </div>
</dialog>

@livewireScripts
<script src="/js/raal.js" defer></script>
</body>
</html>
