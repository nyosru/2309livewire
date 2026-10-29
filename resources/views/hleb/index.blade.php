<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Хлебничная — выпечка с душой. Пекарня и франшиза</title>
    <meta name="description" content="Сытные и сладкие пироги, пицца и выпечка Хлебничной. Соберите заказ или узнайте, как открыть свою пекарню по франшизе.">
    <link rel="stylesheet" href="/hleb/site.css?v={{ filemtime(public_path('hleb/site.css')) }}">
    <script src="/hleb/site.js?v={{ filemtime(public_path('hleb/site.js')) }}" defer></script>
</head>
<body>
<div class="topline">Тёплые встречи начинаются с хлеба <span>Екатеринбург · ежедневно 09:00–21:00</span></div>
<header class="header wrap">
    <a href="#home" class="brand" aria-label="Хлебничная — на главную">
        @if(is_file(public_path('hleb/images/logo.webp')))<img src="/hleb/images/logo.webp" alt="Хлебничная">@else<span class="brand-mark">♧</span><span>Хлебничная<small>ПЕКАРНЯ У ДОМА</small></span>@endif
    </a>
    <nav aria-label="Основная навигация"><a href="#menu">Наша выпечка</a><a href="#about">О пекарне</a><a href="#contacts">Контакты</a></nav>
    <button class="cart-toggle" data-cart-open>Корзина <span data-cart-count>0</span></button>
</header>
<main id="home">
    <section class="catalog wrap section" id="menu">
        <div class="section-heading"><div><h2>Выбирайте<br><em>по любви.</em></h2></div><p>Для семейного ужина, уютного чаепития<br>и повода, который можно придумать самим.</p></div>
        <div class="catalog-tools"><div class="filters" aria-label="Категории выпечки"><button class="active" data-category="all" aria-pressed="true">Вся выпечка</button>@foreach(collect($products)->pluck('category')->unique() as $category)<button data-category="{{ $category }}" aria-pressed="false">{{ $category }}</button>@endforeach</div><label class="search"><span class="sr-only">Поиск по каталогу</span><input id="product-search" type="search" placeholder="Найти любимое…"><span aria-hidden="true">⌕</span></label></div>
        <div class="products">
        @foreach($products as $product)
            <article class="product" data-category="{{ $product['category'] }}" data-name="{{ mb_strtolower($product['name']) }}" data-product="{{ $product['id'] }}">
                <div class="product-picture">
                    @if(is_file(public_path('hleb/images/'.$product['id'].'.webp')))<img src="/hleb/images/{{ $product['id'] }}.webp" alt="{{ $product['name'] }}" loading="lazy">@else<div class="photo-pending"><span>Хлебничная</span><small>Фотография скоро появится</small></div>@endif
                    <span class="weight">{{ $product['weight'] }}</span>
                </div>
                <div class="product-info"><small>{{ $product['category'] }}</small><h3>{{ $product['name'] }}</h3><div class="product-bottom"><strong>от {{ number_format($product['price'], 0, ',', ' ') }} ₽</strong><div class="product-quantity" data-product-controls="{{ $product['id'] }}"><button type="button" data-decrease="{{ $product['id'] }}" aria-label="Уменьшить количество: {{ $product['name'] }}" hidden>−</button><span data-product-count aria-label="Количество в корзине" hidden>0</span><button type="button" data-add="{{ $product['id'] }}" aria-label="Добавить: {{ $product['name'] }}">+</button></div></div></div>
            </article>
        @endforeach
        </div>
        <p id="no-products" hidden>Такой выпечки не нашли. Попробуйте другое название или категорию.</p>
        <button class="outline more" id="show-more">Показать ещё выпечку ↓</button>
        <p class="catalog-note">Цены за указанный вес. Наличие, итоговую стоимость и условия получения подтвердит пекарня.</p>
    </section>
    <section class="about section" id="about"><div class="wrap about-grid"><figure class="about-visual"><img src="/hleb/images/apple.webp" alt="Пирог с яблоком из пекарни Хлебничная" loading="lazy"><figcaption><span>Простые вещи.</span><em>Большая любовь.</em></figcaption></figure><div class="about-copy"><span class="eyebrow">02 / НАША ИСТОРИЯ</span><h2>Дело<br><em>в тепле.</em></h2><p>Есть вещи, которые делают день лучше. Аромат свежего хлеба. Первый кусочек любимого пирога. Разговор за чашкой чая.</p><p>С 2016 года «Хлебничная» создаёт такие моменты. Готовим из натуральных продуктов и верим: самое вкусное получается, когда делаешь с душой.</p><div class="about-facts"><div><b>01</b><span>Натуральные<br>ингредиенты</span></div><div><b>02</b><span>Пекарня<br>полного цикла</span></div><div><b>03</b><span>Рядом<br>с вашим домом</span></div></div></div></div></section>
    <section class="wrap section delivery" id="delivery"><div><span class="eyebrow">03 / КАК ЗАКАЗАТЬ</span><h2>Три шага.<br><em>И вы за столом.</em></h2></div><ol><li><span>01</span><div><h3>Выберите любимое</h3><p>Добавьте пироги, выпечку и напитки в корзину.</p></div></li><li><span>02</span><div><h3>Оставьте заявку</h3><p>Укажите телефон, город и пожелания к заказу.</p></div></li><li><span>03</span><div><h3>Согласуйте детали</h3><p>Уточните в пекарне наличие, время, доставку или самовывоз и способ оплаты.</p></div></li></ol></section>
    <section class="wrap section faq"><div><span class="eyebrow">05 / ВОПРОСЫ И ОТВЕТЫ</span><h2>Есть<br><em>вопрос?</em></h2></div><div><details><summary>Как оформить заказ?</summary><p>Выберите выпечку, откройте корзину и оставьте контактные данные. Заявка не является оплатой: итоговую стоимость, наличие и время получения нужно согласовать с пекарней.</p></details><details><summary>Можно ли заказать выпечку на праздник?</summary><p>В каталоге есть большие пироги и банкетные пирожки. Укажите дату, количество гостей и пожелания в комментарии к заявке.</p></details><details><summary>Где узнать состав и аллергены?</summary><p>Перед заказом уточните состав по телефону 8-800-234-37-44. Если у вас есть пищевая аллергия, обязательно сообщите об этом при согласовании заказа.</p></details></div></section>
    <section class="contacts" id="contacts"><div class="wrap contact-inner"><div><span class="eyebrow">06 / ДО ВСТРЕЧИ В ПЕКАРНЕ</span><h2>Ваши люди.<br><em>Ваше место.</em></h2><p>Екатеринбург · Приём заказов 09:00–21:00</p></div><div><a class="big-phone" href="tel:88002343744">8-800-234-37-44</a><a class="text-link" href="https://hlebnichnaya.ru/info/7951" target="_blank" rel="noopener">Адреса пекарен ↗</a></div></div></section>
</main>
<div class="closing-word wrap" aria-hidden="true">Хлебничная<span>®</span></div>
<footer class="wrap"><a class="brand footer-brand" href="#home">Хлебничная</a><span>© {{ date('Y') }} · С теплом к вам.</span><a href="/franchise">Франшиза</a><button class="text-link" data-privacy-open>Обработка персональных данных</button><a href="#home">Наверх ↑</a></footer>
<dialog id="cart-dialog" aria-labelledby="cart-title"><button class="dialog-close" data-close aria-label="Закрыть">×</button><span class="eyebrow">ВАШ ВКУСНЫЙ ПЛАН</span><h2 id="cart-title">Корзина</h2><div id="cart-items"></div><div id="cart-summary"><div class="cart-total">Предварительно <strong id="cart-total"></strong></div><p class="muted">Стоимость и получение согласуем перед подтверждением.</p><form data-request-form="order">@include('hleb.form', ['kind' => 'order'])<button class="button" type="submit">Оставить заявку на заказ ↗</button><p role="status" class="form-status"></p></form></div><div id="cart-empty"><p>Здесь пока тихо. Давайте добавим что-нибудь вкусное?</p><button class="button" data-close>Выбрать выпечку</button></div></dialog>

<dialog id="privacy-dialog" aria-labelledby="privacy-title"><button class="dialog-close" data-close aria-label="Закрыть">×</button><h2 id="privacy-title">Ваши данные</h2><p>В форме запрашиваются имя, телефон, город и пожелания. Они сохраняются для обработки вашей заявки на заказ или консультацию по франшизе. Не указывайте платёжные данные.</p><p>Нажимая кнопку отправки и отмечая согласие, вы разрешаете обработать указанные данные для ответа на заявку. Для вопросов о данных и отзыва согласия обратитесь по телефону 8-800-234-37-44.</p></dialog>
@include('hleb.dev-notice')
<div id="toast" role="status"></div>
<script type="application/json" id="catalog-data">{!! json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
</body></html>
