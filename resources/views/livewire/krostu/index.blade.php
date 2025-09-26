<div>



{{--    <!DOCTYPE html>--}}
{{--    <html lang="ru">--}}
{{--    <head>--}}
{{--        <meta charset="UTF-8" />--}}
{{--        <meta name="viewport" content="width=device-width, initial-scale=1" />--}}
{{--        <title>Услуги маркетолога</title>--}}
{{--        <script src="https://cdn.tailwindcss.com"></script>--}}
{{--    </head>--}}
{{--    <body class="bg-gray-50 font-sans">--}}

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Услуги маркетолога</h1>
            <p class="mt-2 text-gray-600">Подписка на советы и проверка их выполнения для вашего сайта, бренда и личного бренда</p>
        </div>
    </header>




    <div class="max-w-5xl mx-auto p-6 space-y-12">
        <h2 class="text-3xl font-semibold text-center mb-8">Выберите программу сотрудничества</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Программа на 1 год -->
            <div class="border rounded-lg p-6 shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-4">Программа на 1 год</h3>
                <p class="mb-2">Цена: <span class="font-semibold">200 000 ₽</span></p>
                <p class="mb-4 text-sm">Письмо раз в 2 недели с текущими делами и рекомендациями. Изучаем что да как снаружи, готовим рекомендации, присылаем их и проверяем их готовность с отчётами руководителю заказчика (кого определите).</p>
{{--                <livewire:contact-form program="Программа на 1 год" price="50 000 ₽" />--}}
            </div>

            <!-- Программа по быстрому -->
            <div class="border rounded-lg p-6 shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-4">Программа по быстрому</h3>
                <p class="mb-2">Цена: <span class="font-semibold">25 000 ₽</span></p>
                <p class="mb-4 text-sm">Изучаем что да как снаружи, готовим рекомендации — 1-2 месяца.</p>
{{--                <livewire:contact-form program="Программа по быстрому" price="25 000 ₽" />--}}
            </div>

            <!-- Осмотр и диагноз -->
            <div class="border rounded-lg p-6 shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-4">Осмотр и диагноз</h3>
                <p class="mb-2">Цена: <span class="font-semibold">15 000 ₽</span></p>
                <p class="mb-4 text-sm">Изучаем что да как по анкете (80 пунктов) и отправляем отчёт с выявленными слабыми местами — 1 месяц.</p>
{{--                <livewire:contact-form program="Осмотр и диагноз" price="15 000 ₽" />--}}
            </div>
        </div>
    </div>

    <livewire:phpcat.money />

@if(1==2)





    <main class="
{{--    max-w-4xl --}}
container
    mx-auto my-10 px-4 sm:px-6 lg:px-8">




        <!-- Блок подписки на почтовую рассылку -->
        <section class="my-16 py-6 bg-white p-8 rounded-lg shadow
        flex flex-col sm:flex-row
        items-center justify-center
        gap-4">
            <h3 class="text-2xl font-semibold text-gray-900">Подписаться на нашу рассылку</h3>
            <form class="flex w-full max-w-md" onsubmit="event.preventDefault(); alert('Подписка оформлена!');">
                <input
                    type="email"
                    placeholder="Введите ваш email"
                    required
                    class="flex-grow border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                />
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-6 rounded-r-md hover:bg-indigo-700 transition"
                >
                    Подписаться
                </button>
            </form>
        </section>

{{--про маркетинг в работу--}}
        <section class="mt-16 bg-white p-8 rounded-lg shadow flex flex-col sm:flex-row items-center gap-6 max-w-4xl mx-auto">
            <div class="flex-1">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Преимущества добавления в работу маркетолога</h3>
                <ul class="list-disc list-inside space-y-3 text-gray-700">
                    <li>Повышение качества маркетинговых советов и стратегий</li>
                    <li>Регулярная проверка выполнения рекомендаций и оптимизация</li>
                    <li>Персонализированный подход к развитию сайта, бренда и личного бренда</li>
                    <li>Более глубокий анализ и контроль результатов работы</li>
                </ul>
            </div>
            <div class="flex-1 bg-indigo-50 p-6 rounded-lg border border-indigo-200 text-indigo-800">
                <h4 class="text-xl font-semibold mb-2">Сложности и вызовы</h4>
                <p>
                    Для эффективного дополнения работы маркетолога потребуется внедрить систему мониторинга,
                    позволяющую отслеживать все ключевые изменения и события. Это позволит четко понимать,
                    на какие факторы мы можем влиять и корректировать стратегию в реальном времени.
                </p>
            </div>
        </section>



        {{--        колонки с продписками--}}
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            <!-- Сайт -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold text-indigo-600 mb-4">Маркетинг для сайта</h2>
                <p class="text-gray-700 mb-6">Получите советы для продвижения и оптимизации сайта с регулярной проверкой выполнения рекомендаций.</p>
                <ul class="mb-6 space-y-2 text-gray-600">
                    <li>✔ 5 советов в месяц</li>
                    <li>✔ Проверка выполнения</li>
                    <li>✔ Ежемесячная отчётность</li>
                </ul>
                <button class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Подписаться</button>
            </div>

            <!-- Бренд -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold text-green-600 mb-4">Маркетинг для бренда</h2>
                <p class="text-gray-700 mb-6">Подписка с расширенным набором советов по развитию и укреплению бренда с контрольными точками.</p>
                <ul class="mb-6 space-y-2 text-gray-600">
                    <li>✔ 10 советов в месяц</li>
                    <li>✔ Проверка выполнения</li>
                    <li>✔ Поддержка и рекомендации</li>
                </ul>
                <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">Подписаться</button>
            </div>

            <!-- Личный бренд -->
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-semibold text-pink-600 mb-4">Маркетинг для личного бренда</h2>
                <p class="text-gray-700 mb-6">Индивидуальный подход к развитию личного бренда с советами и проверкой их применения.</p>
                <ul class="mb-6 space-y-2 text-gray-600">
                    <li>✔ 15 советов в месяц</li>
                    <li>✔ Проверка и обратная связь</li>
                    <li>✔ Персональный консультант</li>
                </ul>
                <button class="w-full bg-pink-600 text-white py-2 rounded hover:bg-pink-700 transition">Подписаться</button>
            </div>
        </section>
    </main>


{{--    </body>--}}
{{--    </html>--}}












    {{--    для обувщиков--}}
    @if(1==2)
<style>
    @font-face {
        font-family:tt-reg;
        src:url(../font/TTTravels-Regular-wvHCdkS.ttf)
    }
    @font-face {
        font-family:tt-med;
        src:url(../font/TTTravels-Medium-1qpiR1Y.ttf)
    }
    @font-face {
        font-family:tt-bold;
        src:url(../font/TTTravels-Bold-9i2Yjkn.ttf)
    }
    @font-face {
        font-family:tt-extra;
        src:url(../font/TTTravels-ExtraBold-0OoysKW.ttf)
    }
    @font-face {
        font-family:tt-semi;
        src:url(../font/TTTravels-DemiBold-ieOZjgU.ttf)
    }
    @font-face {
        font-family:tt-black;
        src:url(../font/TTTravels-Black-x5OmAtV.ttf)
    }
    @font-face {
        font-family:mont-reg;
        src:url(../font/Montserrat-Regular-KrDBSU4.ttf)
    }
    @font-face {
        font-family:mont-semi;
        src:url(../font/TTTravels-DemiBold-ieOZjgU.ttf)
    }
    @font-face {
        font-family:mont-med;
        src:url(../font/TTTravels-Medium-1qpiR1Y.ttf)
    }
    a {
        text-decoration:none;
        transition:all .4s ease;
        color:#3b3b3b
    }
    a:hover {
        color:#f9423c
    }
    button {
        border:0;
        transition:all .4s ease
    }
    body::-webkit-scrollbar {
        width:4px;
        height:4px
    }
    body::-webkit-scrollbar-thumb {
        border-radius:10px;
        background:#3b3b3b
    }
    body::-webkit-scrollbar-track {
        border-radius:10px;
        background:0 0
    }
    svg path {
        transition:all .4s ease
    }
    body {
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        min-height:100vh;
        padding:0;
        margin:0
    }
    .local_address {
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .local_address:hover {
        color:#eb5a55
    }
    .local_address:hover svg path {
        stroke:#eb5a55
    }
    .local_address svg {
        width:16px;
        height:16px;
        margin-right:10px
    }
    .phone_number_company a {
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .phone_number_company a {
        display:flex;
        align-items:center
    }
    .phone_number_company a:hover {
        color:#eb5a55
    }
    .phone_number_company a:hover svg path {
        stroke:#eb5a55
    }
    .phone_number_company a svg {
        width:16px;
        height:16px;
        margin-right:10px;
        transition:all .4s ease
    }
    .phone_number_company {
        display:flex;
        align-items:center;
        gap:35px;
        margin-left:auto
    }
    .head_first_info {
        display:flex
    }
    .first_head_block {
        background:#3b3b3b;
        padding:6px 0
    }
    .head_second_info {
        display:flex;
        align-items:center;
        gap:50px
    }
    .head_second_info a {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .head_second_info a:hover {
        color:#eb5a55
    }
    .logo_head {
        width:255px;
        height:auto;
        object-fit:cover;
        margin:0 auto;
        display:flex
    }
    .logo_head img {
        width:100%;
        height:100%
    }
    .btn_user_login {
        display:flex;
        align-items:center;
        color:#fff;
        transition:all .4s ease;
        border:0;
        border-radius:4px;
        background:#3b3b3b;
        padding:10px 24px;
        color:#fff;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .btn_user_login:hover {
        background:#242020
    }
    .btn_user_login svg {
        width:24px;
        height:24px;
        margin-right:10px
    }
    .head_main_info {
        display:flex;
        align-items:center;
        gap:30px;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .backet_main {
        display:flex;
        align-items:center;
        padding:10px;
        color:#3b3b3b;
        position:relative
    }
    .backet_main:hover {
        color:#f9423c
    }
    .backet_main:hover svg path {
        stroke:#f9423c
    }
    .backet_main svg {
        width:24px;
        height:24px;
        margin-right:6px
    }
    .second_head_block {
        display:flex;
        align-items:center;
        padding:14px 0
    }
    .service_company {
        display:flex;
        align-items:center;
        gap:55px
    }
    .service_company .product_tab_links {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        position:relative;
        cursor:pointer
    }
    .service_company .product_tab_links a {
        color:#3b3b3b
    }
    .service_company .product_tab_links a:hover {
        color:#f9423c
    }
    .service_company .product_tab_links:hover {
        color:#f9423c
    }
    .service_company .product_tab_links::after {
        position:absolute;
        bottom:-4px;
        left:0;
        right:0;
        height:1px;
        background:#3b3b3b;
        content:'';
        transition:all .4s ease
    }
    .service_company .product_tab_links:hover::after {
        background:#f9423c
    }
    .search_block {
        display:flex;
        position:relative;
        margin-left:auto;
        width:30%;
        z-index:10
    }
    .search_block input {
        width:100%;
        border-radius:4px;
        border:1px solid #d6d6d6;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        color:#3b3b3b;
        padding:12px 24px;
        outline:none;
        box-shadow:none
    }
    .search_block input::placeholder {
        color:#939393
    }
    .search_block svg {
        width:24px;
        height:24px;
        position:absolute;
        top:12px;
        right:24px;
        background:#fff;
        cursor:pointer
    }
    .service_company_body {
        display:flex;
        align-items:center;
        padding:14px 0
    }
    .catalog_products_main {
        height:0;
        overflow:hidden;
        opacity:0;
        visibility:hidden;
        position:absolute;
        transition:all .4s ease;
        top:100%;
        left:0;
        right:0
    }
    .product-company-main.active .catalog_products_main {
        height:auto;
        overflow:unset;
        opacity:1;
        visibility:visible;
        box-shadow:0 14px 10px #eaeaea9a;
        padding:60px 0
    }
    .product_tab_content {
        transition:all .4s ease;
        overflow:hidden;
        background:#fff;
        z-index:1;
        position:relative
    }
    .service_company_body .product-company-main .product_tab_content {
        padding:60px 0
    }
    .service_company_body .product-company-main.active .catalog_products_main {
        padding:0;
        box-shadow:0 14px 10px #eaeaea42;
        background:#fff
    }
    .service_company_body .product-company-main.active .product_tab_content.active {
        height:auto;
        z-index:3
    }
    .product-company-buyer.active .catalog_products_main {
        height:auto;
        opacity:1;
        visibility:visible
    }
    .product-company-buyer.active .catalog_products_main .product_tab_content {
        padding:60px 0
    }
    .product-main-content {
        background:#fff;
        position:absolute;
        top:90%;
        padding:30px 0;
        opacity:0;
        visibility:hidden;
        z-index:-9;
        left:0;
        right:0;
        border-bottom:1px solid #ddd;
        transition:all .1s linear
    }
    .product-main-container {
        display:flex;
        gap:20px
    }
    .product-dropdown.active .product-main-content {
        opacity:1;
        visibility:visible;
        z-index:9
    }
    .catalog_products_main .catalog_products_name a,
    .catalog_products_name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:normal;
        margin-bottom:20px;
        display:block;
        position:relative
    }
    .catalog_products_main .catalog_products_name a:hover,
    .catalog_products_name :hover {
        color:#eb5a55
    }
    .category_products .catalog_products_name {
        display:flex;
        padding:12px 20px;
        align-items:center;
        font-size:16px
    }
    .category_products {
        display:flex;
        flex-wrap:wrap;
        column-count:3;
        gap:10px
    }
    .head_second_info .category_products {
        display:grid;
        grid-template-columns:1fr 1fr
    }
    .head_second_info .product_rows {
        width:45%
    }
    .category_products a {
        color:#3b3b3b;
        font-family:tt-reg;
        font-size:15px;
        line-height:normal;
        min-width:150px;
        overflow:hidden
    }
    .category_products a:hover {
        color:#eb5a55
    }
    .total-product {
        /* display:none */;
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        margin-left:10px
    }
    .header-main {
        position:relative;
        z-index:14
    }
    .product_rows {
        width:33.3%
    }
    .product-dropdown[data-brand="1"] .category_products a {
        min-width:160px
    }
    .product-dropdown[data-brand="1"] .product_rows {
        width:100%
    }
    .product-dropdown[data-brand="1"] .catalog_products_name {
        /* display:none */
    }
    .buyer_tabs::after {
        /* display:none */
    }
    .product-company-main.active {
        z-index:9
    }
    .buyer_rows-tabs {
        width:35%
    }
    .buyer_rows-tabs .category_products a {
        min-width:140px
    }
    .buyer_rows-tabs .category_products {
        min-height:90px
    }
    .cookie-text {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        width:65%
    }
    .cookie-btn {
        color:#fff;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        border-radius:4px;
        background:#eb5a55;
        padding:10px 24px;
        display:flex;
        margin-left:30px
    }
    .cookie-btn:hover {
        background:#f9423c
    }
    .cookie-content {
        border-radius:10px;
        background:#f6f6f6;
        padding:20px 10px;
        display:flex;
        align-items:center;
        justify-content:center
    }
    .cookie-main {
        position:fixed;
        bottom:-999px;
        left:0;
        right:0;
        transition:all .4s ease;
        opacity:0;
        z-index:999
    }
    @media(min-width:991px) {
        .cookie-main {
            width:509px;
            margin:0 auto
        }
    }
    .cookie-main.open-cookie {
        bottom:38px;
        opacity:1
    }
    .category-product-main {
        width:33.4%;
        position:relative;
        overflow:hidden
    }
    .category-product-main img {
        width:100%;
        object-fit:cover;
        aspect-ratio:435/500;
        transition:all .4s ease
    }
    .category-product-main:hover img {
        transform:scale(1.2)
    }
    .name-catalog-product {
        border-radius:2px;
        background:#fff;
        padding:20px 10px;
        position:absolute;
        top:0;
        bottom:0;
        left:45px;
        right:45px;
        margin:auto;
        text-align:center;
        height:max-content
    }
    .catalog_name_block {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:32px;
        line-height:normal;
        margin-bottom:10px;
        transition:all .4s ease
    }
    .name-catalog-product a {
        color:#3b3b3b;
        font-family:tt-med
    }
    .name-catalog-product a:hover {
        color:#eb5a55
    }
    .product-list {
        margin:0;
        padding:0;
        justify-content:center;
        display:flex
    }
    .product-list li {
        color:#939393;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        margin:0 15px;
        transition:all .4s ease
    }
    .product-list a {
        color:#939393;
        font-family:tt-med
    }
    .product-list li:hover {
        text-decoration:underline;
        color:#eb5a55
    }
    .category-product-flex {
        display:flex;
        margin-bottom:20px
    }
    .catalog-section {
        padding:25px 0 30px
    }
    .products-category {
        width:100%;
        height:100%;
        border-radius:50%;
        background:#f6f6f6;
        margin-bottom:10px;
        padding:20px 15px;
        transition:all .4s ease
    }
    .product-content:hover .products-category {
        background:#e9e9e9
    }
    .products-category img {
        width:100%;
        height:100%;
        object-fit:cover;
        transition:all .4s ease
    }
    .product-content:hover img {
        transform:scale(1.1)
    }
    .product-category-name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        text-align:center;
        transition:all .4s ease
    }
    .product-content:hover .product-category-name {
        color:#eb5a55
    }
    .product-content {
        width:112px
    }
    .see-more-product {
        color:#fff;
        text-align:center;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        background:#eb5a55;
        width:112px;
        aspect-ratio:112/112;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:15px
    }
    .see-more-product:hover {
        color:#fff;
        background:#f9423c
    }
    .product-content-main {
        display:flex;
        justify-content:space-between;
        gap:22px;
        align-items:start
    }
    .catalog_name_block:hover {
        color:#eb5a55
    }
    .social_nets {
        background:#eb5a55;
        width:50px;
        height:50px;
        border-radius:50%;
        margin:5px 0;
        padding:10px;
        display:flex;
        align-items:center;
        justify-content:center;
        z-index:9
    }
    .social_nets svg {
        width:100%;
        height:100%
    }
    .social_nets:hover {
        background:#f9423c
    }
    .social_nets-main {
        display:flex;
        flex-direction:column;
        position:absolute;
        right:-100px;
        bottom:0;
        top:0;
        margin:auto;
        justify-content:center
    }
    .text-promocode {
        color:#fff;
        font-family:tt-med;
        font-size:20px;
        line-height:normal;
        margin-right:30px
    }
    .code-promocode {
        border-radius:2px;
        background:#fff;
        color:#eb5a55;
        font-family:tt-bold;
        font-size:18px;
        padding:10px 20px
    }
    .promocode-content {
        display:flex;
        justify-content:center;
        align-items:center;
        padding:20px 0
    }
    .promocode-body {
        border-radius:2px;
        background:#3b3b3b;
        margin-bottom:30px
    }
    .popular-ttl {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:32px;
        line-height:normal
    }
    .popular-head-block {
        display:flex;
        justify-content:space-between;
        margin-bottom:30px
    }
    .slider-arrows {
        width:30px;
        height:30px;
        border-radius:50%;
        background:#f6f6f6;
        display:flex;
        padding:5px;
        cursor:pointer;
        transition:all .4s ease;
        z-index:9
    }
    .slider-arrows:hover:not(.slick-disabled) {
        background:#d6d6d6
    }
    .slider-arrows.slick-disabled svg {
        opacity:.3
    }
    .slider-arrows svg {
        width:100%;
        height:100%
    }
    .slider-prev.slider-arrows svg {
        transform:rotate(180deg)
    }
    .trands-slider-prev.slider-arrows svg {
        transform:rotate(180deg)
    }
    .slider-elements-content {
        display:flex;
        align-items:center
    }
    .slider-elements-content .slider-prev {
        order:2;
        margin-right:10px
    }
    .slider-elements-content .slider-next {
        order:3
    }
    .slider-counter {
        display:flex;
        color:#939393;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        margin-right:20px;
        order:1
    }
    .popular-section {
        padding:30px 0
    }
    .product-img-main {
        width:100%;
        height:auto;
        margin:0 0 35px;
        display:flex;
        justify-content:center;
        align-items:flex-end
    }
    .product-img-main img {
        width:100%;
        aspect-ratio:190/285;
        object-fit:contain
    }
    .product-name {
        color:#3b3b3b;
        text-align:center;
        font-family:tt-reg;
        font-size:16px;
        line-height:120%;
        margin-bottom:10px;
        transition:all .4s ease
    }
    .product-price {
        display:flex;
        align-items:center;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .product-price span {
        color:#939393;
        text-decoration:line-through;
        margin-left:6px
    }
    .product-review-main {
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center
    }
    .product-review-main:hover .product-name {
        color:#eb5a55
    }
    .product-card-content {
        width:100%;
        border-radius:4px;
        border:1px solid #efefef;
        padding:0 20px 35px;
        transition:all .4s ease;
        background:#fff;
        position:relative;
        overflow:unset;
        height:100%;
        display:flex;
        flex-direction:column;
        justify-content:center
    }
    .product-card-content:hover {
        border:1px solid #d6d6d6
    }
    .product-card-main {
        padding:0 10px;
        position:relative;
        height:100%
    }
    .trands-image-block {
        width:65%;
        position:relative;
        padding:0 150px
    }
    .trands-image-block img {
        object-fit:cover
    }
    .trands-image-block img:first-child {
        aspect-ratio:424/555;
        height:555px
    }
    .trands-image-block img:last-child {
        aspect-ratio:330/282;
        height:282px;
        position:absolute;
        top:0;
        bottom:0;
        right:30px;
        margin:auto
    }
    .trands-name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:30px;
        display:block
    }
    .trands-name:hover {
        color:#eb5a55
    }
    .trands-review {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        margin-bottom:30px
    }
    .trands-main-block {
        width:calc(100% - 70%)
    }
    .trands-main-row {
        display:flex;
        align-items:center
    }
    .btn-detailed {
        width:max-content
    }
    .btn-detailed:hover {
        color:#fff
    }
    .trands-slider-main {
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0;
        margin:auto;
        display:flex;
        align-items:center;
        justify-content:space-between
    }
    .slider-main {
        margin:0 -10px
    }
    .news-img-main {
        height:250px;
        margin-bottom:15px;
        width:100%;
        display:block;
        overflow:hidden
    }
    .news-img-main img {
        width:100%;
        height:100%;
        object-fit:cover;
        transition:all .3s linear
    }
    .news-img-main:hover img {
        transform:scale(1.2)
    }
    .news-name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:130%;
        margin-bottom:10px;
        transition:all .4s ease
    }
    .news-name:hover {
        color:#eb5a55
    }
    .news-read-more {
        color:#eb5a55;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .news-review-main:hover .news-read-more {
        color:#f9423c
    }
    .news-review-main {
        display:flex;
        flex-direction:column;
        position:relative
    }
    .news-card-content {
        position:relative
    }
    .news-card-main {
        padding:0 10px
    }
    .service-body {
        display:flex;
        justify-content:space-between;
        align-items:center
    }
    .service-body:nth-child(even) {
        flex-direction:row-reverse;
        margin-top:40px
    }
    .service-body img {
        aspect-ratio:424/300;
        width:40%;
        object-fit:cover
    }
    .service-body+.service-body {
        margin-top:40px
    }
    .service-ttl {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:30px
    }
    .service-review-text {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .service-review-text+.popular-head-block {
        margin-top:40px
    }
    .service-review-text p {
        margin:0
    }
    .service-review-text p+p {
        margin:25px 0 0
    }
    .service-content .btn-detailed {
        margin-top:30px
    }
    .service-content {
        width:50%
    }
    .service-row-flex {
        padding:0 100px
    }
    .shop-internet-shoes {
        margin-bottom:40px
    }
    .logo-footer {
        width:202px;
        margin-bottom:30px;
        display:flex
    }
    .logo-footer img {
        width:100%;
        height:100%;
        object-fit:cover
    }
    .del-called {
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        border-radius:4px;
        background:#eb5a55;
        padding:10px 24px;
        display:flex;
        margin-bottom:20px;
        justify-content:center
    }
    .del-called:hover {
        background:#f9423c;
        color:#fff
    }
    .phone-footer {
        color:#f6f6f6;
        font-family:tt-reg;
        font-size:14px;
        line-height:127.169%;
        margin-bottom:10px;
        display:block
    }
    .days-work {
        color:#939393;
        font-family:tt-reg;
        font-size:12px;
        line-height:127.169%
    }
    .days-work+.phone-footer {
        margin-top:20px
    }
    .we-in-vk {
        display:flex;
        align-items:center;
        margin-bottom:20px;
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .we-in-vk svg {
        width:20px;
        height:20px;
        margin-right:10px
    }
    .contacts-footer {
        display:flex;
        gap:45px
    }
    .contacts-footer-content {
        width:40%
    }
    .name-category-block {
        color:#f6f6f6;
        font-family:tt-bold;
        font-size:16px;
        line-height:110%;
        margin-bottom:32px
    }
    .catalog-footer {
        color:#f6f6f6;
        font-family:tt-med;
        font-size:14px;
        line-height:110%
    }
    .catalog-footer+.catalog-footer {
        margin-top:16px
    }
    .main-footer-content {
        display:flex;
        justify-content:space-between
    }
    .catalog-content {
        width:20%
    }
    .footer-body {
        background:#3b3b3b;
        padding:60px 0 0;
        margin-top:20px
    }
    .catalog-content a {
        display:block
    }
    .catalog-content a:hover {
        color:#eb5a55
    }
    a.phone-footer:hover {
        color:#eb5a55
    }
    .we-in-vk:hover {
        color:#eb5a55
    }
    .second-footer-content {
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-top:1px solid #515151;
        margin-top:40px;
        padding:20px 0
    }
    .second-footer-content {
        color:#939393;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .second-footer-content a {
        color:#eb5a55
    }
    .second-footer-content a:hover {
        color:#f9423c
    }
    .service-review-text ul {
        margin:0
    }
    .menu-block {
        /* display:none */
    }
    a.menuPageLink {
        color:#eb5a55
    }
    .bottom-menu-main {
        /* display:none */
    }
    .menu-header-blocks {
        /* display:none */
    }
    .breadcrumb-main {
        display:block
    }
    .breadcrumb-main li {
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        position:relative;
        display:contents
    }
    .breadcrumb-main li a {
        color:#939393
    }
    .breadcrumb-main li a:hover {
        color:#eb5a55
    }
    .breadcrumb-main .breadcrumb-item::after {
        padding-left:5px;
        float:unset;
        color:#6c757d;
        content:var(--bs-breadcrumb-divider,"/")
    }
    .breadcrumb-main .breadcrumb-item::before {
        /* display:none */
    }
    .breadcrumb-main .breadcrumb-item:last-child::after {
        /* display:none */
    }
    .breadcrumb-main li.active {
        color:#3b3b3b
    }
    .breadcrumb-main {
        margin-bottom:40px
    }
    .product-title-main {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:32px;
        line-height:normal;
        display:flex;
        margin-bottom:20px;
        align-items:baseline
    }
    .product-title-main span {
        display:block
    }
    .catalog-product-main {
        width:313px;
        height:max-content;
        position:sticky;
        top:10px
    }
    .catalog-product-main .category_products {
        column-count:1;
        flex-direction:column
    }
    .catalog-product-main .catalog_products_name {
        position:relative;
        margin:0;
        padding:12px 20px;
        border-radius:4px;
        transition:all .4s linear;
        cursor:pointer
    }
    .catalog-product-main .catalog_products_name:hover {
        background:#f6f6f6
    }
    .catalog-product-main .category_products a:hover {
        background:#f6f6f6;
        color:#3b3b3b
    }
    .catalog-product-main .category_products a {
        display:flex;
        padding:5px 20px;
        align-items:center
    }
    .catalog-product-main .category_products a.active {
        background:#3b3b3b;
        color:#fff;
        border-radius:4px
    }
    .catalog-product-main .category_products .total-product {
        display:block;
        font-size:9px;
        margin-left:5px
    }
    .catalog-product-main .category_products {
        display:block;
        column-count:unset;
        height:0;
        overflow:hidden;
        opacity:0;
        visibility:hidden;
        transition:all .8s linear
    }
    .catalog-product-main .product_rows.active>.category_products {
        height:auto;
        opacity:1;
        visibility:visible;
        margin-left:10px
    }
    .catalog-product-main .catalog_products_name::after {
        position:absolute;
        content:'';
        top:0;
        bottom:0;
        right:30px;
        width:20px;
        height:20px;
        background-image:url(../img/arrow-PUk_Zjn.svg);
        background-position:50%;
        background-size:cover;
        background-repeat:no-repeat;
        margin:auto;
        transform:rotate(90deg);
        transition:all .4s ease
    }
    .catalog-product-main .product_rows.active>.catalog_products_name.catalog_products_name::after {
        transform:rotate(-90deg)
    }
    .catalog-product-main .product_rows {
        width:100%;
        padding:0
    }
    .product_rows[data-brand="1"] {
        /* display:none */
    }
    .filter-block {
        width:max-content;
        position:relative
    }
    .card-size-content-card {
        opacity:0;
        visibility:hidden;
        transition:all .2s linear;
        margin:4px 0 0;
        text-align:center;
        color:#939393;
        font-family:tt-reg;
        font-size:14px;
        line-height:normal;
        position:absolute;
        bottom:-10px;
        left:-1px;
        right:-1px;
        background:#fff;
        z-index:9;
        padding:15px;
        border:1px solid #d6d6d6;
        border-top:0
    }
    .product-card-content:hover .card-size-content-card {
        opacity:1;
        visibility:visible
    }
    .catalog-content-row {
        display:flex;
        position:relative
    }
    .catalog-product-second-block {
        width:calc(100% - 313px);
        padding-left:20px
    }
    .filter-head-first-block {
        margin-bottom:20px;
        display:flex;
        flex-wrap:wrap;
        gap:20px;
        position:relative;
        z-index:11
    }
    .filter-mobile-head {
        /* display:none */;
        position:relative
    }
    .price-block-header {
        border-radius:4px;
        border:1px solid #d6d6d6;
        background:#fff;
        position:relative;
        min-width:82px;
        display:flex;
        align-items:center;
        padding:4px 8px;
        cursor:pointer;
        overflow:hidden
    }
    .price-block-header .my-selection-class {
        position:unset;
        margin:-4px -8px;
        z-index:9;
        padding-right:28px
    }
    .color-product-search::after {
        position:absolute;
        content:'';
        left:0;
        width:16px;
        height:16px;
        top:0;
        bottom:0;
        margin:auto;
        border-radius:50%;
        border:2px solid #3b3b3b;
        background-position:50%;
        background-repeat:no-repeat
    }
    .price-block-header::after,
    .color-product-search-head::after {
        content:'';
        position:absolute;
        height:16px;
        top:0;
        margin:auto;
        bottom:0;
        right:10px;
        width:16px;
        background-image:url(../img/arrow-PUk_Zjn.svg);
        background-repeat:no-repeat;
        background-position:50%;
        background-size:cover;
        transform:rotate(90deg);
        transition:all .4s ease;
        filter:brightness(0)saturate(100%);
        z-index:-1
    }
    .price-block-header,
    .color-product-search-head {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:140%;
        z-index:1
    }
    .color-select-main {
        position:relative
    }
    .color-product-search {
        display:flex;
        align-items:center;
        padding:10px 20px;
        position:relative;
        cursor:pointer
    }
    .color-product-search::after {
        border-radius:4px
    }
    .color-product-body input:checked+.color-product-search::after {
        background-image:url(../img/square-Xe1eXAj.svg)
    }
    .color-category-choose {
        opacity:0;
        visibility:hidden;
        transition:all .4s linear;
        transform:translate(0,0)
    }
    .color-select-main.active .color-category-choose {
        opacity:1;
        visibility:visible;
        transform:translate(0,8px);
        z-index:11;
        width:max-content
    }
    .color-product-search-head {
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:4px 4px 4px 8px;
        position:relative
    }
    .color-product-search-head span {
        display:block;
        width:100%;
        padding-right:30px;
        cursor:pointer
    }
    .popular-elements-select .color-product-search::after {
        border-radius:50%
    }
    .color-product-body {
        display:block
    }
    .popular-elements-select .color-product-body input:checked+.color-product-search::after {
        background-image:url(../img/circle-opt-M5QG5_S.svg)
    }
    .color-select-main.active .color-product-search-head::after {
        transform:rotate(-90deg)
    }
    .my-selection-class {
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        position:absolute;
        top:0;
        background:#3b3b3b;
        left:0;
        right:0;
        bottom:0;
        display:flex;
        align-items:baseline;
        padding:6px 8px
    }
    .my-selection-class span {
        color:#939393;
        font-size:12px;
        margin-left:5px
    }
    .color-product-search-head .my-selection-class {
        position:relative;
        z-index:9;
        margin:-4px -4px -4px -8px;
        border-radius:4px;
        padding-right:30px;
        display:flex;
        width:auto
    }
    .color-product-search-head .my-selection-class span {
        padding:0;
        width:auto
    }
    .color-product-search-head .close-select-result,
    .price-block-header .close-select-result {
        width:24px;
        height:24px;
        transition:all .4s ease;
        z-index:13;
        position:absolute;
        top:0;
        right:4px;
        bottom:0;
        margin:auto;
        cursor:pointer
    }
    .color-product-search span {
        width:16px;
        height:16px;
        border-radius:4px;
        margin:0 4px;
        border:1px solid #f1f1f1
    }
    .range-slider {
        height:4px;
        position:relative;
        background-color:#ededed;
        border-radius:4px
    }
    .range-selected {
        height:100%;
        left:0;
        right:0;
        position:absolute;
        border-radius:5px;
        background-color:#d6d6d6
    }
    .range-input {
        position:relative
    }
    .range-input input {
        position:absolute;
        width:100%;
        height:5px;
        top:-6px;
        background:0 0;
        pointer-events:none;
        -webkit-appearance:none;
        -moz-appearance:none;
        outline:none
    }
    .range-input input::-webkit-slider-thumb {
        height:10px;
        width:10px;
        border-radius:50%;
        background-color:#3b3b3b;
        margin-bottom:-3px;
        pointer-events:auto;
        -webkit-appearance:none
    }
    .range-input input::-moz-range-thumb {
        height:10px;
        width:10px;
        border-radius:50%;
        background-color:#3b3b3b;
        margin-bottom:-3px;
        pointer-events:auto;
        -moz-appearance:none
    }
    .range-price {
        margin:25px 0 0;
        width:100%;
        display:flex;
        align-items:center;
        position:relative
    }
    .range-price .range-input-block {
        padding:8px 10px;
        background:#f6f6f6;
        color:#3b3b3b;
        font-family:mont-reg;
        font-size:14px;
        line-height:22px;
        width:50%;
        display:flex;
        align-items:center;
        border-radius:4px 0 0 4px;
        height:30px;
        border:1px solid #d6d6d6
    }
    .range-price .range-input-block:last-child {
        border-radius:0 4px 4px 0;
        border-left:0
    }
    .range-price input::placeholder {
        color:#757575
    }
    .range-price input {
        width:100%;
        border:0;
        background:0 0;
        outline:none;
        margin-left:4px;
        padding:0
    }
    .range-price input::-webkit-outer-spin-button,
    .range-price input::-webkit-inner-spin-button {
        -webkit-appearance:none;
        margin:0
    }
    .filter-range-price {
        width:max-content;
        padding:20px;
        border-radius:4px;
        border:1px solid #d6d6d6;
        background:#fff;
        position:absolute;
        overflow:hidden;
        max-width:280px
    }
    .select-main-block {
        max-height:300px;
        overflow-y:auto;
        display:flex;
        flex-direction:column;
        top:0;
        left:0;
        position:relative
    }
    .select-main-block::-webkit-scrollbar {
        width:4px;
        height:4px
    }
    .select-main-block::-webkit-scrollbar-thumb {
        border-radius:10px;
        background:#d6d6d6
    }
    .select-main-block::-webkit-scrollbar-track {
        border-radius:10px;
        background:#f6f6f6
    }
    .price-product.active .price-block-header::after {
        transform:rotate(-90deg)
    }
    .price-product .filter-parent-block {
        z-index:10;
        position:absolute;
        top:100%;
        transform:translate(-180px,8px);
        opacity:0;
        visibility:hidden;
        transition:all .4s linear;
        width:0
    }
    .price-product .filter-parent-block .filter-range-price {
        width:100%
    }
    .price-product.active .filter-parent-block {
        opacity:1;
        visibility:visible;
        width:260px
    }
    .color-select-main.size-product .filter-range-price {
        width:260px
    }
    .reset-select-block {
        color:#eb5a55;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        position:relative;
        height:max-content;
        margin:auto 0;
        cursor:pointer;
        transition:all .4s ease;
        opacity:0;
        visibility:hidden;
        height:0;
        width:0
    }
    .reset-select-block::after {
        position:absolute;
        content:'';
        bottom:-6px;
        left:0;
        right:0;
        height:1px;
        background:#eb5a55
    }
    .reset-select-block.active {
        opacity:1;
        visibility:visible;
        height:max-content;
        width:auto
    }
    .product-section {
        padding:40px 0 30px
    }
    .product-hover-more {
        z-index:9;
        transition:all .4s ease;
        display:flex;
        align-items:center;
        justify-content:center;
        text-align:center;
        padding:40px;
        height:100%
    }
    .product-hover-more img {
        width:100%;
        height:100%;
        object-fit:cover;
        position:absolute;
        z-index:-9
    }
    .product-hover-title {
        color:#fff;
        font-family:tt-bold;
        font-size:24px;
        line-height:142.765%;
        margin-bottom:20px
    }
    .product-hover-review {
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .btn-more-product {
        color:#fff;
        font-size:14px;
        background:0 0;
        width:max-content;
        margin:60px auto 0;
        border:1px solid #fff
    }
    .btn-more-product:hover {
        color:#3b3b3b;
        background:#fff
    }
    .product-hover-block {
        margin:auto;
        z-index:11
    }
    .product-filter-card {
        width:33.3%;
        position:relative;
        padding:10px
    }
    .product-filter-card .product-card-main {
        padding:0;
        overflow:unset;
        border-radius:4px
    }
    .product-filter-main-content {
        display:flex;
        flex-wrap:wrap;
        margin:-10px
    }
    .product-card-type {
        position:absolute;
        padding:8px 16px;
        color:#3b3b3b;
        font-family:mont-med;
        font-size:14px;
        line-height:normal;
        top:30px;
        left:10px;
        z-index:9
    }
    .product-card-type svg {
        width:20px;
        height:20px
    }
    .news-product {
        background:#f2efe4
    }
    .sale-product {
        color:#fff;
        background:#eb5a55
    }
    .premium-product {
        color:#fff;
        background:#3b3b3b
    }
    .product-last-card img {
        position:unset;
        height:205px;
        width:100%;
        object-fit:cover
    }
    .product-last-card .product-hover-more {
        opacity:1;
        visibility:visible;
        transform:translate(0,0);
        position:unset;
        flex-direction:column;
        padding:0
    }
    .product-last-card .product-hover-block div {
        color:#3b3b3b
    }
    .product-last-card .product-hover-block {
        padding:20px 20px 45px;
        border:1px solid #efefef;
        border-radius:0 0 4px 4px
    }
    .product-last-card .product-hover-block .btn-more-product {
        border:1px solid #3b3b3b;
        color:#3b3b3b
    }
    .product-last-card .product-hover-block .btn-more-product:hover {
        color:#fff;
        background:#3b3b3b
    }
    .product-last-card .product-card-main {
        border-radius:0
    }
    .show-more-card {
        color:#fff;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        border-radius:4px;
        background:#eb5a55;
        padding:12px 25px;
        width:350px;
        display:flex;
        justify-content:center;
        margin:16px auto
    }
    .show-more-card:hover {
        color:#fff;
        background:#f9423c
    }
    .pagination-card-body {
        display:flex;
        justify-content:center;
        align-items:center;
        gap:12px
    }
    .pagination-card-body .page-item {
        width:40px;
        height:40px
    }
    .pagination-card-body .page-item .page-link {
        border:0;
        width:100%;
        height:100%;
        border-radius:50%;
        color:#3b3b3b;
        font-family:mont-semi;
        font-size:20px;
        line-height:normal;
        display:flex;
        padding:10px;
        justify-content:center
    }
    .pagination-card-body .page-item .page-link:hover {
        background:#f6f6f6
    }
    .pagination-card-body .page-item.active .page-link {
        background:#3b3b3b;
        color:#fff
    }
    .pagination-card-body .page-item svg {
        width:100%;
        height:100%
    }
    .pagination-card-body .page-item:first-child svg {
        transform:rotate(180deg)
    }
    .image-advance {
        width:100%;
        aspect-ratio:1312/420;
        margin-top:40px
    }
    .save-change-filter {
        /* display:none */
    }
    .card-left-block {
        width:98px;
        height:98px;
        border-radius:4px;
        padding:3px;
        transition:unset;
        overflow:hidden;
        display:block;
        outline:none;
        border:1px solid #ddd;
        text-align:center;
        box-sizing:border-box
    }
    .card-left-block.active {
        border:1px solid #f9423c
    }
    .card-left-block:hover {
        border-color:#a66764
    }
    .card-center-body img {
        width:100%
    }
    .card-left-content {
        display:flex;
        flex-direction:column;
        gap:10px;
        height:max-content;
        position:sticky;
        top:30px
    }
    .card-center-main+.card-center-main {
        padding-top:10px
    }
    .card-center-body {
        width:calc(55% - 92px);
        padding:0 0 0 20px;
        transition:all .4s linear;
        display:flex;
        flex-direction:column
    }
    .card-center-body.sticky_header {
        height:auto
    }
    .card-content-body {
        display:flex
    }
    .card-name {
        color:#000;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:20px;
        text-align:center
    }
    .card-category-name,
    .card-sizes-name {
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        text-align:center
    }
    .card-sizes-name {
        margin-bottom:20px;
        color:#3b3b3b
    }
    .card-size-main {
        display:flex;
        flex-wrap:wrap;
        margin:-10px
    }
    .sizes-name-main {
        width:100%;
        border-radius:4px;
        background:#f0f0f0;
        padding:10px 20px;
        transition:all .3s linear;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer
    }
    .sizes-name-main:hover {
        background:#f6f6f6
    }
    .card-options-body {
        margin-top:32px
    }
    .card-options-right-body {
        width:424px;
        margin-left:auto;
        height:max-content
    }
    article {
        height:auto
    }
    .sticky {
        position:fixed;
        z-index:101
    }
    .stop {
        position:relative;
        z-index:101
    }
    .card-options-right-main {
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:40px;
        width:100%
    }
    .sizes-content-block {
        padding:5px;
        width:25%
    }
    .sizes-content-block input:checked+div {
        background:#3b3b3b;
        color:#fff
    }
    .card-colors-main .sizes-content-block input:checked+div {
        border-color:#939393;
        background:0 0
    }
    .card-colors-main .sizes-name-main {
        height:39px;
        border:2px solid transparent
    }
    .card-price-block .product-price {
        font-size:24px;
        justify-content:center
    }
    .card-price-block {
        border-top:#d6d6d6;
        padding-top:32px;
        margin-top:32px;
        border-top:1px solid #d6d6d6
    }
    .card-add-basket-block {
        color:#fff;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        display:flex;
        align-items:center;
        justify-content:center;
        width:100%;
        border:0;
        border-radius:4px;
        background:#eb5a55;
        padding:10px;
        margin-top:32px
    }
    .card-add-basket-block:hover {
        background:#f9423c
    }
    .card-add-basket-block svg {
        width:24px;
        height:24px;
        margin-left:10px
    }
    .card-review-product,
    .card-review-product-main {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        position:relative
    }
    .card-review-product {
        padding:0;
        border:0;
        cursor:pointer
    }
    .card-review-product-main li {
        font-size:14px;
        list-style:none;
        position:relative;
        padding:0 0 0 35px
    }
    .card-review-product-main li::after {
        position:absolute;
        content:'';
        left:10px;
        top:10px;
        margin:auto;
        width:8px;
        height:1px;
        background:#3b3b3b
    }
    .card-review-product-main li+li {
        margin-top:15px
    }
    .card-review-product-main {
        margin:0;
        padding:22px 0 0
    }
    .card-review-product::after {
        content:'';
        position:absolute;
        top:0;
        margin:auto;
        bottom:0;
        right:10px;
        background-image:url(../img/arrow-PUk_Zjn.svg);
        background-repeat:no-repeat;
        background-position:50%;
        background-size:cover;
        transform:rotate(90deg);
        transition:all .4s ease;
        width:24px;
        height:24px
    }
    .card-options-category {
        padding:22px 0 0;
        margin-top:32px;
        border-top:1px solid #d6d6d6
    }
    .card-options-category+.card-options-category {
        margin-top:22px
    }
    .card-review-product-main {
        height:0;
        overflow:hidden;
        opacity:0;
        padding:0;
        transition:all .4s linear
    }
    .card-options-content.active .card-review-product-main {
        padding:22px 0 0;
        height:auto;
        opacity:1
    }
    .card-options-content.active .card-review-product::after {
        transform:rotate(-90deg)
    }
    .card-option-review {
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        position:relative
    }
    .card-option-review span,
    .card-option-review a {
        color:#3b3b3b;
        margin-top:10px;
        display:block
    }
    .card-option-review a {
        color:#eb5a55
    }
    .card-option-review a:hover {
        color:#f9423c
    }
    .option-copy-main {
        position:absolute;
        right:0;
        top:0;
        bottom:0;
        margin:auto;
        opacity:0;
        visibility:hidden;
        transition:all .4s linear;
        display:flex;
        align-items:center;
        justify-content:center
    }
    .option-copy-main svg {
        width:24px;
        height:24px;
        cursor:pointer
    }
    .card-option-review:hover .option-copy-main {
        opacity:1;
        visibility:visible
    }
    .show-copied {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:10px;
        position:absolute;
        top:-100%;
        right:0;
        opacity:0;
        visibility:hidden;
        transition:all .4s linear;
        background:#fff
    }
    .show-copied.active {
        opacity:1;
        visibility:visible
    }
    .btn-more-about-product {
        width:100%;
        margin-top:32px;
        justify-content:center;
        background:#d6d6d6;
        color:#3b3b3b
    }
    .btn-more-about-product:hover {
        color:#fff
    }
    .basket-title {
        margin-bottom:40px
    }
    .basket-prod-image {
        width:90px;
        height:90px;
        display:flex
    }
    .basket-prod-image img {
        width:100%;
        height:100%;
        object-fit:contain
    }
    .basket-prod-name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        margin-bottom:12px;
        display:block
    }
    .basket-prod-name:hover {
        color:#eb5a55
    }
    .basket-prod-options {
        display:flex;
        flex-wrap:wrap;
        gap:20px;
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .basket-prod-options span {
        display:block
    }
    .basket-prod-review {
        width:40%;
        padding-left:35px
    }
    .basket-prod-rev-main {
        display:flex;
        align-items:center;
        width:calc(100% - 90px)
    }
    .basket-count {
        display:flex;
        align-items:center;
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:8px 12px
    }
    .basket-count .quantity {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        border:0;
        text-align:center;
        outline:none
    }
    .basket-count button {
        width:24px;
        height:24px;
        border:0;
        outline:none;
        padding:0;
        background:0 0;
        display:flex
    }
    .basket-count button svg {
        width:100%;
        height:100%
    }
    .basket-count button svg:hover path {
        stroke:#3b3b3b
    }
    .basket-prod-price {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-left:20px
    }
    .basket-count-price-block {
        display:flex;
        margin-left:auto;
        align-items:center;
        padding-right:20px
    }
    .basket-prod-content {
        display:flex;
        position:relative;
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:20px;
        align-items:center
    }
    .basket-prod-content+.basket-prod-content {
        margin-top:20px
    }
    .basket-close-prod {
        width:23px;
        height:23px;
        position:absolute;
        top:15px;
        right:15px;
        cursor:pointer
    }
    .basket-close-prod path {
        stroke-width:2px;
        transition:all .4s ease
    }
    .basket-close-prod:hover path {
        stroke:#3b3b3b
    }
    .basket-prod-body {
        width:70%;
        padding-right:20px
    }
    .your-order-ttl {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:32px;
        text-align:center
    }
    .order-prod-options {
        display:flex;
        align-items:center;
        justify-content:space-between;
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        padding:20px 0;
        border-top:1px solid #d6d6d6
    }
    .order-prod-options.hide {
        /* display:none */
    }
    .order-prod-options span {
        color:#3b3b3b
    }
    .order-total-price {
        border-bottom:1px solid #d6d6d6
    }
    .order-total-price span {
        font-size:24px
    }
    .order-remember-txt {
        color:#939393;
        font-family:tt-med;
        font-size:12px;
        line-height:normal;
        padding-top:10px
    }
    .order-applic-btn:hover {
        color:#fff
    }
    .order-prod-body {
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:40px
    }
    .order-prod-main {
        width:30%;
        height:max-content;
        position:sticky;
        top:100px
    }
    .basket-prod-flex {
        display:flex
    }
    .basket-count-header {
        position:absolute;
        color:#fff;
        font-family:tt-med;
        font-size:12px;
        line-height:normal;
        border-radius:20px;
        background:#eb5a55;
        display:flex;
        align-items:center;
        justify-content:center;
        width:22px;
        height:22px;
        top:4px;
        left:0;
        opacity:0;
        visibility:hidden
    }
    .basket-count-header.active {
        opacity:1;
        visibility:visible
    }
    .form-name-block {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:32px
    }
    .form-input-txt {
        color:#939393;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        margin-bottom:10px
    }
    .form-input-main {
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:12px 24px;
        width:100%;
        outline:none;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .form-input-main::placeholder {
        color:#d6d6d6
    }
    .form-block-input {
        width:33.3%
    }
    .form-block-input-flex {
        display:flex;
        gap:20px
    }
    .form-block-orders+.form-block-orders {
        margin-top:60px
    }
    .form-block-orders+.form-delivery-block {
        margin:0
    }
    .form-delivery-block {
        height:0;
        overflow:hidden;
        opacity:0;
        transition:all .4s ease
    }
    .form-delivery-block.active {
        height:auto;
        overflow:unset;
        opacity:1;
        margin-top:60px
    }
    .courier-address-name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        margin-bottom:8px
    }
    .courier-price-name {
        color:#939393;
        font-family:tt-med;
        font-size:12px;
        line-height:normal
    }
    .courier-review {
        position:relative;
        padding-left:44px
    }
    .courier-review::after {
        position:absolute;
        left:0;
        width:24px;
        height:24px;
        border-radius:50%;
        border:1px solid #3b3b3b;
        transition:all .4s linear;
        background-position:50%;
        background-repeat:no-repeat;
        content:'';
        margin:auto;
        top:0;
        bottom:0;
        background-size:63%
    }
    .courier-review-main input:checked+.courier-review::after {
        background-image:url(../img/circle-opt-M5QG5_S.svg)
    }
    .courier-review-main {
        width:100%;
        cursor:pointer
    }
    .courier-review-main+.courier-review-main {
        margin-top:20px
    }
    .form-block-input-address {
        display:flex;
        flex-wrap:wrap;
        margin:-10px
    }
    .form-block-input-address .form-block-input {
        width:50%;
        padding:10px
    }
    .form-block-input-address .form-block-input:nth-child(n+3) {
        width:25%
    }
    .btn-promocode-block {
        margin:0 0 10px 10px;
        padding:13px 24px
    }
    .form-block-promocode {
        display:flex;
        align-items:flex-end
    }
    .form-block-promocode .form-block-input {
        width:65%
    }
    .empty-review-txt {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:142.765%;
        margin:20px 0 40px;
        width:65%
    }
    .empty-review-txt+.empty-review-txt {
        margin:-20px 0 40px
    }
    .delivery-review-main p {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        margin:0
    }
    .delivery-review-main p+p {
        margin-top:25px
    }
    .delivery-review-main p span {
        color:#eb5a55
    }
    .delivery-review-main div {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:30px
    }
    .delivery-review-main p+div {
        margin-top:40px
    }
    .delivery-review-main {
        width:50%
    }
    .delivery-image-block {
        width:50%;
        border-radius:4px;
        overflow:hidden;
        max-height:800px
    }
    .delivery-image-block img {
        width:100%;
        object-fit:cover;
        height:100%
    }
    .delivery-main-flex {
        display:flex;
        gap:40px
    }
    .exchange-content-block p,
    .exchange-content-block ul li {
        margin:0;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:140%
    }
    .exchange-content-block p+p {
        margin-top:15px
    }
    .exchange-content-block div {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:30px
    }
    .exchange-content-block p+div {
        margin-top:40px
    }
    .exchange-content-block ul {
        margin:0
    }
    .exchange-content-block p+ul {
        margin-top:15px
    }
    .exchange-content-block ul+p {
        margin:15px 0 0
    }
    .exchange-content-block ul+div {
        margin:15px 0 0
    }
    .sertificate-content p {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:140%;
        margin:-20px 0 40px
    }
    .sertificate-card-main {
        width:25%;
        padding:10px 15px;
        height:445px
    }
    .sertificate-card-main img {
        width:100%;
        height:100%;
        object-fit:cover
    }
    .sertificate-card-body {
        display:flex;
        flex-wrap:wrap;
        margin:-10px -15px 30px
    }
    .contacts-head-title h1 {
        margin:0
    }
    .contacts-head-title {
        display:flex;
        justify-content:space-between;
        margin-bottom:40px
    }
    .contacts-head-title .del-called {
        margin:0
    }
    .contacts-address-offices {
        color:#eb5a55;
        font-family:tt-med;
        font-size:20px;
        line-height:normal;
        position:relative;
        display:block;
        margin-bottom:55px;
        width:max-content;
        padding:14px 0;
        pointer-events:none
    }
    .contacts-address-offices:hover {
        color:#f9423c
    }
    .contacts-address-offices::after {
        position:absolute;
        content:'';
        left:0;
        right:0;
        height:1px;
        background:#eb5a55;
        bottom:0
    }
    .contacts-title-info {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:20px
    }
    .contacts-name-info {
        color:#3b3b3b;
        font-family:tt-reg;
        font-size:20px;
        line-height:127.169%;
        display:block;
        margin-bottom:10px
    }
    a.contacts-name-info:hover {
        color:#eb5a55
    }
    .contacts-work {
        color:#939393;
        font-family:tt-reg;
        font-size:12px;
        line-height:127.169%
    }
    .contacts-info-content {
        width:33.3%;
        padding:10px
    }
    .contacts-info-body {
        display:flex;
        flex-wrap:wrap;
        margin:-10px
    }
    .contacts-info-main+.contacts-info-main {
        margin-top:60px
    }
    .contacts-left-info-block {
        width:100%;
        flex-wrap:wrap;
        display:flex
    }
    .contacts-phones-info {
        width:50%;
        padding:10px
    }
    .contacts-phones-info-main {
        display:flex;
        flex-wrap:wrap;
        margin:-10px
    }
    .subscribe-text-info {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:127.169%;
        margin-bottom:40px
    }
    .btn-vk-subscribe {
        border-radius:4px;
        background:#eb5a55;
        padding:12px 25px;
        margin:0 auto
    }
    .btn-vk-subscribe:hover {
        color:#fff;
        background:#f9423c
    }
    .subscribe-info-content {
        border-radius:4px;
        background:rgba(246,246,246,.9);
        position:relative;
        padding:20px 40px;
        text-align:center;
        margin-top:60px;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        z-index:1;
        width:33.3%
    }
    .contacts-right-info-block {
        width:66.6%;
        padding-top:60px
    }
    .contacts-right-info-block .contacts-info-content {
        width:50%
    }
    .contacts-info-main {
        width:100%
    }
    .contacts-info-flex {
        display:flex
    }
    .subscribe-info-image {
        filter:brightness(0)saturate(100%)invert(82%)sepia(6%)saturate(137%)hue-rotate(179deg)brightness(115%)contrast(91%);
        position:absolute;
        top:0;
        bottom:0;
        left:0;
        right:0;
        margin:auto;
        width:90%;
        z-index:-1
    }
    .map-contacts {
        width:100%;
        height:460px
    }
    .requisites-txt {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:normal;
        padding-top:10px
    }
    .requisites-txt p {
        margin:0
    }
    .requisites-txt p+p {
        margin:20px 0 0
    }
    .requisites-section {
        padding:60px 0
    }
    .contacts-section {
        padding:40px 0 60px
    }
    .about-company-content {
        width:50%;
        padding-right:120px
    }
    .about-company-content div {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:30px
    }
    .about-company-content p {
        margin:0;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .about-company-content p+p {
        margin-top:2px
    }
    .trands-image-block.about-company-image {
        width:50%;
        padding:0
    }
    .trands-image-block.about-company-image img:first-child {
        aspect-ratio:424/418;
        height:auto;
        width:70%
    }
    .trands-image-block.about-company-image img:last-child {
        right:0
    }
    .trands-image-block.about-company-image img {
        border-radius:2px
    }
    .about-company-flex {
        display:flex;
        align-items:center
    }
    .about-company-flex:nth-child(even) {
        flex-direction:row-reverse
    }
    .about-company-flex:nth-child(even) .about-company-content {
        padding:0 0 0 120px
    }
    .about-company-flex+.about-company-flex {
        margin-top:60px
    }
    .subscribe-about-txt {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:127.169%;
        width:80%
    }
    .subscribe-about-main {
        border-radius:4px;
        background:rgba(246,246,246,.9);
        padding:20px 40px;
        margin-top:40px;
        display:flex;
        align-items:center
    }
    .personal-accaunt-name {
        width:88px;
        height:88px;
        min-width:88px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:15px;
        margin-right:20px
    }
    .personal-accaunt-name {
        color:rgba(242,239,228,.89);
        font-family:tt-med;
        font-size:36px;
        line-height:normal;
        background:#eb5a55
    }
    .personal-user-name {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal
    }
    .personal-user-name-head {
        display:flex;
        padding:10px 20px;
        position:relative;
        align-items:center
    }
    .personal-edit-svg {
        width:24px;
        height:24px;
        position:absolute;
        top:0;
        right:0;
        cursor:pointer
    }
    .personal-edit-svg:hover path {
        stroke:#f9423c
    }
    .personal-data-body {
        border-radius:4px;
        background:#f6f6f6;
        padding:32px;
        width:425px
    }
    .personal-user-information {
        padding:32px 0;
        margin:32px 0;
        border:1px solid #d6d6d6;
        border-width:1px 0
    }
    .user-info-content span {
        color:#939393;
        font-family:tt-reg;
        font-size:12px;
        line-height:127.169%;
        margin-bottom:10px;
        display:block
    }
    .user-info-content div {
        color:#3b3b3b;
        font-family:tt-reg;
        font-size:20px;
        line-height:127.169%;
        display:block
    }
    .user-info-content+.user-info-content {
        margin-top:32px
    }
    .user-change-password {
        color:#eb5a55;
        font-family:tt-med;
        font-size:20px;
        line-height:normal;
        cursor:pointer;
        transition:all .4s linear
    }
    .user-change-password:hover {
        color:#f9423c
    }
    .user-change-password+.user-change-password {
        margin-top:32px
    }
    .history-applic-txt {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:24px;
        line-height:normal;
        margin-bottom:28px
    }
    .applic-info:nth-child(1) {
        min-width:39%
    }
    .applic-info.applic-info-send-mail {
        width:25%
    }
    .applic-info.applic-info-status {
        width:18%;
        margin-left:auto
    }
    .applic-info span {
        color:#939393;
        font-family:tt-med;
        font-size:12px;
        line-height:normal;
        display:block;
        margin-bottom:10px
    }
    .applic-info div {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .applic-info:nth-child(1) div {
        font-size:16px
    }
    .applic-status {
        /* display:none */
    }
    .applic-price {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:normal;
        width:18%;
        text-align:flex-end
    }
    .applic-info-content {
        display:flex;
        justify-content:space-between;
        margin-bottom:10px
    }
    .applic-more-btn {
        color:#eb5a55;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        position:relative;
        padding-right:34px;
        text-align:end;
        cursor:pointer
    }
    .applic-more-btn::after {
        position:absolute;
        content:'';
        right:0;
        top:0;
        bottom:0;
        width:24px;
        height:24px;
        background-image:url(../img/arrow-PUk_Zjn.svg);
        background-position:50%;
        background-repeat:no-repeat;
        background-size:cover;
        filter:brightness(0)saturate(100%)invert(41%)sepia(90%)saturate(483%)hue-rotate(316deg)brightness(100%)contrast(84%);
        transform:rotate(90deg);
        transition:all .4s linear;
        margin:auto
    }
    .applic-more-btn.active::after {
        transform:rotate(-90deg)
    }
    .applic-card-content img {
        width:60px;
        height:60px;
        object-fit:contain;
        min-width:60px
    }
    .applic-card-review {
        display:flex;
        width:calc(80% - 60px);
        padding-left:20px;
        gap:35px
    }
    .applic-card-review a {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        display:block
    }
    .applic-card-review-texts {
        color:#939393;
        font-family:tt-reg;
        font-size:12px;
        line-height:normal;
        display:flex;
        flex-direction:column;
        gap:10px
    }
    .applic-card-price {
        color:#3b3b3b;
        text-align:right;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        margin-left:auto
    }
    .history-card-info-body {
        width:calc(100% - 425px);
        padding-left:20px
    }
    .personal-info-and-card-flex {
        display:flex
    }
    .applic-info-body {
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:20px
    }
    .applic-info-body+.applic-info-body {
        margin-top:20px
    }
    .applic-card-info-main {
        opacity:0;
        visibility:hidden;
        overflow:hidden;
        height:0;
        transition:all .4s linear
    }
    .applic-card-info-main.active {
        padding-top:20px;
        margin-top:20px;
        border-top:1px solid #d6d6d6;
        opacity:1;
        visibility:visible;
        height:auto
    }
    .applic-card-content {
        display:flex;
        width:56%
    }
    .applic-card-content+.applic-card-content {
        margin-top:10px
    }
    .applic-card-delivery-img {
        width:24px;
        height:24px;
        margin-right:35px
    }
    .text-delivery-applic {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:14px;
        line-height:normal
    }
    .price-delivery-applic {
        color:#3b3b3b;
        text-align:right;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        margin-left:auto
    }
    .delivery-applic-content {
        border-radius:4px;
        background:#f6f6f6;
        padding:8px 26px 8px 20px;
        display:flex;
        align-items:center;
        margin-top:15px;
        width:59%
    }
    .head_main_info .personal-accaunt-name {
        font-size:12px;
        width:28px;
        height:28px;
        min-width:24px;
        padding:5px;
        margin-right:10px
    }
    .head_main_info .personal-user-name {
        font-size:16px
    }
    .head_main_info .personal-user-name-head {
        padding:0
    }
    .history-empty-txt {
        color:#3b3b3b;
        font-family:tt-reg;
        font-size:16px;
        line-height:127.169%;
        margin-bottom:28px;
        width:50%
    }
    .news-main-content {
        display:flex;
        flex-wrap:wrap;
        margin:-10px -10px 30px
    }
    .news-main-content .news-card-main {
        padding:10px;
        width:25%
    }
    .news-article-block img {
        width:100%;
        aspect-ratio:980/445;
        margin-bottom:40px;
        object-fit:cover
    }
    .news-article-block {
        width:80%
    }
    .article-read-more {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:normal
    }
    .article-read-right-block {
        width:20%;
        position:sticky;
        top:30px;
        height:max-content;
        display:flex;
        flex-direction:column;
        gap:32px
    }
    .article-read-right-block .news-card-main {
        width:100%;
        padding:0
    }
    .article-read-right-block .news-img-main {
        height:190px
    }
    .article-content-body {
        display:flex;
        gap:40px
    }
    .article-section {
        padding:40px 0 120px
    }
    .article-read-right-block .slider-elements-content {
        /* display:none */
    }
    .article-main {
        display:flex;
        flex-direction:column;
        gap:32px
    }
    .search-section {
        padding:40px 0 30px
    }
    .search-section .product-filter-card {
        width:25%
    }
    .search-section .product-title-main {
        font-size:28px
    }
    .empty-search-txt {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:20px;
        line-height:142.765%;
        margin-bottom:40px;
        padding-top:20px;
        width:55%
    }
    .error-image {
        height:505px;
        width:100%;
        margin-bottom:40px
    }
    .error-image.error404 {
        background:url(../img/error-F3GsP9f.jpg)no-repeat 50% 0
    }
    .error_other_codes {
        margin-bottom:40px;
        color:#eb5a55;
        text-align:center
    }
    .error_other_codes span {
        font:36px/40px tt-med
    }
    .error-text {
        color:#3b3b3b;
        text-align:center;
        font-family:tt-med;
        font-size:20px;
        line-height:147.885%;
        padding:0 30px;
        font-style:italic
    }
    .error-text a {
        color:#eb5a55
    }
    .error-text a:hover {
        color:#f9423c
    }
    .error-content {
        width:80%;
        margin:auto;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center
    }
    .modal-title-head {
        color:#3b3b3b;
        text-align:center;
        font-family:tt-bold;
        font-size:24px;
        line-height:140%;
        text-transform:uppercase;
        margin-bottom:30px
    }
    .modal-content-main {
        border-radius:20px;
        background:#fff;
        padding:40px 40px 30px;
        border:0
    }
    .modal-input-block input {
        border-radius:10px;
        border:1px solid #d6d6d6;
        background:#fff;
        padding:12px 20px;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        width:100%;
        outline:none
    }
    .modal-input-block input::placeholder {
        color:#939393
    }
    .modal-input-text {
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        margin-bottom:10px
    }
    .modal-input-block+.modal-input-block {
        margin-top:30px
    }
    .modal-input-block {
        position:relative
    }
    .eye-password-main {
        position:absolute;
        bottom:12px;
        right:20px;
        width:24px;
        height:24px;
        display:flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        flex-direction:column
    }
    .eye-password-main svg {
        width:0;
        height:0;
        opacity:0;
        visibility:hidden;
        transition:all .4s linear
    }
    .eye-password-main.active svg.eye-hide {
        width:100%;
        height:100%;
        opacity:1;
        visibility:visible
    }
    .eye-password-main:not(.active) svg.eye-show {
        width:100%;
        height:100%;
        opacity:1;
        visibility:visible
    }
    .enter-btn-form {
        color:#fff;
        font-family:tt-med;
        font-size:14px;
        line-height:normal;
        border-radius:4px;
        background:#eb5a55;
        padding:14px 30px;
        border:0;
        min-width:200px;
        display:flex;
        justify-content:center;
        margin:60px auto 0
    }
    .enter-btn-form:hover {
        background:#f9423c
    }
    .enter-not-user-account {
        color:#3b3b3b;
        text-align:center;
        font-family:tt-reg;
        font-size:12px;
        line-height:143.885%;
        margin-top:20px
    }
    .enter-not-user-account a {
        color:#eb5a55
    }
    .enter-not-user-account a:hover {
        color:#f9423c
    }
    .modal-log-in {
        max-width:720px
    }
    .modal-body-content {
        position:relative
    }
    .modal-close-block {
        position:absolute;
        width:30px;
        height:30px;
        top:18px;
        right:22px;
        cursor:pointer
    }
    .modal-close-block path {
        stroke-width:1.8px
    }
    .modal-content-main .modal-body {
        padding:0
    }
    .modal-sub-title,
    .result-search-brand {
        color:#3b3b3b;
        text-align:center;
        font-family:tt-med;
        font-size:16px;
        line-height:127.7%;
        margin-bottom:30px
    }
    .result-search-brand {
        margin:0;
        text-align:start
    }
    .consent-personal-data {
        color:#3b3b3b;
        text-align:center;
        font-family:tt-reg;
        font-size:12px;
        line-height:143.885%;
        width:80%;
        margin-right:20px
    }
    .consent-content-pd {
        display:flex;
        align-items:center;
        margin-top:60px
    }
    .consent-content-pd button {
        margin:0
    }
    .input-search-brands {
        position:relative;
        margin-bottom:10px
    }
    .input-search-brands input {
        border-radius:4px;
        border:1px solid #d6d6d6;
        padding:12px;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal;
        position:relative;
        outline:none;
        width:100%
    }
    .input-search-brands input::placeholder {
        color:#939393
    }
    .input-search-brands::after {
        position:absolute;
        content:'';
        right:12px;
        top:0;
        bottom:0;
        margin:auto;
        width:24px;
        height:24px;
        background-image:url(../img/search-dWGYoXD.svg);
        background-position:50%;
        background-size:cover;
        background-repeat:no-repeat
    }
    .slider-main .slick-list {
        padding-bottom:30px
    }
    @media(max-width:1550px) {
        .social_nets-main {
            right:-75px
        }
    }
    @media(max-width:1500px) {
        .social_nets-main {
            right:-52px
        }
    }
    @media(max-width:1450px) {
        .social_nets-main {
            right:-20px
        }
    }
    @media(max-width:1400px) {
        .contacts-left-info-block {
            width:100%;
            padding:0
        }
        .contacts-info-flex {
            flex-wrap:wrap;
            gap:40px
        }
        .contacts-right-info-block .contacts-info-content {
            width:50%
        }
        .subscribe-info-content {
            width:50%
        }
        .contacts-right-info-block {
            width:50%
        }
        .contacts-info-content {
            width:50%
        }
    }
    @media(max-width:1350px) {
        .contacts-footer {
            gap:30px
        }
        .catalog-content {
            width:17%
        }
        .product-list {
            flex-wrap:wrap
        }
        .social_nets-main {
            right:-12px
        }
        .buyer_rows-tabs .category_products a {
            min-width:185px
        }
        .buyer_rows-tabs {
            width:45%
        }
        .sertificate-card-main {
            width:33.3%;
            height:auto;
            min-height:480px
        }
        .subscribe-info-image {
            width:90%;
            height:90%
        }
        .history-card-info-body {
            width:calc(100% - 380px)
        }
        .personal-data-body {
            width:380px
        }
        .article-read-right-block .news-img-main {
            height:160px
        }
        .search-section .product-filter-card {
            width:33.3%
        }
        .sizes-content-block {
            width:33.3%
        }
    }
    @media(max-width:1200px) {
        .buyer_rows-tabs {
            width:60%
        }
        .buyer_rows-tabs .category_products a {
            min-width:220px
        }
        .product-content {
            width:90px;
            min-width:90px
        }
        .product-content-main {
            overflow-x:scroll
        }
        .product-content-main::-webkit-scrollbar {
            /* display:none */
        }
        .trands-image-block {
            padding:0 90px
        }
        .trands-image-block img:first-child {
            height:460px
        }
        .trands-image-block img:last-child {
            height:220px
        }
        .trands-main-block {
            width:calc(100% - 68%)
        }
        .slider-main {
            margin:0 -8px
        }
        .service-row-flex {
            padding:0 55px
        }
        .service-body img {
            width:45%
        }
        .contacts-footer-content {
            width:45%
        }
        .catalog-content {
            width:15%
        }
        .del-called {
            padding:10px 15px
        }
        .product-filter-card {
            width:50%
        }
        .card-options-right-body {
            width:370px;
            padding-left:10px;
            top:-550px
        }
        .card-center-body {
            width:calc(60% - 92px)
        }
        .order-prod-body {
            padding:40px 25px
        }
        .sertificate-card-main {
            min-height:415px
        }
        .trands-image-block img:last-child {
            height:270px
        }
        .about-company-content {
            padding-right:80px
        }
        .about-company-flex:nth-child(even) .about-company-content {
            padding:0 0 0 80px
        }
        .trands-image-block.about-company-image img:last-child {
            height:240px
        }
        .personal-data-body {
            width:100%
        }
        .history-card-info-body {
            width:100%;
            padding:0;
            margin-top:50px
        }
        .personal-info-and-card-flex {
            display:block
        }
        .news-main-content .news-card-main {
            width:33.3%
        }
        .error-text {
            padding:0
        }
        .contacts-right-info-block {
            width:100%
        }
        .subscribe-info-content {
            width:100%
        }
        .card-size-content-card .sizes-name-main {
            padding:6px;
            font-size:13px
        }
        .sizes-content-block {
            width:25%
        }
    }
    @media(min-width:991px) {
        .head_second_info>.menu-header-content:first-child {
            /* display:none */
        }
    }
    @media(max-width:991px) {
        .category_products a {
            min-width:100%;
            display:flex;
            padding:18px 20px
        }
        .category_products {
            display:block;
            column-count:unset;
            height:0;
            overflow:hidden;
            opacity:0;
            visibility:hidden;
            transition:all .8s linear
        }
        .catalog_products_main .catalog_products_name {
            margin-bottom:0;
            padding:18px 20px;
            display:flex;
            align-items:center;
            position:relative
        }
        .catalog_products_main {
            padding:16px 0;
            top:105%
        }
        .product-company-main.active .catalog_products_main {
            padding:16px 0
        }
        .service_company_body .product-company-main .catalog_products_main {
            height:auto;
            position:unset;
            background:0 0;
            padding:0
        }
        .service_company_body .product-company-main .product_tab_content {
            padding:0;
            height:0
        }
        .service_company_body .product-company-main .catalog_products_main .container {
            padding:0
        }
        .service_company_body .product-company-main .product_tab_content.active {
            padding:16px 0;
            height:auto
        }
        .total-product {
            display:block;
            font-size:14px
        }
        .product-title-main.product-category-ttl .total-product {
            margin:0 0 0 15px
        }
        body.active {
            overflow:hidden
        }
        .service_company_body {
            position:relative;
            z-index:13
        }
        .service_company {
            gap:normal
        }
        .product-company-main .catalog_products_main {
            height:calc(100vh - 185px)
        }
        .cookie-content {
            padding:20px 30px;
            justify-content:space-between
        }
        .cookie-text {
            width:75%
        }
        .product-main-content {
            display:block;
            overflow-y:scroll;
            height:calc(100vh - 165px);
            padding:0
        }
        .product-main-container {
            display:block;
            padding:26px 0
        }
        .product-main-container .catalog_products_name {
            display:flex;
            align-items:baseline;
            margin-bottom:15px
        }
        .product-main-content::-webkit-scrollbar {
            width:4px;
            height:4px
        }
        .product-main-content::-webkit-scrollbar-thumb {
            border-radius:10px;
            background:#3b3b3b
        }
        .product-main-content::-webkit-scrollbar-track {
            border-radius:10px;
            background:0 0
        }
        .catalog_products_name::after {
            position:absolute;
            content:'';
            top:0;
            bottom:0;
            right:30px;
            width:20px;
            height:20px;
            background-image:url(../img/arrow-PUk_Zjn.svg);
            background-position:50%;
            background-size:cover;
            background-repeat:no-repeat;
            margin:auto;
            transform:rotate(90deg);
            transition:all .4s ease
        }
        .product_rows.active .catalog_products_name.catalog_products_name::after {
            transform:rotate(-90deg)
        }
        .product_rows[data-brand="1"] {
            display:block
        }
        .product_rows.active .category_products {
            height:auto;
            overflow:auto;
            opacity:1;
            visibility:visible;
            padding-bottom:15px
        }
        .head_second_info {
            /* display:none */
        }
        .logo_head {
            width:170px;
            margin:0 auto 0 0
        }
        .menu-block span {
            width:22px;
            height:2px;
            background:#3b3b3b;
            transition:all .4s ease;
            display:block;
            margin:2px 0
        }
        .menu-block.active span:nth-child(1) {
            transform:translate(100px,0)
        }
        .menu-block.active span:nth-child(2) {
            transform:translate(1px,1px)rotate(45deg)
        }
        .menu-block.active span:nth-child(3) {
            transform:translate(1px,-5px)rotate(-43deg)
        }
        .menu-block {
            padding:2px;
            margin-left:auto;
            display:flex;
            flex-direction:column;
            cursor:pointer;
            overflow:hidden
        }
        .search_block {
            /* display:none */
        }
        .service_company_body .service_company .product-dropdown:nth-child(n+4) {
        // display: none
        }
        .product-company-main {
            width:100%
        }
        .service_company {
            justify-content:space-between;
            width:100%
        }
        .head_main_info {
            /*/* display:none */*/
        }
        .phone_number_company a:first-child {
            /* display:none */
        }
        .bottom-menu-category {
            width:20%;
            display:flex;
            justify-content:center;
            flex-direction:column;
            align-items:center
        }
        .bottom-menu-category svg {
            width:24px;
            height:24px;
            object-fit:cover
        }
        .bottom-menu-category span {
            color:#939393;
            font-family:tt-med;
            font-size:12px;
            line-height:normal
        }
        .cirlce-bottom-menu {
            width:36px;
            height:36px;
            padding:6px;
            border-radius:50%;
            align-items:center;
            justify-content:center;
            display:flex;
            margin-bottom:6px
        }
        .cirlce-bottom-menu svg path {
            stroke:#3b3b3b
        }
        .bottom-menu-main-block .cirlce-bottom-menu {
            background:#eb5a55
        }
        .bottom-menu-main-block .cirlce-bottom-menu svg path {
            stroke:#fff
        }
        .bottom-menu-main {
            position:fixed;
            bottom:0;
            left:0;
            right:0;
            background:#fff;
            z-index:12;
            padding:12px 0;
            display:flex;
            justify-content:center
        }
        .mobile-search-wrap {
            position:absolute;
            top:-84px;
            height:84px;
            background:#fff;
            left:0;
            width:100%;
            padding:20px 20px 0;
            border-bottom:1px solid #ddd;
            border-top:1px solid #ddd;
            /*/* display:none */*/
        }
        .mobile-search-wrap.active {
            display:block
        }
        .mobile-search-wrap form {
            display:flex;
            position:relative
        }
        .mobile-search-wrap input[type=search] {
            width:100%;
            border-radius:4px;
            border:1px solid #d6d6d6;
            font-family:tt-med;
            font-size:16px;
            line-height:normal;
            color:#3b3b3b;
            padding:12px 24px;
            outline:none;
            box-shadow:none
        }
        .mobile-search-wrap svg {
            width:24px;
            height:24px;
            position:absolute;
            top:11px;
            right:20px;
            background:0 0;
            cursor:pointer
        }
        .main-footer-content {
            flex-wrap:wrap;
            gap:40px 0
        }
        .contacts-footer-content {
            width:100%
        }
        .catalog-content {
            width:50%
        }
        .first-footer-block {
            width:50%;
            padding-right:40px
        }
        .second-footer-block {
            width:50%
        }
        .contacts-footer {
            gap:0
        }
        .footer-body {
            margin:20px 0 80px
        }
        .category-product-main img {
            aspect-ratio:345/360
        }
        .category-product-main {
            width:100%
        }
        .category-product-flex {
            flex-wrap:wrap;
            gap:10px
        }
        .product-content {
            width:96px;
            min-width:96px
        }
        .text-promocode {
            font-size:18px
        }
        .code-promocode {
            font-size:16px;
            padding:8px 17px
        }
        .slider-elements-content {
            display:flex;
            align-items:center;
            position:absolute;
            bottom:20px;
            left:0;
            right:0;
            justify-content:center
        }
        .slider-counter {
            margin:0 10px
        }
        .slider-elements-content .slider-prev {
            order:1;
            margin:0
        }
        .popular-section {
            padding:20px 0
        }
        .popular-slider-content {
            padding-bottom:80px;
            position:relative
        }
        .trands-main-row {
            display:block
        }
        .trands-image-block {
            padding:0 20px;
            width:100%;
            margin-bottom:20px
        }
        .trands-image-block img:first-child {
            height:530px;
            aspect-ratio:200/260
        }
        .trands-image-block img:last-child {
            height:310px
        }
        .trands-main-block {
            width:100%
        }
        .trands-slider-main {
            bottom:155px
        }
        .service-body {
            display:block
        }
        .service-body img {
            width:100%;
            margin-bottom:20px
        }
        .service-content {
            width:100%
        }
        .service-row-flex {
            padding:0
        }
        .social_nets-main {
            /*/* display:none */*/
        }
        .head_second_info {
            position:absolute;
            top:100px;
            width:0;
            left:-200%;
            height:calc(100vh - 120px);
            background:#fff;
            display:block;
            padding:30px 45px;
            z-index:13;
            transition:all .4s ease;
            overflow-y:scroll
        }
        .head_second_info::-webkit-scrollbar {
            width:2px;
            height:2px
        }
        .head_second_info::-webkit-scrollbar-thumb {
            border-radius:10px;
            background:#3b3b3b
        }
        .head_second_info::-webkit-scrollbar-track {
            border-radius:10px;
            background:0 0
        }
        .header-main.open-menu .head_second_info {
            left:0;
            width:100%
        }
        .menu-header-blocks {
            display:flex;
            flex-direction:column;
            gap:16px;
            margin-top:20px
        }
        .menu-header-content+.menu-header-content {
            margin-top:40px
        }
        .head_second_info a {
            font-family:tt-extra;
            font-size:16px
        }
        .head_second_info .menu-header-blocks a {
            font-family:tt-med;
            font-size:14px
        }
        .second_head_block {
            position:relative;
            z-index:14
        }
        .header-main.open-menu .second_head_block .product-company-main .catalog_products_main {
            height:auto;
            overflow:unset;
            opacity:1;
            visibility:visible;
            position:unset;
            padding:20px 0 0
        }
        .header-main.open-menu .second_head_block .product-company-main .category_products {
            height:auto;
            opacity:1;
            visibility:visible
        }
        .header-main.open-menu .second_head_block .product-company-main .buyer_rows-tabs {
            width:100%
        }
        .header-main.open-menu .second_head_block .product-company-main .product-main-content {
            height:auto;
            padding:0;
            margin:0
        }
        .header-main.open-menu .second_head_block .product-company-main .buyer_rows-tabs .category_products a {
            min-width:auto;
            padding:8px 0;
            font-family:tt-med;
            font-size:14px
        }
        .header-main.open-menu .second_head_block .product-company-main .mano-tablinks {
            max-width:unset;
            padding:0
        }
        .header-main.open-menu .second_head_block .head_second_info .product-company-main {
            margin-top:40px
        }
        .header-main.open-menu .second_head_block .product-company-main .product_tab_content {
            height:auto!important
        }
        .catalog-product-main {
            /*/* display:none */*/
        }
        .catalog-product-second-block {
            width:100%;
            padding:0
        }
        .filter-block {
            max-width:100%;
            min-width:100%
        }
        .filter-head-body {
            position:relative;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background:#fff
        }
        .filter-head-body.active {
            position:fixed;
            height:100vh;
            z-index:15;
            padding:35px 40px 160px;
            overflow-y:scroll
        }
        .filter-head-first-block {
            margin:0;
            display:block;
            height:0;
            opacity:0;
            transition:all .4s linear;
            z-index:-1
        }
        .filter-block .select2-container {
            width:100%!important;
            display:block;
            position:unset!important
        }
        .filter-block .select2-dropdown {
            border:0;
            transform:unset;
            padding:0
        }
        .filter-block .select2-container--default .select2-selection--single {
            border:0;
            padding-bottom:14px
        }
        .filter-block .select2-container .select2-selection--single .select2-selection__rendered {
            padding:0
        }
        .price-block-header,
        .select2-container .select2-selection--single .select2-selection__rendered,
        .select2-container--default .select2-search--inline .select2-search__field,
        .color-product-search-head {
            font-size:16px
        }
        .brands-filter-block .select2-search.select2-search--inline::after,
        .filter-block .select2-container--default .select2-selection--single .select2-selection__arrow {
            /*/* display:none */*/
        }
        .filter-mobile-head {
            display:flex;
            color:#3b3b3b;
            font-family:mont-med;
            font-size:18px;
            line-height:normal;
            margin-bottom:20px;
            align-items:center;
            justify-content:center
        }
        .filter-mobile-head svg {
            width:24px;
            height:24px;
            margin-right:5px
        }
        .filter-mobile-head::after {
            position:absolute;
            content:'';
            width:40px;
            height:40px;
            background-image:url(../img/close-d2uDBhj.svg);
            background-position:50%;
            background-repeat:no-repeat;
            filter:brightness(0)saturate(100%);
            background-size:cover;
            top:0;
            bottom:0;
            right:0;
            margin:auto;
            opacity:0;
            visibility:hidden;
            transition:all .4s linear
        }
        .filter-head-body.active .filter-mobile-head::after {
            opacity:1;
            visibility:visible
        }
        .filter-head-body.active .filter-head-first-block {
            opacity:1;
            height:auto;
            padding:0;
            z-index:9
        }
        .filter-range-price {
            width:260px;
            padding:20px 0;
            border:0;
            position:unset
        }
        .color-category-choose {
            position:unset;
            width:90%;
            padding:0;
            border:0;
            opacity:1;
            visibility:visible;
            max-width:100%
        }
        .color-select-main.size-product .filter-range-price {
            width:100%
        }
        .reset-save-btns-main {
            position:fixed;
            bottom:0;
            left:0;
            right:0;
            background:#fff;
            padding:0 15px 15px;
            z-index:10
        }
        .price-block-header .my-selection-class span {
            /*/* display:none */*/
        }
        .price-block-header .my-selection-class {
            background:0 0;
            margin:0;
            color:#3b3b3b;
            font-size:16px;
            padding-right:33px
        }
        .color-select-main.size-product.active .filter-range-price {
            width:100%
        }
        .color-select-main.active .color-category-choose {
            transform:unset;
            width:100%
        }
        .price-block-header,
        .color-product-search-head {
            border:0;
            padding:10px 0
        }
        .price-product .filter-parent-block {
            position:unset;
            transform:unset;
            opacity:1;
            visibility:visible;
            width:100%
        }
        .color-select-main {
            padding:10px 0
        }
        .price-block-header::after,
        .color-product-search-head::after {
            /*/* display:none */*/
        }
        .brands-filter-block .select2-container--default .select2-selection--multiple {
            border:0!important
        }
        .brands-filter-block .select2-container--default .select2-search.select2-search--inline .select2-search__field {
            margin:10px 0;
            height:24px;
            display:flex;
            align-items:center;
            justify-content:center
        }
        .reset-select-block {
            font-size:16px;
            margin:20px 0;
            opacity:1;
            visibility:visible;
            width:100%;
            display:flex;
            border:1px solid #3b3b3b;
            color:#3b3b3b;
            padding:12px 0;
            justify-content:center
        }
        .reset-select-block::after {
            /*/* display:none */*/
        }
        .save-change-filter {
            display:flex;
            width:100%;
            margin:0
        }
        .reset-select-block,
        .save-change-filter {
            height:45px
        }
        .select-main-block {
            max-height:270px
        }
        .card-left-content {
            /*/* display:none */;*/
            flex-direction:revert;
            position:unset;
            order:2
        }
        .card-left-block {
            width:25%;
            height:auto
        }
        .card-content-body img {
            width:100%
        }
        .card-content-body {
            flex-direction:column;
            gap:20px
        }
        .card-center-main+.card-center-main {
            padding:0
        }
        .card-center-body {
            padding:0;
            width:100%;
            order:1
        }
        .card-options-right-body {
            width:100%;
            top:0;
            padding:0;
            position:unset;
            order:3
        }
        .basket-prod-flex {
            display:flex;
            flex-direction:column;
            gap:20px
        }
        .basket-prod-body {
            width:100%;
            padding:0
        }
        .order-prod-main {
            width:100%;
            position:unset
        }
        .form-block-input-flex {
            flex-wrap:wrap
        }
        .form-block-input {
            width:100%
        }
        .form-block-input-address .form-block-input {
            width:100%
        }
        .form-block-input-address .form-block-input:nth-child(n+3) {
            width:48.5%
        }
        .form-block-promocode {
            display:block;
            width:50%
        }
        .btn-promocode-block {
            width:100%;
            margin:20px 0 0;
            padding:14px 24px;
            justify-content:center
        }
        .form-block-input-address {
            margin:0;
            gap:20px
        }
        .form-block-input-address .form-block-input {
            padding:0
        }
        .form-block-orders:last-child {
            margin-bottom:20px
        }
        .empty-review-txt {
            width:80%
        }
        .delivery-main-flex {
            gap:30px;
            flex-direction:column
        }
        .delivery-review-main {
            width:100%
        }
        .delivery-image-block {
            width:100%
        }
        .sertificate-card-main {
            width:50%
        }
        .contacts-right-info-block {
            display:block
        }
        .contacts-info-content {
            width:100%
        }
        .contacts-right-info-block .contacts-info-content {
            width:100%
        }
        .subscribe-info-content {
            width:100%;
            margin-top:40px;
            min-height:auto
        }
        .subscribe-info-image {
            width:75%;
            height:75%
        }
        .map-contacts {
            height:370px
        }
        .about-company-flex {
            align-items:unset;
            flex-direction:column-reverse
        }
        .about-company-content {
            padding:0;
            width:100%
        }
        .trands-image-block.about-company-image {
            width:100%;
            margin-bottom:30px
        }
        .trands-image-block.about-company-image img:last-child {
            height:auto;
            width:50%
        }
        .about-company-flex+.about-company-flex {
            margin-top:40px
        }
        .about-company-flex:nth-child(even) {
            flex-direction:column-reverse
        }
        .about-company-flex:nth-child(even) .about-company-content {
            padding:0
        }
        .subscribe-about-main {
            justify-content:space-between;
            gap:15px
        }
        .subscribe-about-main .btn-vk-subscribe {
            margin:0
        }
        .delivery-applic-content {
            width:64%
        }
        .applic-card-content {
            width:60%
        }
        .news-main-content .news-card-main {
            width:50%
        }
        .article-content-body {
            display:block
        }
        .news-article-block {
            width:100%
        }
        .article-read-right-block {
            width:100%;
            position:relative;
            display:block;
            top:unset;
            margin-top:40px;
            padding-bottom:70px
        }
        .article-read-right-block .news-card-main {
            padding:0 10px
        }
        .article-main {
            margin:30px -10px 0;
            display:block
        }
        .article-read-right-block .slider-elements-content {
            bottom:0;
            display:flex
        }
        .article-section {
            padding:20px 0 30px
        }
        .search-section .product-filter-card {
            width:50%
        }
        .search-section .filter-head-body {
            display:block
        }
        .search-section .product-title-main {
            display:block
        }
        .search-section .product-title-main span {
            margin:20px 0 0
        }
        .empty-search-txt {
            width:100%
        }
        .error-content {
            width:80%
        }
        .modal-log-in {
            max-width:700px
        }
        .product_rows {
            width:100%;
            padding:0
        }
        .card-size-content-card {
            opacity:1;
            visibility:visible;
            position:unset;
            padding:0;
            border:0;
            background:0 0;
            margin:6px 0 0
        }
        .slider-main .slick-list {
            padding-bottom:0
        }
        .product-content-main {
            gap:18px
        }
        .product_tab_links.tablinks::before {
            position:absolute;
            content:'';
            content:'';
            top:0;
            bottom:0;
            left:0;
            right:0;
            background:0 0;
            z-index:0
        }
        .product_tab_links.tablinks.active::before {
            z-index:99;
            display:block
        }
        .head_second_info .product-dropdown {
            margin-top:40px
        }
        .head_second_info .product-main-content {
            height:auto;
            position:unset;
            z-index:9;
            opacity:1;
            visibility:visible
        }
        .head_second_info .product_rows {
            width:100%
        }
        .head_second_info .category_products {
            grid-template-columns:1fr;
            height:auto;
            opacity:1;
            visibility:visible
        }
        .head_second_info .product_rows .category_products a {
            font-family:tt-med;
            padding:0
        }
        .head_second_info .product-main-container {
            padding:20px 0 0
        }
    }
    @media(max-width:720px) {
        .local_address {
            font-size:12px
        }
        .phone_number_company a {
            font-size:12px
        }
        .logo_head {
            width:130px
        }
        .service_company a {
            font-size:14px
        }
        .head_second_info .service_company a.dropdown-content {
            font-size:16px
        }
        .catalog-section {
            padding:35px 0 20px
        }
        .category-product-main img {
            aspect-ratio:345/280
        }
        .catalog_name_block {
            font-size:26px
        }
        .product-list li {
            font-size:12px;
            margin:0 12px
        }
        .product-category-name {
            font-size:12px
        }
        .products-category {
            padding:18px
        }
        .text-promocode {
            font-size:14px;
            margin-right:20px
        }
        .code-promocode {
            font-size:14px;
            padding:6px 10px
        }
        .promocode-body {
            margin-bottom:20px
        }
        .popular-ttl {
            font-size:26px
        }
        .product-img-main img {
            aspect-ratio:120/180
        }
        .product-card-content {
            padding:20px 18px 25px
        }
        .cookie-btn {
            width:100%;
            margin:15px 0 0;
            justify-content:center
        }
        .cookie-text {
            font-size:14px;
            width:100%
        }
        .cookie-content {
            padding:15px 20px;
            display:block
        }
        .card-size-content-card {
            font-size:12px
        }
        .product-card-main {
            padding:0 5px
        }
        .trands-image-block img:last-child {
            height:170px
        }
        .trands-image-block img:first-child {
            height:305px
        }
        .trands-name {
            font-size:20px
        }
        .trands-review {
            font-size:12px
        }
        .trands-slider-main {
            bottom:195px
        }
        .news-img-main {
            height:135px
        }
        .news-name {
            font-size:14px
        }
        .news-read-more {
            font-size:12px
        }
        .service-ttl {
            font-size:20px;
            margin-bottom:20px
        }
        .service-review-text {
            font-size:12px
        }
        .product-price {
            font-size:14px
        }
        .phone_number_company a svg {
            margin-right:5px
        }
        .local_address svg {
            margin-right:5px
        }
        .head_second_info {
            padding:30px 15px;
            top:85px
        }
        .filter-mobile-head svg {
            width:20px;
            height:20px
        }
        .filter-mobile-head {
            font-size:20px
        }
        .filter-mobile-head::after {
            width:26px;
            height:26px
        }
        .product-filter-main-content {
            margin:-5px
        }
        .product-filter-card {
            padding:5px
        }
        .product-card-type {
            border-radius:2px;
            padding:8px;
            font-size:10px;
            top:15px;
            left:5px
        }
        .product-hover-title {
            font-size:14px;
            margin-bottom:10px
        }
        .product-hover-review {
            font-size:12px
        }
        .product-last-card .product-card-main {
            height:100%
        }
        .product-last-card .product-hover-more {
            height:100%
        }
        .product-last-card .product-hover-block {
            padding:20px;
            height:80%
        }
        .product-last-card .product-hover-title {
            font-size:12px
        }
        .product-last-card .product-hover-review {
            font-size:11px
        }
        .btn-more-product {
            font-size:12px;
            margin:20px auto 0
        }
        .product-hover-more {
            padding:39px 20px
        }
        .image-advance {
            margin-top:20px
        }
        .footer-body {
            padding:40px 0 0
        }
        .logo-footer {
            width:165px;
            margin-bottom:40px
        }
        .first-footer-block {
            padding-right:10px
        }
        .phone-footer {
            font-size:12px
        }
        .card-options-right-main {
            padding:40px 25px
        }
        .card-name {
            font-size:20px
        }
        .card-price-block {
            padding-top:20px;
            margin-top:25px
        }
        .card-options-category {
            padding:20px 0 0;
            margin-top:20px
        }
        .card-options-category+.card-options-category {
            margin-top:20px
        }
        .product-section {
            padding:20px 0
        }
        .basket-count-price-block {
            padding-right:0
        }
        .basket-prod-rev-main {
            display:block;
            padding-left:10px
        }
        .basket-prod-review {
            width:100%;
            padding:0 0 20px
        }
        .basket-prod-name {
            font-size:14px
        }
        .basket-prod-options {
            font-size:12px
        }
        .basket-count {
            padding:6px 10px
        }
        .basket-prod-price {
            font-size:20px
        }
        .basket-prod-content+.basket-prod-content {
            margin-top:10px
        }
        .order-prod-body {
            padding:20px 40px
        }
        .your-order-ttl {
            font-size:20px
        }
        .product-title-main {
            font-size:26px
        }
        .basket-title {
            margin-bottom:24px
        }
        .empty-review-txt {
            font-size:16px;
            margin:20px 0 40px;
            width:100%
        }
        .delivery-review-main p {
            font-size:12px
        }
        .delivery-review-main div {
            font-size:20px;
            margin-bottom:20px
        }
        .delivery-review-main p+div {
            margin-top:30px
        }
        .delivery-image-block {
            min-height:250px
        }
        .exchange-content-block p,
        .exchange-content-block ul li {
            font-size:12px
        }
        .exchange-content-block div {
            font-size:20px;
            margin-bottom:20px
        }
        .exchange-content-block p+div {
            margin-top:30px
        }
        .sertificate-content p {
            margin:-4px 0 20px
        }
        .sertificate-card-main {
            padding:5px;
            min-height:250px
        }
        .sertificate-card-body {
            margin:-5px -5px 15px
        }
        .contacts-address-offices {
            font-size:13px;
            margin-bottom:30px
        }
        .contacts-info-content {
            width:100%;
            padding:0
        }
        .contacts-info-body {
            margin:0;
            gap:24px
        }
        .contacts-info-main+.contacts-info-main {
            margin-top:40px
        }
        .contacts-title-info {
            font-size:20px
        }
        .contacts-name-info {
            font-size:16px
        }
        .contacts-phones-info {
            width:100%;
            padding:0
        }
        .contacts-phones-info-main {
            margin:0;
            gap:20px
        }
        .subscribe-info-content {
            margin:50px 0 0;
            padding:20px
        }
        .we-in-vk svg {
            width:40px;
            height:40px
        }
        .btn-vk-subscribe {
            font-size:16px
        }
        .subscribe-text-info {
            font-size:18px
        }
        .subscribe-info-image {
            width:60%;
            height:60%
        }
        .contacts-head-title {
            margin-bottom:30px
        }
        .map-contacts {
            height:270px
        }
        .contacts-section {
            padding:20px 0 40px
        }
        .requisites-section {
            padding:40px 0 20px
        }
        .requisites-txt {
            font-size:16px
        }
        .about-company-content div {
            font-size:20px;
            margin-bottom:20px
        }
        .about-company-content p {
            font-size:12px
        }
        .subscribe-about-main {
            flex-wrap:wrap;
            padding:20px;
            text-align:center;
            gap:20px
        }
        .subscribe-about-txt {
            font-size:16px;
            width:100%
        }
        .subscribe-about-main .btn-vk-subscribe {
            padding:6px;
            width:100%;
            justify-content:center
        }
        .personal-data-body {
            padding:20px
        }
        .personal-user-name-head {
            padding:10px 0
        }
        .personal-accaunt-name {
            width:60px;
            height:60px;
            min-width:60px;
            padding:10px
        }
        .personal-accaunt-name {
            font-size:24px
        }
        .personal-user-name {
            font-size:18px
        }
        .personal-user-information {
            padding:20px 0;
            margin:20px 0
        }
        .user-info-content div {
            font-size:16px
        }
        .user-info-content+.user-info-content {
            margin-top:16px
        }
        .user-change-password {
            font-size:16px
        }
        .user-change-password+.user-change-password {
            margin-top:20px
        }
        .applic-info.applic-info-status {
            /*/* display:none */*/
        }
        .applic-info-content {
            position:relative;
            flex-wrap:wrap
        }
        .applic-info:nth-child(1) {
            min-width:50%
        }
        .applic-info.applic-info-send-mail {
            width:60%;
            order:2
        }
        .applic-price {
            font-size:18px;
            width:40%;
            position:absolute;
            right:0;
            top:24px
        }
        .applic-info span {
            margin-bottom:6px
        }
        .applic-info:nth-child(1) div {
            font-size:14px;
            margin-bottom:6px
        }
        .applic-status {
            display:block;
            font-size:12px
        }
        .applic-info div {
            font-size:12px
        }
        .applic-info+.applic-info {
            margin-top:10px
        }
        .applic-more-btn {
            font-size:14px
        }
        .applic-card-content {
            width:100%
        }
        .applic-card-info-main.active {
            padding-top:10px;
            margin-top:10px
        }
        .applic-card-content img {
            width:40px;
            height:40px;
            min-width:40px
        }
        .applic-card-review {
            display:block;
            width:calc(70% - 40px);
            padding-left:12px
        }
        .applic-card-review a {
            margin-bottom:10px
        }
        .delivery-applic-content {
            width:100%
        }
        .history-empty-txt {
            font-size:14px;
            width:100%
        }
        .news-main-content .news-card-main {
            padding:5px
        }
        .news-main-content {
            margin:-5px -5px 20px
        }
        .news-article-block img {
            margin-bottom:20px
        }
        .article-read-right-block .news-img-main {
            height:auto
        }
        .article-read-right-block .news-card-main {
            padding:0 5px
        }
        .article-main {
            margin:30px -5px 0
        }
        .article-section {
            padding:20px 0
        }
        .product-last-card img {
            height:auto;
            aspect-ratio:170/110
        }
        .empty-search-txt {
            font-size:16px;
            margin-bottom:30px;
            padding-top:20px
        }
        .error-content {
            width:100%
        }
        .error-image {
            height:auto;
            width:100%
        }
        .error-text {
            font-size:16px
        }
        .modal-content-main {
            padding:40px 20px
        }
        .modal-title-head {
            font-size:20px;
            margin-bottom:20px
        }
        .modal-input-block+.modal-input-block {
            margin-top:20px
        }
        .enter-btn-form {
            width:100%;
            margin:40px auto 0
        }
        .modal-sub-title {
            margin-bottom:20px
        }
        .filter-head-body.active {
            padding:35px 15px 135px
        }
        .form-block-input-address .form-block-input:nth-child(n+3) {
            width:100%
        }
        .form-block-promocode {
            display:block;
            width:100%
        }
        .sizes-content-block {
            width:33.3%
        }
        .service_company_body .product-company-main .catalog_products_main {
            left:-10px;
            right:-10px;
            height:auto;
            opacity:1;
            visibility:visible;
            top:105%;
            padding:0
        }
        .service_company_body .product-company-main.active .product_tab_content.active,
        .service_company_body .product-company-main .product_tab_content.active {
            height:calc(100vh - 150px)
        }
        .service_company_body .product-company-main .product_tab_content {
            height:0
        }
        .product-company-main .catalog_products_main .mano-tablinks {
            padding:0
        }
        .catalog_products_main .catalog_products_name {
            padding:14px 12px;
            font-size:16px
        }
        .catalog_products_name::after {
            right:25px
        }
        .category_products a {
            padding:5px 20px;
            font-size:14px
        }
        .category_products a span {
            font-size:12px
        }
        .product-main-container .catalog_products_name {
            font-size:16px
        }
    }
    .freeze {
        position:absolute;
        left:0;
        top:0;
        width:100%;
        height:100%;
        z-index:20;
        background:#fff;
        opacity:.6
    }
    .freeze.hide {
        /* display:none */
    }
    #cartContent {
        position:relative
    }
    #orderWrap {
        position:relative
    }
    .card-group-photos {
    }
    .card-group-photos a.active img {
        border-color:#eb5a55
    }
    .card-group-photos a {
        margin-right:7px
    }
    .card-group-photos a img {
        border:1px solid #ddd
    }
    .error {
        color:#f9423c
    }
    #orderAdditionalFields {
        /* display:none */
    }
    #orderDeliveries {
        /* display:none */;
        margin-bottom:60px
    }
    #orderDeliveriesLocationEmptyMessage {
        display:block;
        font-style:italic
    }
    .form-block-orders-terms {
        margin-top:20px;
        font-size:.9rem
    }
    .form-block-orders-terms input[type=checkbox] {
        position:relative;
        bottom:-1.5px
    }
    .form-select-main {
        border-radius:4px;
        border:1px solid #d6d6d6;
        background:#fff;
        padding:12px 24px;
        width:100%;
        outline:none;
        color:#3b3b3b;
        font-family:tt-med;
        font-size:16px;
        line-height:normal
    }
    .form-select-w150 {
        width:250px
    }
    .form-block-input ul {
        margin:0;
        padding:0;
        color:#f9423c;
        list-style:none
    }
    .form-block-orders-errors {
        color:#ff0800;
        background:#ffecec;
        padding:20px;
        border-radius:10px;
        margin-bottom:40px
    }
    .autocomplete-suggestions {
        border:1px solid #d6d6d6;
        background:#fff;
        overflow:auto
    }
    .autocomplete-suggestion {
        padding:2px 5px
    }
    .autocomplete-selected {
        background:#f0f0f0
    }
    .autocomplete-suggestions strong {
        font-weight:400;
        color:#39f
    }
    .autocomplete-group {
        padding:2px 5px
    }
    .autocomplete-group strong {
        display:block;
        border-bottom:1px solid #000
    }
    #f_deliveryAddress {
        resize:none
    }
    label[data-item-count="0"] {
        opacity:.2;
        color:#f9423c;
        pointer-events:none
    }
    figure.table {
        margin:0
    }
    figure.table table {
        width:100%;
        border:1px solid #ddd;
        border-collapse:collapse;
        caption-side:bottom
    }
    figure.table table td,
    figure.table table th {
        border:1px solid #ddd;
        padding:6px
    }
    .page-content h2,
    .page-content h3,
    .page-content h4 {
        margin:24px 0 18px
    }
    .page-content p {
        margin:0 0 8px
    }
    .sf-toolbar {
        position:fixed
    }
    .page-blocks {
        margin:40px 0 0;
        display:flex;
        flex-direction:row;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:18px
    }
    .page-blocks-item {
        width:420px;
        position:relative;
        box-shadow:0 0 8px rgba(0,0,0,.3);
        cursor:pointer
    }
    .page-blocks-item img {
        width:100%;
        height:100%;
        object-fit:cover;
        border:1px solid #ddd;
        margin:0 auto 30px;
        display:block
    }
    .page-pics-content-text {
        /* display:none */;
        width:100%;
        position:absolute;
        top:0;
        left:0;
        z-index:10
    }
    .page-pics-content-text h4 {
        margin:0;
        padding:20px 0;
        font:24px/28px permianseriftypeface;
        text-align:center
    }
    .page-pics-content-text ul {
        margin:0;
        padding:0 50px
    }
    .page-pics-content-text li {
        padding:4px 0;
        margin:0;
        font:19px/24px permianseriftypeface
    }
    .page-blocks-item.active img {
        visibility:hidden
    }
    .page-blocks-item.active .page-pics-content-text {
        display:block
    }
    .content-q {
        position:relative;
        width:75%;
        margin:0 auto 50px
    }
    @media(max-width:1024px) {
        .content-q {
            width:100%;
            padding:0 15px
        }
    }
    .modal-input-block-captcha-box {
        position:relative;
        padding-left:230px
    }
    .modal-input-block-captcha-box a {
        position:absolute;
        top:50px;
        left:0
    }
    .modal-input-block-captcha-box img {
        position:absolute;
        left:0;
        top:0;
        cursor:pointer
    }
    .modal-input-block-captcha-box input {
        width:200px
    }
    .modal-body-message {
        /* display:none */;
        font:24px/28px permianseriftypeface;
        color:green;
        margin-bottom:20px;
        text-align:center
    }
    .modal-body-form-errors {
    }
    .modal-body-form-errors ul {
        margin:0 0 25px;
        padding:12px;
        border-radius:10px;
        list-style:none;
        color:#ff0800;
        background:#ffecec
    }
    #filtersWrap {
        scroll-margin-top:20px
    }
    #miniCartMobile {
        position:relative
    }
    #miniCartMobile em {
        display:block;
        position:absolute;
        top:13px;
        left:0;
        width:100%;
        text-align:center;
        font-style:normal;
        font-size:10px;
        color:#ff0800
    }
    #miniCartMobile.active path {
        stroke:#ff0800
    }
    .catalog-footer-message {
        text-align:center;
        margin-top:15px;
        margin-bottom:15px
    }
    .brands-page {
    }
    .brands-page-tabs {
        list-style:none;
        margin:0;
        padding:0;
        display:flex;
        gap:20px
    }
    .brands-page-tabs li {
        margin:0;
        padding:0;
        font-size:25px;
        line-height:28px
    }
    .brands-page-tabs li a {
        font-size:25px;
        line-height:28px
    }
    .brands-page-tabs li.active a {
        color:#f9423c;
        text-decoration:underline
    }
    @media(max-width:1024px) {
        .brands-page-tabs {
            justify-content:space-between;
            gap:0
        }
        .brands-page-tabs li {
            font-size:17px;
            line-height:19px
        }
        .brands-page-tabs li a {
            font-size:17px;
            line-height:19px
        }
    }
    .brands-page-tabs li.active a {
        text-decoration:underline
    }
    .brands-page-wrap {
        margin-top:40px
    }
    .brands-page-content {
        /* display:none */
    }
    .brands-page-content.active {
        display:block
    }
    .brands-page-content-letter {
        margin-bottom:20px
    }
    .brands-page-content-letter ul {
        list-style:none;
        margin:0;
        padding:0
    }
    .brands-page-content-letter ul li {
        margin:0 0 0 26px;
        padding:2px 0;
        list-style-type:disc
    }
    .brands-page-content-letter ul li.bold a {
        font-weight:700
    }

</style>

    <style>
        .column-list {
            column-count: 7; /* Количество столбцов */
            column-gap: 20px; /* Расстояние между столбцами */
            list-style-type: disc; /* или любой другой стиль списка */
        }
        .column-list a{ display: block;}
    </style>
11
    <div class="
{{--    product-main-content--}}
    ">
        <div class="
{{--        product-main-container--}}
{{--        container--}}
        ">
            <div class="
{{--            product_rows--}}
            ">
{{--                <div class="catalog_products_name">--}}

{{--                </div>--}}
                <div class="
{{--                category_products --}}
                column-list">
                    <a href="/brand/amorelli">A.Morelli </a>
                    <a href="/brand/amantoni">AMANTONI </a>
                    <a href="/brand/ara">ARA </a>
                    <a href="/brand/adanex">Adanex </a>
                    <a href="/brand/alberto-guardiani">Alberto Guardiani </a>
                    <a href="/brand/americanino">Americanino </a>
                    <a href="/brand/andrea-lattanzi">Andrea Lattanzi </a>
                    <a href="/brand/andrea-morelli">Andrea Morelli </a>
                    <a href="/brand/antonello">Antonello </a>
                    <a href="/brand/avanti">Avanti </a>
                    <a href="/brand/azaleia">Azaleia </a>
                    <a href="/brand/baldinini">BALDININI </a>
                    <a href="/brand/balenciaga">BALENCIAGA </a>
                    <a href="/brand/balex">BALEX </a>
                    <a href="/brand/baden">Baden </a>
                    <a href="/brand/barcelo-biagi">Barcelo Biagi </a>
                    <a href="/brand/barracuda">Barracuda </a>
                    <a href="/brand/boemos">Boemos </a>
                    <a href="/brand/brimarts">Brimarts </a>
                    <a href="/brand/bugatti">Bugatti </a>
                    <a href="/brand/byblos">Byblos </a>
                    <a href="/brand/cult">CULT </a>
                    <a href="/brand/cadoro">Cadoro </a>
                    <a href="/brand/calvin-klein-jeans">Calvin Klein Jeans </a>
                    <a href="/brand/casa-moda">Casa Moda </a>
                    <a href="/brand/cavaletto">Cavaletto </a>
                    <a href="/brand/chiara-bellini">Chiara Bellini </a>
                    <a href="/brand/codoro">Codoro </a>
                    <a href="/brand/cressy">Cressy </a>
                    <a href="/brand/crosby">Crosby </a>
                    <a href="/brand/desoto">DESOTO </a>
                    <a href="/brand/ditop">DITOP </a>
                    <a href="/brand/daniele-lepori">Daniele Lepori </a>
                    <a href="/brand/donna-carolina">Donna Carolina </a>
                    <a href="/brand/donna-piu">Donna Piu </a>
                    <a href="/brand/dorndorf">Dorndorf </a>
                    <a href="/brand/emilania">E.Milania </a>
                    <a href="/brand/eder">Eder </a>
                    <a href="/brand/elma-milani">Elma Milani </a>
                    <a href="/brand/evalli">Evalli </a>
                    <a href="/brand/fabi">FABI </a>
                    <a href="/brand/fausto">FAUSTO </a>
                    <a href="/brand/fiorangelo">FIORANGELO </a>
                    <a href="/brand/finn-line">Finn Line </a>
                    <a href="/brand/flavio">Flavio </a>
                    <a href="/brand/freuole">Freuole </a>
                    <a href="/brand/genmark">GENMARK </a>
                    <a href="/brand/giorgio-armani">GIORGIO ARMANI </a>
                    <a href="/brand/glamforever">GLAMFOREVER </a>
                    <a href="/brand/gnv">GNV </a>
                    <a href="/brand/good-man">GOOD MAN </a>
                    <a href="/brand/gabor">Gabor </a>
                    <a href="/brand/gadea">Gadea </a>
                    <a href="/brand/gala">Gala </a>
                    <a href="/brand/giampieronicola">Giampieronicola </a>
                    <a href="/brand/gianfranco-butteri">Gianfranco Butteri  </a>
                    <a href="/brand/giorgio-piergentili">Giorgio Piergentili </a>
                    <a href="/brand/giotto">Giotto </a>
                    <a href="/brand/giovanni-ciccioli">Giovanni Ciccioli </a>
                    <a href="/brand/grif-italia">Grif Italia </a>
                    <a href="/brand/guido-sgariglia">Guido Sgariglia </a>
                    <a href="/brand/hispanitas">HISPANITAS </a>
                    <a href="/brand/hardwood">Hardwood </a>
                    <a href="/brand/il-borgo">IL Borgo </a>
                    <a href="/brand/ivolga">IVOLGA </a>
                    <a href="/brand/jenny">JENNY </a>
                    <a href="/brand/jana">Jana </a>
                    <a href="/brand/katrin">KATRIN </a>
                    <a href="/brand/kapika">Kapika </a>
                    <a href="/brand/keddo">Keddo </a>
                    <a href="/brand/kelibe">Kelibe </a>
                    <a href="/brand/lillimill">LILLIMILL </a>
                    <a href="/brand/liu-jo">LIU JO </a>
                    <a href="/brand/lodi">LODI </a>
                    <a href="/brands/" class="menuPageLink">Смотреть все бренды</a>
                </div>
            </div>
        </div>
    </div>
222
@endif







    <div class="container mx-auto my-10">

        <div class="mb-5">
            <div class="bg-red-100 p-2 my-3">
                <h2 class="text-red-500 text-2xl">Маркетинг</h2>
            </div>
            <p>Предлагаем добавить маркетинг в свой бизнес.</p>
            <p>Задания, план выполнения, отправляете отчётность о выполнении.</p>
        </div>




        <div class="bg-red-100 p-2 my-3">
            <h2 class="text-red-500 text-2xl">Тарифные планы</h2>
        </div>
        <div class="flex flex-row w-full ">
            <div class="w-1/3 flex flex-col">
                <div class="font-bold">
                    Бесплатно
                </div>
                <div>10 инструментов, пошагово,<br/>
                    с нас задания и план выполнения,<br/>
                    с вас отчёт о выполнении
                </div>
            </div>
            <div class="w-1/3 flex flex-col">
                <div class="font-bold">
                    DIY / Самодельщик
                </div>
                <div>20 инструментов, пошагово,<br/>
                    с нас задания и план выполнения,<br/>
                    с вас отчёт о выполнении
                </div>
            </div>
            <div class="w-1/3 flex flex-col">
                <div class="font-bold">
                    VIP
                </div>
                <div>40 инструментов, пошагово,<br/>
                    с Нас реализация,<br/>
                    с Вас данные<br/>
                    с Нас отчёт о выполнении
                </div>
            </div>
        </div>

    </div>
    @endif
</div>
