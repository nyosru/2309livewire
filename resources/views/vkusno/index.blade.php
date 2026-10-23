<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Вкусняжки72 — кафе и торты с вашей историей</title>
    <meta name="description" content="Вкусняжки72: кафе и столовая, любимые блюда и торты на заказ. Соберите заказ с доставкой или самовывозом.">
    <meta name="theme-color" content="#cd122d">
    <link rel="icon" href="/vkusno/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/vkusno/cafe.css">
    <script src="/vkusno/cafe.js" defer></script>
<script src="/vkusno/development-ribbon.js" defer data-navigate-once></script></head>
<body>
@include('vkusno.partials.development-ribbon')

<header class="header">
    <a class="brand" href="/" aria-label="Вкусняжки72 — на главную"><img class="brand-logo" src="/vkusno/logo.svg" alt="Вкусняжки72 — кафе и кондитерская" width="340" height="78"></a>
    <nav id="main-navigation" aria-label="Основная навигация">@foreach($cafe['menu_sections'] as $menuSection)<a href="#{{ $menuSection['anchor'] }}">{{ $menuSection['title'] }}</a>@endforeach<a href="#cakes">Торты на заказ</a><a href="#cafe">Наше кафе</a><a href="#delivery">Доставка</a></nav>
    <button class="cart-button" data-cart-open>Корзина <span data-cart-count>0</span><span aria-hidden="true">↗</span></button>
    <button class="menu-toggle" type="button" aria-label="Открыть меню" aria-controls="main-navigation" aria-expanded="false"><span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span></button>
</header>
<main>
    <div class="contact-strip wrap" aria-label="Адрес и контакты кафе"><a href="{{ $cafe['map_url'] }}" target="_blank" rel="noopener">{{ $cafe['address'] }} ↗</a><span>{{ $cafe['hours'] }}</span><a class="contact-phone" href="tel:{{ preg_replace('/[^+0-9]/', '', $cafe['phone']) }}">{{ $cafe['phone'] }}</a></div>
    <section class="hero wrap">
        <div class="hero-copy"><p class="eyebrow"><span></span> ВКУСНО БЫТЬ ВМЕСТЕ</p><h1>Для тёплых встреч.<br>И сладких<br><em>моментов.</em></h1><p class="hero-description">Загляните на обед, останьтесь на десерт.<br>А для особенного дня мы испечём тот самый торт.</p><div class="hero-actions"><a class="button primary" href="#{{ collect($cafe['menu_sections'])->first()['anchor'] ?? 'cakes' }}">Посмотреть меню <span>↗</span></a><a class="text-link" href="#cakes">Хочу особенный торт <span>→</span></a></div><div class="hero-note"><span class="little-flower">✳</span><span>С собой, к вашему столу<br>или прямо домой</span></div></div>
        <div class="hero-visual"><img class="hero-photo" src="/vkusno/hero.jpg" alt="Шоколадный торт со сливочным кремом" fetchpriority="high"><span class="hero-stamp">СДЕЛАНО<br><i>с любовью</i><br>ДЛЯ ВАС ♡</span><div class="photo-caption"><span>Маленький повод<br><strong>для большой радости</strong></span><span>↗</span></div></div>
    </section>
    <div class="ticker" aria-hidden="true"><span>ЛЮБИМАЯ ЕДА</span><b>✳</b><span>ТОРТЫ С ВАШЕЙ ИСТОРИЕЙ</span><b>✳</b><span>ВРЕМЯ ВМЕСТЕ</span><b>✳</b><span>ЕЩЁ КУСОЧЕК СЧАСТЬЯ</span><b>✳</b></div>
    @foreach($cafe['menu_sections'] as $sectionId => $menuSection)
    @php($sectionProducts = collect($cafe['products'])->where('section', $sectionId))
    <section id="{{ $menuSection['anchor'] }}" class="section wrap menu-section {{ $sectionId === 'canteen' ? 'canteen-menu' : '' }}" data-menu-block="{{ $sectionId }}">
        <div class="section-heading"><div><p class="eyebrow">{{ $menuSection['eyebrow'] }}</p><h2>Меню: <em>{{ $menuSection['title'] }}</em></h2></div><p class="menu-section-description">{{ $menuSection['description'] }}</p></div>
        <div class="menu-section-links" aria-label="Разделы меню">@foreach($cafe['menu_sections'] as $linkId => $linkSection)<a href="#{{ $linkSection['anchor'] }}" @if($sectionId === $linkId) aria-current="true" @endif>{{ $linkSection['title'] }}</a>@endforeach</div>
        @if($cafe['demo_menu'])<p class="demo-notice">Позиции с пометкой «С витрины» — из меню заведения. Цены и наличие уточняются при подтверждении. Примерные позиции и предварительные цены отмечены отдельно.</p>@endif
        <div class="menu-toolbar"><div class="categories" role="group" aria-label="Категории: {{ $menuSection['title'] }}"><button class="active" data-category="all" aria-pressed="true">Всё меню <span>↗</span></button>@foreach($menuSection['categories'] as $categoryId => $categoryLabel)<button data-category="{{ $categoryId }}" aria-pressed="false">{{ $categoryLabel }}</button>@endforeach</div><span class="menu-count" data-menu-count>Позиций: {{ $sectionProducts->count() }}</span></div>
        <div class="product-grid">
            @foreach($sectionProducts as $product)
                @include('vkusno.partials.product-card', ['product' => $product])
            @endforeach
        </div>
        @if($sectionProducts->count() > 12)<button type="button" class="button menu-show-more" data-menu-show-more>Показать ещё</button>@endif
        @if($sectionId === 'canteen')<p class="canteen-note">Ассортимент витрины меняется. Наличие блюд и состав обеда уточните у повара или по телефону <a href="tel:{{ preg_replace('/[^+0-9]/', '', $cafe['phone']) }}">{{ $cafe['phone'] }}</a>.</p>@endif
    </section>
    @endforeach
    <section id="cakes" class="cake-section wrap"><div class="cake-visual"><img src="/vkusno/cake.jpg" alt="Торт с ягодами для особенного праздника" loading="lazy"><span class="cake-label">Ваш праздник.<br><em>Наше вдохновение.</em></span></div><div class="cake-copy"><p class="eyebrow">СЛАДКАЯ ЧАСТЬ ВАШЕЙ ИСТОРИИ</p><h2>Не просто торт.<br><em>Ваш тот самый.</em></h2><p>Детский торт с любимым персонажем, нежный цветочный декор или торт в несколько ярусов. Обсудим оформление под ваше событие и количество гостей.</p><p class="cake-assortment">Бенто-торты · Фототорты · Меренговые рулеты</p><div class="cake-features"><span><b>01</b>Любимая начинка</span><span><b>02</b>Особенный декор</span><span><b>03</b>Нужный размер</span></div><button class="button primary" data-cake-open>Обсудить мой торт <span>↗</span></button><small>Заявка минимум за {{ $cafe['cake_lead_days'] }} дня · стоимость после обсуждения</small><a class="cafe-photos-link" href="{{ $cafe['photos_url'] }}" target="_blank" rel="noopener">Смотреть торты и блюда в 2ГИС ↗</a></div></section>
    <section id="cafe" class="section wrap cafe-section"><div><p class="eyebrow">МЕСТО ДЛЯ ВАШИХ ВСТРЕЧ</p><h2>Можно просто<br><em>остаться.</em></h2><p>Наш адрес: {{ $cafe['address'] }}. В зале до {{ $cafe['seats'] }} мест. Можно спокойно пообедать, встретиться с близкими и разделить десерт с теми, кто рядом.</p><a class="text-link" href="{{ $cafe['directions_url'] }}" target="_blank" rel="noopener">Построить маршрут <span>↗</span></a><a class="cafe-photos-link" href="{{ $cafe['photos_url'] }}" target="_blank" rel="noopener">Реальные фотографии кафе в 2ГИС ↗</a></div><img src="/vkusno/interior.jpg?v=20261023" alt="Зал кафе «Вкусняжки72» с мягкими диванами и столиками у окон" width="1400" height="800" loading="lazy"><span class="cafe-tag">Еда. Разговоры.<br>Хороший день.</span></section>
    <section id="delivery" class="delivery-section"><div class="wrap"><div class="section-heading"><div><p class="eyebrow">МЫ БЛИЖЕ, ЧЕМ КАЖЕТСЯ</p><h2>Как вам <em>удобнее?</em></h2></div><p>Любимые блюда найдут дорогу к вам.</p></div><div class="delivery-options"><article><span>↗</span><div><h3>Доставим к вам</h3><p>Укажите адрес в заказе. Время и зону доставки подтвердим по телефону.</p><small>{{ $cafe['delivery_fee'] !== null ? 'Доставка — '.$cafe['delivery_fee'].' ₽' : 'Стоимость доставки уточняется при подтверждении' }}</small></div></article><article><span>⌂</span><div><h3>Заберите по пути</h3><p>Выберите самовывоз. Согласуем время и соберём всё к вашему приходу.</p><small>Самовывоз — бесплатно</small></div></article><article><span>♡</span><div><h3>Поешьте у нас</h3><p>В зале до {{ $cafe['seats'] }} мест. Приходите за вкусной едой и тёплыми встречами.</p><small>Будем рады видеть вас</small></div></article></div></div></section>
</main>
<footer id="contacts" class="wrap footer"><div><a href="/" class="footer-brand" aria-label="Вкусняжки72 — на главную"><img src="/vkusno/logo.svg" alt="ВкусняЖки72" width="340" height="78" loading="lazy"></a><p>Кафе, в которое хочется вернуться.</p></div><div><h3>Заглядывайте</h3><p>{{ $cafe['address'] ?: 'Адрес кафе скоро появится здесь' }}</p><p>{{ $cafe['hours'] ?: 'Часы работы уточняются' }}</p><a href="{{ $cafe['map_url'] }}" target="_blank" rel="noopener">На карте ↗</a></div>
    <div><h3>Будем на связи</h3>@if($cafe['phone'])<a href="tel:{{ preg_replace('/[^+0-9]/', '', $cafe['phone']) }}">{{ $cafe['phone'] }}</a>@else<p>Телефон скоро появится здесь</p>@endif<a href="/privacy">Обработка персональных данных</a>

<span>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function(m,e,t,r,i,k,a){
                m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();
                for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
                k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
            })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=113755820', 'ym');

            ym(113755820, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/113755820" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
</span>

    </div>
{{--    <a href="/admin">Управление кафе</a>--}}
    <div class="footer-bottom"><span>© {{ date('Y') }} Вкусняжки72</span><span>С любовью к еде и людям ♡</span></div></footer>
<dialog id="cart-dialog" class="drawer" aria-labelledby="cart-heading"><div class="dialog-header"><div><p class="eyebrow">ПОЧТИ У ВАС</p><h2 id="cart-heading">Ваша корзина</h2></div><button class="close-button" data-close aria-label="Закрыть корзину">×</button></div><div id="cart-items"></div><p id="cart-empty">Здесь пока пусто. Добавьте что-нибудь вкусное из меню.</p><div id="cake-summary" hidden></div><div class="cart-totals"><div><span>Блюда</span><strong id="cart-subtotal">0 ₽</strong></div><p>Торт по индивидуальному заказу рассчитывается отдельно. Доставка и итоговая стоимость подтверждаются кафе.</p></div><form id="order-form"><h3>Оформим заявку</h3><div class="fulfillment"><label><input type="radio" name="fulfillment" value="pickup" checked> Самовывоз</label><label><input type="radio" name="fulfillment" value="delivery"> Доставка</label></div><label>Ваше имя<input name="name" autocomplete="name" required maxlength="100" placeholder="Как к вам обращаться?"></label><label>Телефон<input name="phone" type="tel" autocomplete="tel" required maxlength="30" pattern="\+?[0-9\s()\-]{10,30}" placeholder="+7 (___) ___-__-__"></label><label id="address-field" hidden>Адрес доставки<input name="address" autocomplete="street-address" maxlength="500" placeholder="Улица, дом, квартира"></label><label>Желаемая дата <span class="optional">необязательно для блюд</span><input name="requested_date" type="date"></label><label>Комментарий<textarea name="comment" rows="2" maxlength="2000" placeholder="Время, аллергии, пожелания"></textarea></label><label class="consent"><input type="checkbox" name="consent" required><span>Согласен с <a href="/privacy" target="_blank" rel="noopener">условиями обработки персональных данных</a> для оформления заявки.</span></label><div id="order-error" role="alert" hidden></div><button class="button primary" id="submit-order" type="submit">Отправить заявку <span>↗</span></button><small class="form-note">Без онлайн-оплаты. Заказ считается принятым после подтверждения кафе.</small></form><div id="order-success" role="status" hidden></div></dialog>
<dialog id="cake-dialog" class="cake-dialog" aria-labelledby="cake-heading"><div class="dialog-header"><div><p class="eyebrow">НАЧНЁМ СО СЛАДКОГО</p><h2 id="cake-heading">Ваш особенный торт</h2></div><button class="close-button" data-close aria-label="Закрыть форму торта">×</button></div><form id="cake-form"><p>Расскажите о пожеланиях. Стоимость и возможность изготовления подтвердим лично.</p><label>Начинка<select name="filling">@foreach($cafe['fillings'] as $filling)<option>{{ $filling }}</option>@endforeach</select></label><label>Вес, кг<input type="number" name="weight" min="1" max="15" step="0.5" value="2" required></label><label>Декор и повод<textarea name="design" maxlength="2000" rows="3" placeholder="Например: на день рождения, с ягодами и надписью"></textarea></label><button type="submit" class="button primary">Добавить заявку в корзину <span>↗</span></button><small class="form-note">Выберите дату в корзине, минимум за {{ $cafe['cake_lead_days'] }} дня.</small></form></dialog>
<div class="toast-region"><div id="toast" class="toast" role="status" hidden></div></div>
<script type="application/json" id="cafe-data">@json($frontend)</script>


</body>
</html>
