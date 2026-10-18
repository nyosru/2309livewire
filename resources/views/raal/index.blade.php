<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="РААЛ — Работа Алгоритмов. Проверяем идеи, запускаем проекты и превращаем работающий бизнес в управляемый актив.">
    <meta name="theme-color" content="#171914">
    <title>РААЛ — Работа Алгоритмов</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Unbounded:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/raal.css">
</head>
<body>
<header class="site-header">
    <a class="brand" href="#top" aria-label="РААЛ — на главную">
        <span class="brand-mark" aria-hidden="true">Р</span>
        <span class="brand-copy"><span class="brand-name">РААЛ</span><small>Работа Алгоритмов</small></span>
    </a>
    <nav class="main-nav" aria-label="Основная навигация">
        <a href="#approach">Как работаем</a>
        <a href="#projects">Проекты</a>
        <a href="#contact">Контакты</a>
    </nav>
    <button class="header-action js-open-modal" type="button">Разобрать проект <span>↗</span></button>
</header>

<main id="top">
    <section class="hero">
        <div class="hero-kicker reveal"><span></span> раал.рф — Работа Алгоритмов</div>
        <div class="hero-grid">
            <div class="hero-copy reveal">
                <h1>Из идеи —<br>в управляемый <em>бизнес</em></h1>
                <p>Проверяем спрос и цифры до вложений. Затем запускаем, измеряем результат и развиваем то, что действительно работает.</p>
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
        <div class="hero-marquee" aria-hidden="true">
            <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
            <div>ПЛАНИРУЕМ <b>✳</b> ЗАПУСКАЕМ <b>✳</b> РАЗВИВАЕМ <b>✳</b> ЗАРАБАТЫВАЕМ <b>✳</b> МАСШТАБИРУЕМ <b>✳</b>&nbsp;</div>
        </div>
    </section>

    <section class="approach section" id="approach">
        <div class="section-heading reveal">
            <span class="eyebrow">/ Подход</span>
            <h2>От гипотезы —<br>к <em>доходному активу</em></h2>
            <p>Инвестируем не вслепую: у каждого этапа есть цель, ответственный и измеримый результат. Прогресс проекта виден всем участникам.</p>
        </div>
        <div class="route-list">
            <article class="route-item reveal">
                <span class="route-number">01</span>
                <div><h3>Проверяем</h3><p>Отвечаем на главный вопрос: кому и зачем нужен продукт. Оцениваем спрос, ресурсы, риски и экономику до вложений.</p></div>
                <span class="route-icon">⌁</span>
            </article>
            <article class="route-item reveal">
                <span class="route-number">02</span>
                <div><h3>Запускаем</h3><p>Делаем минимальную рабочую версию, получаем обратную связь и первые продажи — без преждевременных больших расходов.</p></div>
                <span class="route-icon">↗</span>
            </article>
            <article class="route-item reveal">
                <span class="route-number">03</span>
                <div><h3>Улучшаем точки контакта</h3><p>Оцифровываем процессы в CRM «ПроцессМастер», измеряем результат и улучшаем каждый контакт клиента с бизнесом.</p></div>
                <span class="route-icon">＋</span>
            </article>
            <article class="route-item reveal">
                <span class="route-number">04</span>
                <div><h3>Масштабируем результат</h3><p>Усиливаем прибыль работающего бизнеса, упаковываем франшизу или готовим понятный и управляемый актив к продаже.</p></div>
                <span class="route-icon">₽</span>
            </article>
        </div>
    </section>

    <section class="projects section" id="projects">
        <div class="projects-heading reveal">
            <div><span class="eyebrow">/ Текущие проекты</span><h2>Уже в работе</h2></div>
            <p>Не обещания, а конкретные проекты. Наведите на разные части фотографии, чтобы увидеть больше.</p>
        </div>

        @forelse($projects as $project)
            @php
                $images = collect($project->images)->filter()->values();
                if ($images->isEmpty()) {
                    $images = collect(['/processmaster/preview_link_for_fb.jpg']);
                }
                $statusClass = match($project->status_color) {
                    'orange' => 'status-warm',
                    'blue' => 'status-blue',
                    default => '',
                };
            @endphp
            <article class="project-card {{ $loop->even ? 'project-card-reverse' : '' }} reveal">
                <div class="project-visual js-project-gallery" data-images="{{ $images->implode('|') }}">
                    <img src="{{ $images->first() }}" alt="Проект {{ $project->title }}" loading="lazy">
                    <div class="gallery-zones" style="grid-template-columns: repeat({{ $images->count() }}, 1fr)" aria-label="Другие фотографии проекта">
                        @foreach($images as $image)
                            <button type="button" data-image="{{ $loop->index }}" aria-label="Фото {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                    <div class="gallery-progress">
                        @foreach($images as $image)
                            <i class="{{ $loop->first ? 'active' : '' }}"></i>
                        @endforeach
                    </div>
                    <span class="project-status {{ $statusClass }}">{{ $project->status }}</span>
                </div>
                <div class="project-info">
                    <div class="project-meta">
                        <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ $project->category }}</span>
                        <span>{{ $project->location }}</span>
                    </div>
                    <h3>{{ $project->title }}</h3>
                    <p class="project-description">{{ $project->description }}</p>
                    <div class="investment"><span>Возможность для инвестора</span><p>{{ $project->investment_offer }}</p></div>
                    <button class="button button-dark js-open-modal" type="button" data-project="{{ $project->title }}">Обсудить участие в проекте <span>↗</span></button>
                </div>
            </article>
        @empty
            <p class="projects-empty">Скоро здесь появятся новые проекты.</p>
        @endforelse
    </section>

    <section class="crm-callout section reveal">
        <div class="crm-symbol" aria-hidden="true"><span>●</span><span>●</span><span>●</span></div>
        <div><span class="eyebrow">/ Управление без хаоса</span><h2>Ведём каждый проект<br>в <em>ПроцессМастере</em></h2></div>
        <div class="crm-copy"><p>Это одна из ключевых точек контакта с инвестором: планы, договорённости, цифры и история решений всегда перед глазами.</p><a href="https://процессмастер.рф" target="_blank" rel="noopener">Посмотреть, как это работает <span>↗</span></a></div>
    </section>

    <section class="contact section" id="contact">
        <div class="contact-copy reveal">
            <span class="eyebrow">/ Давайте знакомиться</span>
            <h2>Есть идея<br>или ресурс?</h2>
            <p>На первой встрече определим сильные стороны проекта, ближайший разумный шаг и формат участия — без обязательств с вашей стороны.</p>
        </div>
        <div class="contact-action reveal">
            <button class="circle-button js-open-modal" type="button"><span>Разобрать<br>идею</span><b>↗</b></button>
            <p>Коротко и по делу:<br>цель, цифры, следующий шаг.</p>
        </div>
    </section>
</main>

<footer>
    <a class="brand brand-footer" href="#top"><span class="brand-mark">Р</span><span class="brand-copy"><span class="brand-name">РААЛ</span><small>раал.рф — Работа Алгоритмов</small></span></a>
    <p>© {{ date('Y') }} РААЛ. Информация на сайте не является публичной офертой.</p>
    <a href="https://php-cat.com" target="_blank" rel="noopener">Создание сайта — php-cat.com ↗</a>
</footer>

<dialog class="consultation-modal" id="consultationModal" aria-labelledby="modalTitle">
    <button class="modal-close" type="button" aria-label="Закрыть">×</button>
    <div class="modal-step modal-form-step">
        <span class="eyebrow">/ Личная консультация</span>
        <h2 id="modalTitle">Разберём вашу идею по делу</h2>
        <p>Оставьте контакты и удобное время. На встрече определим потенциал проекта и ближайший разумный шаг.</p>
        <form action="{{ route('raal.consultation') }}" method="post" id="consultationForm">
            @csrf
            <input type="hidden" name="project" id="projectField">
            <label><span>Телефон</span><input type="tel" name="phone" autocomplete="tel" placeholder="+7 999 000-00-00" required></label>
            <label><span>Город</span><input type="text" name="city" autocomplete="address-level2" placeholder="Например, Тюмень" required></label>
            <label class="wide"><span>Когда удобно созвониться или встретиться?</span><textarea name="preferred_time" rows="3" placeholder="Например: в будни после 16:00, лучше созвониться" required></textarea></label>
            <label class="honeypot" aria-hidden="true">Сайт<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            <button class="button button-primary wide" type="submit">Договориться о встрече <span>↗</span></button>
            <small class="wide">Нажимая кнопку, вы соглашаетесь на обработку указанных данных для связи с вами.</small>
        </form>
    </div>
    <div class="modal-step modal-success" hidden>
        <span class="success-mark">✓</span>
        <h2>Заявка принята</h2>
        <p>Свяжемся с вами и подтвердим удобное время.</p>
        <button class="button button-dark modal-done" type="button">Хорошо</button>
    </div>
</dialog>

<script src="/js/raal.js" defer></script>
</body>
</html>
