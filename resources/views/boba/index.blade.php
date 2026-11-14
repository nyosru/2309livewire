<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>боба.рф — психосоматика Сергей Бакланов, Тюмень и онлайн</title>
    <meta name="description" content="Страх общения, выступлений или конкретных ситуаций, неуверенность и привычки, мешающие продуктивности? Обсудите с психосоматиком Сергеем Баклановым, подходит ли вам такой формат. Первая консультация бесплатная, без обязательств; стоимость дальнейшей работы обсуждается заранее.">
    <link rel="canonical" href="https://xn--80aba5c.xn--p1ai/">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="боба.рф">
    <meta property="og:title" content="боба.рф — психосоматика Сергей Бакланов">
    <meta property="og:description" content="Работа со страхами и привычными реакциями, развитие уверенности и продуктивности. Бесплатно обсудим ваш запрос; формат и стоимость дальнейшей работы — заранее, без обязательств.">
    <meta property="og:url" content="https://xn--80aba5c.xn--p1ai/">
    <meta property="og:image" content="https://xn--80aba5c.xn--p1ai/boba/og-preview.jpg?v=7">
    <meta property="og:image:secure_url" content="https://xn--80aba5c.xn--p1ai/boba/og-preview.jpg?v=7">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Сергей Бакланов, психосоматика и приглашение на бесплатную консультацию">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="боба.рф — психосоматика Сергей Бакланов">
    <meta name="twitter:description" content="Работа со страхами и привычными реакциями, развитие уверенности и продуктивности. Бесплатно обсудим ваш запрос; формат и стоимость дальнейшей работы — заранее, без обязательств.">
    <meta name="twitter:image" content="https://xn--80aba5c.xn--p1ai/boba/og-preview.jpg?v=7">
    <meta name="theme-color" content="#111a1a">
    <link rel="stylesheet" href="/boba/site.css">
{{--    <link rel="stylesheet" href="/css/output.css?v=1" />--}}
    <script src="/boba/site.js" defer></script>
</head>
<body>
<header class="topbar wrap">
    <a class="brand" href="#top" aria-label="боба.рф — психосоматика Сергей Бакланов"><span class="brand-oval">боба.рф</span><span
            <span class="brand-copy"><strong>Сергей Бакланов</strong><small>психосоматика</small></span></a>
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

    <section class="service-promo wrap" aria-label="Направления работы" aria-roledescription="карусель"
             data-promo-carousel>
        <div class="promo-viewport">
            <article class="promo-slide is-active" data-promo-slide aria-hidden="false">
                <div class="promo-copy">

                    <div class="promo-details">
                        <h2>Страхи и&nbsp;фобии</h2>
                        <br/>
                        <p>Общение, выступления и&nbsp;ситуации, которые вызывают сильное напряжение.</p>
                        <br/>
                        <button class="button promo-cta" type="button" data-consult="Страхи и фобии">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/fears.webp')"><img class="promo-image" src="/boba/services/fears.webp" alt="" fetchpriority="high"></div>
            </article>
            <article class="promo-slide" data-promo-slide aria-hidden="true" inert>
                <div class="promo-copy">

                    <div class="promo-details">
                        <h2>Тревога и&nbsp;стресс</h2>
                        <br/>
                        <p>Беспокойство, напряжение и&nbsp;трудности с&nbsp;расслаблением.</p>
                        <br/>
                        <button class="button promo-cta" type="button" data-consult="Тревога и стресс">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/stress.webp')"><img class="promo-image" src="/boba/services/stress.webp" alt="" loading="lazy"></div>
            </article>
            <article class="promo-slide" data-promo-slide aria-hidden="true" inert>
                <div class="promo-copy">

                    <div class="promo-details"> <h2>Эмоции и&nbsp;напряжение</h2>
                        <br/>

                        <p>Скованность и&nbsp;чувства, которым трудно найти выход.</p>   <br/>
                        <button class="button promo-cta" type="button" data-consult="Эмоции и напряжение">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/emotions.webp')"><img class="promo-image" src="/boba/services/emotions.webp" alt="" loading="lazy"></div>
            </article>
            <article class="promo-slide" data-promo-slide aria-hidden="true" inert>
                <div class="promo-copy">
{{--                    <p class="promo-eyebrow">НАПРАВЛЕНИЕ · 04 / 07</p>--}}

                    <div class="promo-details">
                        <h2>Уверенность и&nbsp;самооценка</h2>  <br/>
                        <p>Неуверенность, самокритика и&nbsp;повторяющиеся сценарии.</p>  <br/>
                        <button class="button promo-cta" type="button" data-consult="Самооценка и личные стратегии">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/confidence.webp')"><img class="promo-image" src="/boba/services/confidence.webp" alt="" loading="lazy"></div>
            </article>
            <article class="promo-slide" data-promo-slide aria-hidden="true" inert>
                <div class="promo-copy">
{{--                    <p class="promo-eyebrow">НАПРАВЛЕНИЕ · 05 / 07</p>--}}

                    <div class="promo-details">
                        <h2>Потери и&nbsp;незавершённые истории</h2>  <br/>
                        <p>Расставания, обиды и&nbsp;воспоминания, от&nbsp;которых сложно переключиться.</p>  <br/>
                        <button class="button promo-cta" type="button" data-consult="Потери и незавершённые истории">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/loss.webp')"><img class="promo-image" src="/boba/services/loss.webp" alt="" loading="lazy"></div>
            </article>
            <article class="promo-slide" data-promo-slide aria-hidden="true" inert>
                <div class="promo-copy">
{{--                    <p class="promo-eyebrow">НАПРАВЛЕНИЕ · 06 / 07</p>--}}

                    <div class="promo-details">
                        <h2>Навязчивые мысли и&nbsp;действия</h2>  <br/>
                        <p>Повторяющиеся мысли, действия и&nbsp;трудности речи.</p>  <br/>
                        <button class="button promo-cta" type="button" data-consult="Навязчивые мысли и действия">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/thoughts.webp')"><img class="promo-image" src="/boba/services/thoughts.webp" alt="" loading="lazy"></div>
            </article>
            <article class="promo-slide" data-promo-slide aria-hidden="true" inert>
                <div class="promo-copy">

                    <div class="promo-details">
                        <h2>Личный и&nbsp;бизнес-коучинг</h2>  <br/>
                        <p>Цели, решения, уверенность и&nbsp;продуктивные привычки.</p>  <br/>
                        <button class="button promo-cta" type="button" data-consult="Личный и бизнес-коучинг">Записаться <span>↗</span></button></div>
                </div><div class="promo-photo" style="--promo-photo:url('/boba/services/productivity.webp')"><img class="promo-image" src="/boba/services/productivity.webp" alt="" loading="lazy"></div>
            </article>
        </div>
        <div class="promo-controls" aria-label="Управление рекламными направлениями">
            <button class="promo-arrow" type="button" data-promo-prev aria-label="Предыдущее направление">←</button>
            <div class="promo-dots">
                <button class="promo-dot is-active" type="button" data-promo-to="0" aria-label="Показать направление 1" aria-current="true"></button>
                <button class="promo-dot" type="button" data-promo-to="1" aria-label="Показать направление 2"></button>
                <button class="promo-dot" type="button" data-promo-to="2" aria-label="Показать направление 3"></button>
                <button class="promo-dot" type="button" data-promo-to="3" aria-label="Показать направление 4"></button>
                <button class="promo-dot" type="button" data-promo-to="4" aria-label="Показать направление 5"></button>
                <button class="promo-dot" type="button" data-promo-to="5" aria-label="Показать направление 6"></button>
                <button class="promo-dot" type="button" data-promo-to="6" aria-label="Показать направление 7"></button>
            </div>
            <button class="promo-arrow" type="button" data-promo-next aria-label="Следующее направление">→</button>
            <button class="promo-toggle" type="button" data-promo-toggle aria-label="Остановить смену направлений" aria-pressed="false">Ⅱ</button>
        </div>
    </section>

    <section class="hero wrap">
        <div class="hero-copy">
            <p class="eyebrow"><span class="eyebrow-line"></span> ИНДИВИДУАЛЬНАЯ РАБОТА · ОНЛАЙН И ОЧНО</p>
            <h1>Меняться<br>можно <em>бережно.</em></h1>
            <p class="hero-lead">Если страх перед общением, выступлением или конкретной ситуацией ограничивает вас,
                обсудим, может ли психосоматическая работа помочь изменить привычную реакцию. Также можно работать над
                уверенностью и более продуктивными способами действовать.</p>
            <div class="hero-actions">
                <button class="button" type="button" data-consult="Бесплатная консультация">Бесплатная консультация
                    <span>↗</span></button>
                <a class="under-link" href="#services">Посмотреть направления <span>↓</span></a></div>
            <p class="hero-footnote">Бесплатная консультация — без обязательств. Формат и стоимость дальнейшей работы
                обсуждаем заранее; результат индивидуален.</p>
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

    <section class="section service-section" id="services">
        <div class="section-head">
            <div><p class="eyebrow">С ЧЕМ МОЖНО ОБРАТИТЬСЯ</p>
                <h2>Направления<br><em>работы</em></h2></div>
            <p class="section-intro">Можно обратиться со страхом конкретной ситуации, неуверенностью или привычками,
                которые мешают быть продуктивнее. На бесплатной консультации обсудим запрос и подходит ли вам такой
                формат работы.</p></div>
        <div class="service-grid">
            <article class="service-card">
                <div class="service-copy"><span class="card-number">01</span>
                    <h3>Страхи и фобии</h3>
                    <p>Общение, публичные выступления, поездки, темнота и другие ситуации, которые вызывают сильное
                        напряжение.</p>
                    <button class="card-link" type="button" data-consult="Страхи и фобии">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
            <article class="service-card">
                <div class="service-copy"><span class="card-number">02</span>
                    <h3>Тревога и стресс</h3>
                    <p>Внутреннее беспокойство, напряжение и трудности с расслаблением. Обсудим, что именно запускает
                        тревогу и мешает вам.</p>
                    <button class="card-link" type="button" data-consult="Тревога и стресс">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
            <article class="service-card">
                <div class="service-copy"><span class="card-number">03</span>
                    <h3>Эмоции и напряжение</h3>
                    <p>Скованность, раздражение, злость и чувства, которым трудно найти выход. Работаем с тем, как они
                        проявляются в жизни.</p>
                    <button class="card-link" type="button" data-consult="Эмоции и напряжение">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
            <article class="service-card">
                <div class="service-copy"><span class="card-number">04</span>
                    <h3>Самооценка и личные стратегии</h3>
                    <p>Неуверенность, самокритика и привычные способы действовать, которые мешают в отношениях с собой
                        и окружающими.</p>
                    <button class="card-link" type="button" data-consult="Самооценка и личные стратегии">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
            <article class="service-card">
                <div class="service-copy"><span class="card-number">05</span>
                    <h3>Потери и незавершённые истории</h3>
                    <p>Расставание, обида, воспоминания и повторяющиеся мысли, от которых сложно переключиться.</p>
                    <button class="card-link" type="button" data-consult="Потери и незавершённые истории">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
            <article class="service-card">
                <div class="service-copy"><span class="card-number">06</span>
                    <h3>Навязчивые мысли и действия</h3>
                    <p>Повторяющиеся мысли и действия, трудности речи, в том числе заикание. На консультации обсудим
                        подходящий формат помощи.</p>
                    <button class="card-link" type="button" data-consult="Навязчивые мысли и действия">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
            <article class="service-card">
                <div class="service-copy"><span class="card-number">07</span>
                    <h3>Личный и бизнес-коучинг</h3>
                    <p>Цели, решения, уверенность и баланс между работой и личной жизнью. Найдём более продуктивные
                        способы действовать.</p>
                    <button class="card-link" type="button" data-consult="Личный и бизнес-коучинг">Бесплатная консультация <span>↗</span></button>
                </div>
            </article>
        </div>
        <p class="scope-note">Я не работаю с психическими расстройствами, зависимостями и семейной терапией.
            Гипнотерапия не заменяет помощь врача или психотерапевта. Если вы уже наблюдаетесь у специалиста, сообщите
            об этом на консультации.</p>
    </section>

    <section class="work-values">
        <div class="wrap work-values-grid">
            <article class="work-value">
                <p class="eyebrow">ПОНЯТНЫЕ УСЛОВИЯ</p>
                <h2>Сначала обсудим формат и стоимость</h2>
                <p>Первая консультация бесплатная и ни к чему не обязывает. Если решите продолжить, каждая дальнейшая
                    работа оплачивается; формат и стоимость назову до начала работы. У меня нет медицинского образования,
                    поэтому я не берусь за запросы, требующие диагностики или лечения заболеваний, и порекомендую
                    обратиться к врачу.</p>
            </article>
            <article class="work-value work-value-result">
                <p class="eyebrow">МОЯ ЦЕЛЬ — РЕЗУЛЬТАТ</p>
                <h2>Если работа даст результат — буду рад бонусу</h2>
                <p>Моя цель — чтобы вы на практике заметили изменения и стали в обычной жизни реагировать и вести себя
                    ближе к тому, как хотите сами. Если по итогам вы сочтёте, что я хорошо выполнил работу и она помогла
                    вам, я планирую получить бонус за результат.</p>
            </article>
        </div>
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
