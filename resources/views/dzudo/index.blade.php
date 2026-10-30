<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f3ed">
    <meta name="description" content="Детское дзюдо в Тюмени: первые тренировки, пояса, соревнования и поддержка команды. Оставьте номер — расскажем о записи.">
    <title>Детское дзюдо в Тюмени — ЦентрДзюдо.рф</title>
    <link rel="stylesheet" href="/dzudo/site.css?v={{ filemtime(public_path('dzudo/site.css')) }}">
    <script src="/dzudo/site.js?v={{ filemtime(public_path('dzudo/site.js')) }}" defer></script>
</head>
<body>
<div class="announcement"><span class="announcement-dot"></span> ДЕТСКОЕ ДЗЮДО В ТЮМЕНИ <span class="announcement-city">ПЕРВЫЙ ШАГ МОЖНО СДЕЛАТЬ СЕГОДНЯ</span></div>
<header class="site-header wrap">
    <a class="brand" href="#top" aria-label="Центр дзюдо — на главную"><span class="brand-mark">柔</span><span>Центр<span class="brand-red">Дзюдо</span><small>ТЮМЕНЬ · СИЛА ХАРАКТЕРА</small></span></a>
    <nav class="main-nav" aria-label="Основная навигация"><a href="#path">Обучение</a><a href="#events">События</a><a href="#about">О центре</a></nav>
    <a class="header-cta" href="tel:+79324822289">8-932-482-22-89 <span>↗</span></a>
</header>
<main id="top">
    <section class="hero wrap">
        <div class="hero-photo" aria-hidden="true"></div>
        <div class="hero-content">
            <span class="eyebrow"><i></i> СИЛА РАСТЁТ С ПЕРВОГО ШАГА</span>
            <h1>Дзюдо, которое<br>помогает детям<br><em>верить в себя.</em></h1>
            <p class="hero-copy">Путь от первых шагов на татами до поясов, соревнований и новых целей. Тренировки для детей в Тюмени — с поддержкой тренера и команды.</p>
            <div class="hero-reasons"><span>Постепенное обучение</span><span>Пояса и турниры</span><span>Команда рядом</span></div>
        </div>
        <div class="hero-form-card" id="signup">
            <span class="form-kicker">ПЕРВЫЙ ШАГ</span>
            <h2>Запишите ребёнка<br>на знакомство</h2>
            <p>Оставьте номер — расскажем, как проходят занятия и с чего начать.</p>
            @include('dzudo.partials.application-form', ['source' => 'hero', 'button' => 'Узнать о записи'])
            <small class="form-reassurance">Без оплаты и обязательств · Просто ответим на вопросы</small>
        </div>
        <div class="hero-side-label">JUDO · TYUMEN</div>
    </section>

    <div class="trust-strip wrap"><div><b>01</b><span>Навыки шаг за шагом</span></div><div><b>02</b><span>Пояса за знания и старание</span></div><div><b>03</b><span>Турниры и поддержка команды</span></div></div>

    <section class="path-section section wrap" id="path">
        <div class="section-heading"><div><span class="eyebrow dark">01 / ПОНЯТНЫЙ ПУТЬ</span><h2>От первого поклона<br><em>к своим победам.</em></h2></div><p>Ребёнок осваивает дзюдо постепенно: сначала привыкает к татами и учится основам, затем развивает технику, проходит аттестации и пробует силы на соревнованиях.</p></div>
        <div class="path-grid">
            <article class="path-card"><span class="path-index">01</span><div class="belt belt-white"></div><small>ЗНАКОМСТВО</small><h3>Первые занятия</h3><p>Движение, координация, правила татами и безопасные падения — знакомимся с основой дзюдо.</p></article>
            <article class="path-card"><span class="path-index">02</span><div class="belt belt-yellow"></div><small>ОСНОВА</small><h3>Новые навыки</h3><p>Ребёнок осваивает приёмы, становится увереннее и готовится к аттестациям на пояса.</p></article>
            <article class="path-card featured"><span class="path-index">03</span><div class="belt belt-blue"></div><small>КОМАНДА</small><h3>Первые старты</h3><p>Учебные схватки и соревнования помогают применить навыки и достойно пережить любой результат.</p></article>
            <article class="path-card"><span class="path-index">04</span><div class="belt belt-black"></div><small>РОСТ</small><h3>Новые вершины</h3><p>Регулярная практика, следующий пояс и личные цели — свой темп и своя история успеха.</p></article>
        </div>
        <div class="path-footnote"><span>*</span> Пояса и участие в соревнованиях — по возрасту, подготовке и правилам аттестации.</div>
    </section>

    <section class="about-band" id="about"><div class="wrap about-layout"><div><span class="eyebrow">02 / ЧЕМ ПОЛЕЗНО ДЗЮДО</span><h2>Сильнее тело.<br><em>Спокойнее характер.</em></h2></div><div class="about-copy"><p>На татами дети учатся не только приёмам. Они привыкают слушать партнёра, соблюдать правила и подниматься после неудачи.</p><ul><li><span>✓</span> Уверенность в движениях и своих решениях</li><li><span>✓</span> Дисциплина, уважение и выдержка</li><li><span>✓</span> Радость от личного прогресса и командных побед</li></ul></div></div></section>

    <section class="events-section section wrap" id="events">
        <div class="events-intro"><span class="eyebrow dark">03 / СПОРТ ВМЕСТЕ</span><h2>Боевой дух<br><em>за пределами татами.</em></h2><p>Мероприятия помогают ребятам дружить, поддерживать друг друга и с интересом возвращаться к тренировкам.</p><a href="#signup-bottom" class="text-link">Спросить о занятиях <span>↗</span></a></div>
        <div class="event-list"><article class="event-item"><div class="event-number">A</div><div><h3>Учебные схватки</h3><p>Практика в знакомой обстановке и опыт партнёрской работы.</p></div><span>ПРАКТИКА</span></article><article class="event-item"><div class="event-number">B</div><div><h3>Соревнования и фестивали</h3><p>Новые впечатления, честное соперничество и общая поддержка.</p></div><span>СТАРТЫ</span></article><article class="event-item"><div class="event-number">C</div><div><h3>Командные встречи</h3><p>Игры, спортивные праздники и события для всего клуба.</p></div><span>КОМАНДА</span></article></div>
    </section>

    <section class="closing-cta" id="signup-bottom"><div class="wrap closing-layout"><div><span class="eyebrow">СЛЕДУЮЩИЙ ШАГ — ЗА ВАМИ</span><h2>Оставьте номер.<br><em>Подскажем, с чего начать.</em></h2><p>Расскажем о записи, первом занятии и ответим на вопросы родителей.</p><a class="direct-phone" href="tel:+79324822289">Можно позвонить: <b>8-932-482-22-89</b></a></div><div class="closing-form-card"><h3>Пусть центр свяжется с вами</h3><p>Укажите номер телефона — мы позвоним и расскажем подробнее.</p>
            @include('dzudo.partials.application-form', ['source' => 'closing', 'button' => 'Жду звонка'])
        </div></div></section>
</main>
<footer class="site-footer wrap"><a class="brand footer-brand" href="#top"><span class="brand-mark">柔</span><span>Центр<span class="brand-red">Дзюдо</span><small>ТЮМЕНЬ · СИЛА ХАРАКТЕРА</small></span></a><div class="footer-contact"><span>Запись и вопросы</span><a href="tel:+79324822289">8-932-482-22-89</a></div><a class="creator" href="https://php-cat.com" target="_blank" rel="noopener noreferrer">Создание сайта — <b>php-cat.com</b> <span>↗</span></a></footer>
<details class="privacy-note wrap" id="privacy-note"><summary>Как обрабатывается номер телефона</summary><p>Номер используется только для ответа на заявку о занятиях, хранится в зашифрованном виде и передаётся администратору центра для связи с вами. В заявке не нужно указывать иные персональные данные. Для отзыва согласия и удаления номера позвоните по телефону 8-932-482-22-89.</p></details>
<aside class="dev-notice" id="dev-notice" aria-label="Сайт находится в разработке"><div class="dev-label"><span class="dev-dot"></span> СЕЙЧАС В РАЗРАБОТКЕ</div><p>Этот сайт можно<br><em>взять в аренду.</em></p><div class="dev-max"><span>Напишите мне в МАКС</span> <strong>8-922-262-22-89</strong></div><button type="button" id="dev-notice-close" aria-label="Свернуть объявление" aria-expanded="true">×</button></aside>
</body>
</html>
