{{--    <link rel="stylesheet" href="https://dom-obuv.ru/assets/vendor/bootstrap/dist/css/bootstrap.min-FxLwN4-.css">--}}
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Меню и содержимое в одном блоке</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        /* Родительский блок — виртуальный контейнер с двумя колонками */
        .virtual-columns {
            display: flex;
            height: 100vh; /* высота на весь экран для демонстрации */
            border: 1px solid #ddd;
        }

        /* Меню - слева - 25% ширины и прокручиваемое */
        .menu-column {
            width: 25%;
            max-height: 100vh;
            overflow-y: auto;
            position: sticky;
            top: 0;
            padding: 1rem;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
        }

        /* Содержимое - справа - 75% ширины */
        .content-column {
            width: 75%;
            padding: 1rem;
            overflow-y: auto;
        }
    </style>


    <style>
        .block1 {
            display: flex;
            flex-wrap: wrap; /* разрешает перенос на новую строку при малом экране */
            gap: 20px; /* отступ между колонками */
        }

        .column1 {
            padding: 3px;
            flex: 0 0 150px; /* Не растягивается, не сжимается, ширина 150px */
            box-sizing: border-box;
        }

        .column2 {
            flex: 1 1 auto; /* Занимает всё доступное пространство */
            box-sizing: border-box;
        }
    </style>

    @if(1==2)
        <script>
            // window.addEventListener('DOMContentLoaded', () => {
            //     // Отступ от нижней границы экрана
            //     const offsetBottom = 30;
            //     const block = document.querySelector('.catalog-product-main');
            //     if (!block) {
            //         console.log('Блок не найден');
            //         return;
            //     }
            //     const screenHeight = window.innerHeight;
            //     const blockHeight = block.offsetHeight;
            //     const diff = blockHeight - screenHeight;
            //     const topValue = diff > 0 ? -(diff+offsetBottom) : 0;
            //     block.style.top = `${topValue}px`;
            // });

            //const block = document.getElementById('catalogProductMain');
            const block = document.querySelector('.catalog-product-main');
            const inner = document.getElementById('innerBlock');

            function updateTopValue() {
                const blockHeight = block.offsetHeight;
                const viewportHeight = window.innerHeight;

                const diff = blockHeight - viewportHeight;
                const topValue = diff > 0 ? -diff : 0;

                inner.style.top = `${topValue}px`;

                console.log(`Высота блока: ${blockHeight}px, Высота окна: ${viewportHeight}px, Установка top: ${topValue}px`);
            }

            // Пересчёт при загрузке страницы
            window.addEventListener('load', updateTopValue);
            // Пересчёт при изменении размера окна
            window.addEventListener('resize', updateTopValue);

            // Отслеживаем изменения размера блока через ResizeObserver
            if ('ResizeObserver' in window) {
                const resizeObserver = new ResizeObserver(() => {
                    updateTopValue();
                });
                resizeObserver.observe(block);
            } else {
                // Фолбэк: можно периодически проверять (например, setInterval) или использовать MutationObserver (не так точно)
                console.warn('ResizeObserver не поддерживается в этом браузере.');
            }
        </script>
    @endif
</head>
<body>

<div class="block1">
    <div class="column1">
        {{--        <div style="position: sticky; top: 0;">--}}
        <div class="catalog-product-main" style="position: sticky;
        /*top: -800px;*/
        /*bottom: 0;*/
        ">
            @foreach (range(1, 50) as $i)
                меню <br/>
            @endforeach
        </div>
        {{--        </div>--}}
    </div>
    <div class="column2">
        @foreach (range(1, 50) as $i)
            <p>Длинный контент для демонстрации прокрутки содержимого...</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel sodales magna. Nullam
                efficitur, sapien vitae vestibulum interdum...</p>
            <p>... (добавьте достаточное количество текста или элементов) ...</p>
        @endforeach
    </div>
</div>


@if(1==2)
    <!-- Yandex.Metrika counter -->
    {{--<script type="text/javascript">--}}
    {{--    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};--}}
    {{--        m[i].l=1*new Date();--}}
    {{--        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}--}}
    {{--        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})--}}
    {{--    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");--}}

    {{--    ym(24523115, "init", {--}}
    {{--        clickmap:true,--}}
    {{--        trackLinks:true,--}}
    {{--        accurateTrackBounce:true,--}}
    {{--        webvisor:true,--}}
    {{--        trackHash:true,--}}
    {{--        ecommerce:"dataLayer"--}}
    {{--    });--}}
    {{--</script>--}}
    {{--<noscript><div><img src="https://mc.yandex.ru/watch/24523115" style="position:absolute; left:-9999px;" alt="" /></div></noscript>--}}
    <!-- /Yandex.Metrika counter -->
    {{--<script async="" src="https://www.googletagmanager.com/gtag/js?id=G-BJYJWYHKRM"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-BJYJWYHKRM'); </script>--}}


    {{--<div class="cookie-main open-cookie">--}}
    {{--    <div class="container">--}}
    {{--        <div class="cookie-content">--}}
    {{--            <div class="cookie-text">Мы используем файлы cookie, чтобы сайт был лучше для вас.</div>--}}
    {{--            <button class="cookie-btn">Принять</button>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}

    <header class="header-main">
        <div class="first_head_block">
            <div class="container">
                <div class="head_first_info">
                    <a href="/contacts" class="local_address" itemscope="" itemtype="http://schema.org/ShoeStore">
                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="Navigation / Map_Pin">
                                <g id="Vector">
                                    <path
                                        d="M3.33203 6.61523C3.33203 9.84978 6.16168 12.5246 7.41416 13.5501C7.59341 13.6969 7.68411 13.7712 7.81784 13.8088C7.92197 13.8381 8.07523 13.8381 8.17936 13.8088C8.31334 13.7711 8.40341 13.6976 8.58333 13.5502C9.83581 12.5247 12.6653 9.85008 12.6653 6.61553C12.6653 5.39145 12.1737 4.21737 11.2985 3.35181C10.4233 2.48626 9.23643 2 7.99875 2C6.76107 2 5.57404 2.48634 4.69887 3.35189C3.8237 4.21744 3.33203 5.39116 3.33203 6.61523Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path
                                        d="M6.66536 6C6.66536 6.73638 7.26232 7.33333 7.9987 7.33333C8.73508 7.33333 9.33203 6.73638 9.33203 6C9.33203 5.26362 8.73508 4.66667 7.9987 4.66667C7.26232 4.66667 6.66536 5.26362 6.66536 6Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </g>
                        </svg>
                        г. <span itemprop="addressLocality">Балашиха</span>, <span itemprop="streetAddress">ш. Энтузиастов 60</span>
                    </a>
                    <div class="phone_number_company" itemscope="" itemtype="http://schema.org/ShoeStore">
                        <a href="tel:+7(495) 529-37-33">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.8374 7.09536C15.3312 5.82984 14.1055 5 12.7425 5H8.15789C6.41384 5 5 6.41349 5 8.15755C5 22.982 17.018 35 31.8424 35C33.5865 35 35 33.586 35 31.842L35.0008 27.2566C35.0008 25.8936 34.1712 24.6681 32.9056 24.1619L28.5115 22.4049C27.3748 21.9502 26.0805 22.1548 25.1399 22.9386L24.0059 23.8845C22.6814 24.9881 20.7327 24.9004 19.5137 23.6813L16.3204 20.4851C15.1013 19.266 15.0112 17.3189 16.1149 15.9945L17.0605 14.8605C17.8444 13.9199 18.0508 12.6253 17.5961 11.4885L15.8374 7.09536Z"
                                    stroke="white" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                            <span itemprop="telephone">+7(495) 529-37-33</span>
                        </a>
                        <a href="tel:8(800) 250-29-29">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.8374 7.09536C15.3312 5.82984 14.1055 5 12.7425 5H8.15789C6.41384 5 5 6.41349 5 8.15755C5 22.982 17.018 35 31.8424 35C33.5865 35 35 33.586 35 31.842L35.0008 27.2566C35.0008 25.8936 34.1712 24.6681 32.9056 24.1619L28.5115 22.4049C27.3748 21.9502 26.0805 22.1548 25.1399 22.9386L24.0059 23.8845C22.6814 24.9881 20.7327 24.9004 19.5137 23.6813L16.3204 20.4851C15.1013 19.266 15.0112 17.3189 16.1149 15.9945L17.0605 14.8605C17.8444 13.9199 18.0508 12.6253 17.5961 11.4885L15.8374 7.09536Z"
                                    stroke="white" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                            <span itemprop="telephone">8(800) 250-29-29</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="second_head_block">
                <div class="head_second_info">
                    <div class="menu-header-content">
                        <a href="javascript:void(0)">Каталог</a>
                        <div class="menu-header-blocks">
                            <a href="/catalog/zhenshchinam">Женщинам</a>
                            <a href="/catalog/muzhchinam">Мужчинам</a>
                            <a href="/catalog/detyam">Детям</a>
                        </div>
                    </div>

                    <div class="menu-header-content">
                        <a href="/contacts">О нас</a>
                        <div class="menu-header-blocks">
                            <a href="/news/">Новости</a>
                            <a href="/contacts">Контакты</a>
                        </div>
                    </div>

                    <div class="product-dropdown">
                        <div class="service_company">
                            <a href="javascript:void(0)" class="buyer_tabs dropdown-content">Покупателям</a>
                        </div>
                        <div class="product-main-content">
                            <div class="product-main-container container">
                                <div class="product_rows">
                                    <div class="category_products">
                                        <a href="/help/delivery">Доставка</a>
                                        <a href="/help/pay-methods">Способы оплаты</a>
                                        <a href="/help/oferta">Публичная оферта</a>
                                        <a href="/help/payback">Обмен и возврат</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/" class="logo_head" itemscope="" itemtype="https://schema.org/ShoeStore"><img
                        src="https://dom-obuv.ru/uploads/block/source/p/pi/18-1298e5ac0f2c-shapka-logotip.jpg"
                        alt="Дом Обуви" title="Дом Обуви"></a>
                <div class="head_main_info">
                    <a href="/cart" class="backet_main" data-label="Корзина" title="Перейти в корзину">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.9984 9V6C15.9984 3.79086 14.2076 2 11.9984 2C9.78928 2 7.99842 3.79086 7.99842 6V9M3.59042 10.352L2.99042 16.752C2.81982 18.5717 2.73452 19.4815 3.03647 20.1843C3.30171 20.8016 3.76653 21.3121 4.35643 21.6338C5.02794 22 5.94178 22 7.76946 22H16.2274C18.055 22 18.9689 22 19.6404 21.6338C20.2303 21.3121 20.6951 20.8016 20.9604 20.1843C21.2623 19.4815 21.177 18.5717 21.0064 16.752L20.4064 10.352C20.2624 8.81535 20.1903 8.04704 19.8448 7.46616C19.5404 6.95458 19.0908 6.54511 18.553 6.28984C17.9424 6 17.1707 6 15.6274 6L8.36946 6C6.82611 6 6.05443 6 5.44383 6.28984C4.90608 6.54511 4.45642 6.95458 4.15208 7.46616C3.80651 8.04704 3.73448 8.81534 3.59042 10.352Z"
                                stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span>Корзина</span>
                    </a>
                </div>
                <div class="menu-block">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="service_company_body">
                <div class="service_company tab tab_first">
                    <div class="product-dropdown" data-brand="0">
                        <div class="product_tab_links dropdown-content">
                            <a href="/catalog/zhenshchinam">Женщинам</a>
                        </div>
                        <div class="product-main-content">
                            <div class="product-main-container container">
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/obuv-dlya-zhenschin">Обувь</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/obuv-dlya-zhenschin/baletki">Балетки </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/bosonozhki">Босоножки </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/botil-ony">Ботильоны </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/botinki">Ботинки </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/botforty">Ботфорты </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/domashnyaya-obuv">Домашняя обувь </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/dutiki">Дутики </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/kedy">Кеды </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/krossovki">Кроссовки </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/lofery">Лоферы </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/mokasiny">Мокасины </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/pantolety">Пантолеты </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/polubotinki">Полуботинки </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/polusapogi">Полусапоги </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/sabo">Сабо </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/sandalii">Сандалии </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/sapogi">Сапоги </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/slancy">Сланцы </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/slipony">Слипоны </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/topsajdery">Топсайдеры </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/truby">Трубы </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/tufli">Туфли </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/tufli-zakrytye">Туфли закрытые </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/tufli-otkrytye">Туфли открытые </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/uggi">Угги </a>
                                        <a href="/catalog/obuv-dlya-zhenschin/shlepancy">Шлепанцы </a>
                                    </div>
                                </div>
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/zenskaa-odezda">Одежда</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/zenskaa-odezda/plate">Платье </a>
                                    </div>
                                </div>
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/zenskie-sumki">Сумки</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/zenskie-sumki/krossbodi">Кроссбоди </a>
                                        <a href="/catalog/zenskie-sumki/sumka">Сумка </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-dropdown" data-brand="0">
                        <div class="product_tab_links dropdown-content">
                            <a href="/catalog/muzhchinam">Мужчинам</a>
                        </div>
                        <div class="product-main-content">
                            <div class="product-main-container container">
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/obuv-dlya-myzhchin">Обувь</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/obuv-dlya-myzhchin/botinki">Ботинки </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/domashnyaya-obuv">Домашняя обувь </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/dutiki">Дутики </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/kedy">Кеды </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/krossovki">Кроссовки </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/lofery">Лоферы </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/mokasiny">Мокасины </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/pantolety">Пантолеты </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/polubotinki">Полуботинки </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/polusapogi">Полусапоги </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/sabo">Сабо </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/sandalii">Сандалии </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/sapogi">Сапоги </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/slipony">Слипоны </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/topsajdery">Топсайдеры </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/tufli">Туфли </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/uggi">Угги </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/shlepancy">Шлепанцы </a>
                                        <a href="/catalog/obuv-dlya-myzhchin/espadrili">Эспадрильи </a>
                                    </div>
                                </div>
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/muzskaa-odezda">Одежда</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/muzskaa-odezda/bejsbolka">Бейсболка </a>
                                        <a href="/catalog/muzskaa-odezda/bruki">Брюки </a>
                                        <a href="/catalog/muzskaa-odezda/bruki-sportivnye">Брюки спортивные </a>
                                        <a href="/catalog/muzskaa-odezda/vetrovka">Ветровка </a>
                                        <a href="/catalog/muzskaa-odezda/vodolazka">Водолазка </a>
                                        <a href="/catalog/muzskaa-odezda/dzemper">Джемпер </a>
                                        <a href="/catalog/muzskaa-odezda/dzinsy">Джинсы </a>
                                        <a href="/catalog/muzskaa-odezda/zaket">Жакет </a>
                                        <a href="/catalog/muzskaa-odezda/zilet">Жилет </a>
                                        <a href="/catalog/muzskaa-odezda/zilet-uteplennyj">Жилет утепленный </a>
                                        <a href="/catalog/muzskaa-odezda/kardigan">Кардиган </a>
                                        <a href="/catalog/muzskaa-odezda/kurtka">Куртка </a>
                                        <a href="/catalog/muzskaa-odezda/palto">Пальто </a>
                                        <a href="/catalog/muzskaa-odezda/pidzak">Пиджак </a>
                                        <a href="/catalog/muzskaa-odezda/plas">Плащ </a>
                                        <a href="/catalog/muzskaa-odezda/podtazki">Подтяжки </a>
                                        <a href="/catalog/muzskaa-odezda/polo-1">Поло </a>
                                        <a href="/catalog/muzskaa-odezda/pulover">Пуловер </a>
                                        <a href="/catalog/muzskaa-odezda/remen">Ремень </a>
                                        <a href="/catalog/muzskaa-odezda/rubaska">Рубашка </a>
                                        <a href="/catalog/muzskaa-odezda/sviter">Свитер </a>
                                        <a href="/catalog/muzskaa-odezda/sorocka">Сорочка </a>
                                        <a href="/catalog/muzskaa-odezda/tolstovka">Толстовка </a>
                                        <a href="/catalog/muzskaa-odezda/futbolka">Футболка </a>
                                        <a href="/catalog/muzskaa-odezda/sapka">Шапка </a>
                                        <a href="/catalog/muzskaa-odezda/sapka-sarf">Шапка-шарф </a>
                                        <a href="/catalog/muzskaa-odezda/sarf">Шарф </a>
                                        <a href="/catalog/muzskaa-odezda/sorty">Шорты </a>
                                    </div>
                                </div>
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/muzskie-sumki">Мужские сумки</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/muzskie-sumki/krossbodi">Кроссбоди </a>
                                        <a href="/catalog/muzskie-sumki/portfel">Портфель </a>
                                        <a href="/catalog/muzskie-sumki/rukzak">Рюкзак </a>
                                        <a href="/catalog/muzskie-sumki/sumka">Сумка </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-dropdown" data-brand="0">
                        <div class="product_tab_links dropdown-content">
                            <a href="/catalog/detyam">Детям</a>
                        </div>
                        <div class="product-main-content">
                            <div class="product-main-container container">
                                <div class="product_rows">
                                    <div class="catalog_products_name">
                                        <a href="/catalog/obuv-dlya-detei">Обувь</a>
                                    </div>
                                    <div class="category_products">
                                        <a href="/catalog/obuv-dlya-detei/baletki">Балетки </a>
                                        <a href="/catalog/obuv-dlya-detei/bosonozhki">Босоножки </a>
                                        <a href="/catalog/obuv-dlya-detei/botinki">Ботинки </a>
                                        <a href="/catalog/obuv-dlya-detei/valenki">Валенки </a>
                                        <a href="/catalog/obuv-dlya-detei/dutiki">Дутики </a>
                                        <a href="/catalog/obuv-dlya-detei/kedy">Кеды </a>
                                        <a href="/catalog/obuv-dlya-detei/kroksy">Кроксы </a>
                                        <a href="/catalog/obuv-dlya-detei/krossovki">Кроссовки </a>
                                        <a href="/catalog/obuv-dlya-detei/mokasiny">Мокасины </a>
                                        <a href="/catalog/obuv-dlya-detei/polubotinki">Полуботинки </a>
                                        <a href="/catalog/obuv-dlya-detei/polusapogi">Полусапоги </a>
                                        <a href="/catalog/obuv-dlya-detei/rezinovye-sapogi">Резиновые сапоги </a>
                                        <a href="/catalog/obuv-dlya-detei/sandalii">Сандалии </a>
                                        <a href="/catalog/obuv-dlya-detei/sapogi">Сапоги </a>
                                        <a href="/catalog/obuv-dlya-detei/tufli">Туфли </a>
                                        <a href="/catalog/obuv-dlya-detei/shlepancy">Шлепанцы </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-dropdown" data-brand="1">
                        <div class="product_tab_links dropdown-content">
                            Бренды
                        </div>
                        <div class="product-main-content">
                            <div class="product-main-container container">
                                <div class="product_rows">
                                    <div class="catalog_products_name">

                                    </div>
                                    <div class="category_products">
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
                                        <a href="/brand/gianfranco-butteri">Gianfranco Butteri </a>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="/search" class="search_block" method="GET">
                    <input type="search" placeholder="Поиск" name="str" id="searchControl">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                         onclick="this.parentNode.submit()">
                        <path
                            d="M21 21L15.0001 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                            stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </form>
            </div>
        </div>

        <div class="bottom-menu-main">
            <div class="mobile-search-wrap" id="mobileSearchWrap">
                <form action="/search" method="GET">
                    <input type="search" placeholder="Поиск" name="str" id="mobileSearchControl">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                         onclick="this.parentNode.submit()">
                        <path
                            d="M21 21L15.0001 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                            stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </form>
            </div>
            <a href="/search" class="bottom-menu-category" id="mobileMenuSearchItem">
                <div class="cirlce-bottom-menu">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 21L15.0001 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                            stroke="#939393" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <span>Поиск</span>
            </a>
            <a href="/contacts" class="bottom-menu-category">
                <div class="cirlce-bottom-menu">
                    <svg viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20.75 16.9987V11.4508C20.75 10.9164 20.7495 10.6491 20.6846 10.4005C20.627 10.1801 20.5325 9.9716 20.4046 9.78318C20.2602 9.57055 20.0596 9.39422 19.6574 9.04236L14.8574 4.84236C14.1108 4.18908 13.7375 3.8626 13.3174 3.73836C12.9472 3.62888 12.5526 3.62888 12.1824 3.73836C11.7626 3.86251 11.3898 4.18867 10.6444 4.84097L5.84277 9.04236C5.44064 9.39423 5.24004 9.57055 5.0957 9.78318C4.96779 9.97161 4.87255 10.1801 4.81497 10.4005C4.75 10.6491 4.75 10.9164 4.75 11.4508V16.9987C4.75 17.9306 4.75 18.3963 4.90224 18.7639C5.10523 19.2539 5.49432 19.6438 5.98438 19.8468C6.35192 19.999 6.81786 19.999 7.74974 19.999C8.68163 19.999 9.14808 19.999 9.51562 19.8468C10.0057 19.6438 10.3947 19.254 10.5977 18.764C10.7499 18.3964 10.75 17.9305 10.75 16.9986V15.9986C10.75 14.894 11.6454 13.9986 12.75 13.9986C13.8546 13.9986 14.75 14.894 14.75 15.9986V16.9986C14.75 17.9305 14.75 18.3964 14.9022 18.764C15.1052 19.254 15.4943 19.6438 15.9844 19.8468C16.3519 19.999 16.8179 19.999 17.7497 19.999C18.6816 19.999 19.1481 19.999 19.5156 19.8468C20.0057 19.6438 20.3947 19.2539 20.5977 18.7639C20.7499 18.3963 20.75 17.9306 20.75 16.9987Z"
                            stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <span>О нас</span>
            </a>
            <a href="/" class="bottom-menu-category bottom-menu-main-block" id="mobileMenuMenuItem">
                <div class="cirlce-bottom-menu">
                    <svg viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.5 18C17.5 18.5523 17.9477 19 18.5 19C19.0523 19 19.5 18.5523 19.5 18C19.5 17.4477 19.0523 17 18.5 17C17.9477 17 17.5 17.4477 17.5 18Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M11.5 18C11.5 18.5523 11.9477 19 12.5 19C13.0523 19 13.5 18.5523 13.5 18C13.5 17.4477 13.0523 17 12.5 17C11.9477 17 11.5 17.4477 11.5 18Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M5.5 18C5.5 18.5523 5.94772 19 6.5 19C7.05228 19 7.5 18.5523 7.5 18C7.5 17.4477 7.05228 17 6.5 17C5.94772 17 5.5 17.4477 5.5 18Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M17.5 12C17.5 12.5523 17.9477 13 18.5 13C19.0523 13 19.5 12.5523 19.5 12C19.5 11.4477 19.0523 11 18.5 11C17.9477 11 17.5 11.4477 17.5 12Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M11.5 12C11.5 12.5523 11.9477 13 12.5 13C13.0523 13 13.5 12.5523 13.5 12C13.5 11.4477 13.0523 11 12.5 11C11.9477 11 11.5 11.4477 11.5 12Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M5.5 12C5.5 12.5523 5.94772 13 6.5 13C7.05228 13 7.5 12.5523 7.5 12C7.5 11.4477 7.05228 11 6.5 11C5.94772 11 5.5 11.4477 5.5 12Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M17.5 6C17.5 6.55228 17.9477 7 18.5 7C19.0523 7 19.5 6.55228 19.5 6C19.5 5.44772 19.0523 5 18.5 5C17.9477 5 17.5 5.44772 17.5 6Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M11.5 6C11.5 6.55228 11.9477 7 12.5 7C13.0523 7 13.5 6.55228 13.5 6C13.5 5.44772 13.0523 5 12.5 5C11.9477 5 11.5 5.44772 11.5 6Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path
                            d="M5.5 6C5.5 6.55228 5.94772 7 6.5 7C7.05228 7 7.5 6.55228 7.5 6C7.5 5.44772 7.05228 5 6.5 5C5.94772 5 5.5 5.44772 5.5 6Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <span>Меню</span>
            </a>
            <a href="/" class="bottom-menu-category" data-bs-toggle="modal" data-bs-target="#log-in">
                <div class="cirlce-bottom-menu">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M3 20C5.33579 17.5226 8.50702 16 12 16C15.493 16 18.6642 17.5226 21 20M16.5 7.5C16.5 9.98528 14.4853 12 12 12C9.51472 12 7.5 9.98528 7.5 7.5C7.5 5.01472 9.51472 3 12 3C14.4853 3 16.5 5.01472 16.5 7.5Z"
                            stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <span>Профиль</span>
            </a>
            <a href="/cart" class="bottom-menu-category" id="miniCartMobile">
                <div class="cirlce-bottom-menu">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.9984 9V6C15.9984 3.79086 14.2076 2 11.9984 2C9.78928 2 7.99842 3.79086 7.99842 6V9M3.59042 10.352L2.99042 16.752C2.81982 18.5717 2.73452 19.4815 3.03647 20.1843C3.30171 20.8016 3.76653 21.3121 4.35643 21.6338C5.02794 22 5.94178 22 7.76946 22H16.2274C18.055 22 18.9689 22 19.6404 21.6338C20.2303 21.3121 20.6951 20.8016 20.9604 20.1843C21.2623 19.4815 21.177 18.5717 21.0064 16.752L20.4064 10.352C20.2624 8.81535 20.1903 8.04704 19.8448 7.46616C19.5404 6.95458 19.0908 6.54511 18.553 6.28984C17.9424 6 17.1707 6 15.6274 6L8.36946 6C6.82611 6 6.05443 6 5.44383 6.28984C4.90608 6.54511 4.45642 6.95458 4.15208 7.46616C3.80651 8.04704 3.73448 8.81534 3.59042 10.352Z"
                            stroke="#3B3B3B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <span>Корзина</span>
            </a>
        </div>
    </header>

    <section class="product-section">
        <div class="container">
            <nav aria-label="Breadcrumbs">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="/">Главная</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="/catalog/muzhchinam">Мужчинам</a>
                    </li>
                </ol>
            </nav>
            <script type="application/ld+json">
                {"@context":"https:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"&#x041C;&#x0443;&#x0436;&#x0447;&#x0438;&#x043D;&#x0430;&#x043C;","item":"\/catalog\/muzhchinam"}]}
            </script>
            <div>
                <div class="product-title-main">
                    Мужчинам
                </div>

                <div class="catalog-content-row">
                    <div class="catalog-product-main">
                        <div class="product_rows active">
                            <div class="catalog_products_name">Обувь</div>
                            <div class="category_products">
                                <a href="/catalog/obuv-dlya-myzhchin/botinki">Ботинки </a>
                                <a href="/catalog/obuv-dlya-myzhchin/domashnyaya-obuv">Домашняя обувь </a>
                                <a href="/catalog/obuv-dlya-myzhchin/dutiki">Дутики </a>
                                <a href="/catalog/obuv-dlya-myzhchin/kedy">Кеды </a>
                                <a href="/catalog/obuv-dlya-myzhchin/krossovki">Кроссовки </a>
                                <a href="/catalog/obuv-dlya-myzhchin/lofery">Лоферы </a>
                                <a href="/catalog/obuv-dlya-myzhchin/mokasiny">Мокасины </a>
                                <a href="/catalog/obuv-dlya-myzhchin/pantolety">Пантолеты </a>
                                <a href="/catalog/obuv-dlya-myzhchin/polubotinki">Полуботинки </a>
                                <a href="/catalog/obuv-dlya-myzhchin/polusapogi">Полусапоги </a>
                                <a href="/catalog/obuv-dlya-myzhchin/sabo">Сабо </a>
                                <a href="/catalog/obuv-dlya-myzhchin/sandalii">Сандалии </a>
                                <a href="/catalog/obuv-dlya-myzhchin/sapogi">Сапоги </a>
                                <a href="/catalog/obuv-dlya-myzhchin/slipony">Слипоны </a>
                                <a href="/catalog/obuv-dlya-myzhchin/topsajdery">Топсайдеры </a>
                                <a href="/catalog/obuv-dlya-myzhchin/tufli">Туфли </a>
                                <a href="/catalog/obuv-dlya-myzhchin/uggi">Угги </a>
                                <a href="/catalog/obuv-dlya-myzhchin/shlepancy">Шлепанцы </a>
                                <a href="/catalog/obuv-dlya-myzhchin/espadrili">Эспадрильи </a>
                            </div>
                        </div>
                        <div class="product_rows active">
                            <div class="catalog_products_name">Одежда</div>
                            <div class="category_products">
                                <a href="/catalog/muzskaa-odezda/bejsbolka">Бейсболка </a>
                                <a href="/catalog/muzskaa-odezda/bruki">Брюки </a>
                                <a href="/catalog/muzskaa-odezda/bruki-sportivnye">Брюки спортивные </a>
                                <a href="/catalog/muzskaa-odezda/vetrovka">Ветровка </a>
                                <a href="/catalog/muzskaa-odezda/vodolazka">Водолазка </a>
                                <a href="/catalog/muzskaa-odezda/dzemper">Джемпер </a>
                                <a href="/catalog/muzskaa-odezda/dzinsy">Джинсы </a>
                                <a href="/catalog/muzskaa-odezda/zaket">Жакет </a>
                                <a href="/catalog/muzskaa-odezda/zilet">Жилет </a>
                                <a href="/catalog/muzskaa-odezda/zilet-uteplennyj">Жилет утепленный </a>
                                <a href="/catalog/muzskaa-odezda/kardigan">Кардиган </a>
                                <a href="/catalog/muzskaa-odezda/kurtka">Куртка </a>
                                <a href="/catalog/muzskaa-odezda/nizhnee-bele">Нижнее белье </a>
                                <a href="/catalog/muzskaa-odezda/palto">Пальто </a>
                                <a href="/catalog/muzskaa-odezda/pidzak">Пиджак </a>
                                <a href="/catalog/muzskaa-odezda/plas">Плащ </a>
                                <a href="/catalog/muzskaa-odezda/podtazki">Подтяжки </a>
                                <a href="/catalog/muzskaa-odezda/polo-1">Поло </a>
                                <a href="/catalog/muzskaa-odezda/pulover">Пуловер </a>
                                <a href="/catalog/muzskaa-odezda/remen">Ремень </a>
                                <a href="/catalog/muzskaa-odezda/rubaska">Рубашка </a>
                                <a href="/catalog/muzskaa-odezda/sviter">Свитер </a>
                                <a href="/catalog/muzskaa-odezda/sorocka">Сорочка </a>
                                <a href="/catalog/muzskaa-odezda/tolstovka">Толстовка </a>
                                <a href="/catalog/muzskaa-odezda/futbolka">Футболка </a>
                                <a href="/catalog/muzskaa-odezda/sapka">Шапка </a>
                                <a href="/catalog/muzskaa-odezda/sapka-sarf">Шапка-шарф </a>
                                <a href="/catalog/muzskaa-odezda/sarf">Шарф </a>
                                <a href="/catalog/muzskaa-odezda/sorty">Шорты </a>
                            </div>
                        </div>
                        <div class="product_rows active">
                            <div class="catalog_products_name">Мужские сумки</div>
                            <div class="category_products">
                                <a href="/catalog/muzskie-sumki/krossbodi">Кроссбоди </a>
                                <a href="/catalog/muzskie-sumki/portfel">Портфель </a>
                                <a href="/catalog/muzskie-sumki/rukzak">Рюкзак </a>
                                <a href="/catalog/muzskie-sumki/sumka">Сумка </a>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-product-second-block">
                        <div class="freeze hide"></div>
                        <p>Подборка обуви, одежды и аксессуаров для мужчин от лучших российских и зарубежных
                            производителей.</p>
                        <div class="filter-head-body" id="filtersWrap" data-sort="popular" data-pagesize="48"
                             data-page="1" data-init-active-blocks="[]">
                            <div class="filter-mobile-head">
                                <svg viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.3346 1.73079C11.3346 1.35743 11.3344 1.1706 11.2617 1.02799C11.1978 0.902553 11.0962 0.80064 10.9708 0.736725C10.8282 0.664062 10.6411 0.664062 10.2677 0.664062H1.73438C1.36101 0.664062 1.17451 0.664062 1.0319 0.736725C0.90646 0.80064 0.804547 0.902553 0.740631 1.02799C0.667969 1.1706 0.667969 1.35743 0.667969 1.73079V2.2223C0.667969 2.38536 0.667969 2.46695 0.686389 2.54368C0.70272 2.6117 0.729724 2.67668 0.766276 2.73633C0.807491 2.80358 0.86524 2.86133 0.980469 2.97656L4.35563 6.35172C4.47092 6.46702 4.52826 6.52436 4.56949 6.59163C4.60604 6.65128 4.63341 6.71648 4.64974 6.78451C4.66797 6.86045 4.66797 6.94108 4.66797 7.10083V10.2714C4.66797 10.8429 4.66797 11.1288 4.78833 11.3009C4.89343 11.4511 5.05557 11.5514 5.23698 11.5782C5.44473 11.6089 5.70044 11.4812 6.21159 11.2257L6.74492 10.959C6.95896 10.852 7.06572 10.7983 7.14391 10.7184C7.21306 10.6478 7.26596 10.563 7.29818 10.4696C7.33461 10.364 7.33464 10.244 7.33464 10.0047V7.10579C7.33464 6.94273 7.33464 6.86123 7.35306 6.78451C7.36939 6.71648 7.39639 6.65128 7.43294 6.59163C7.4739 6.5248 7.53108 6.46762 7.64485 6.35385L7.64714 6.35172L11.0223 2.97656C11.1376 2.86126 11.1949 2.80361 11.2362 2.73633C11.2727 2.67668 11.3001 2.6117 11.3164 2.54368C11.3346 2.46774 11.3346 2.38702 11.3346 2.22726V1.73079Z"
                                        stroke="#3B3B3B" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                Фильтры
                            </div>
                            <div class="filter-head-first-block">
                                <div class="filter-block" data-type="sort" data-filter="sr">
                                    <div class="color-select-main popular-elements-select color-elements"
                                         data-prop="box">
                                        <div class="color-product-body">
                                            <div class="color-product-search-head text-class">
                                                <span>По популярности</span>
                                            </div>
                                        </div>
                                        <div class="filter-range-price color-category-choose">
                                            <div class="select-main-block">
                                                <label class="color-product-body tab-class">
                                                    <input type="radio" name="sort" value="popular" checked="checked"
                                                           class="visually-hidden">
                                                    <div class="color-product-search">По популярности</div>
                                                </label>
                                                <label class="color-product-body tab-class">
                                                    <input type="radio" name="sort" value="price_asc"
                                                           class="visually-hidden">
                                                    <div class="color-product-search">По возрастанию цены</div>
                                                </label>
                                                <label class="color-product-body tab-class">
                                                    <input type="radio" name="sort" value="price_desc"
                                                           class="visually-hidden">
                                                    <div class="color-product-search">По убыванию цены</div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="filter-block" data-filter="br" data-type="thesaurus" data-filter-active="0"
                                     data-filter-last="0">
                                    <div class="filter-parent-block">
                                        <div class="color-select-main brands-product-body brand-prod-body-main"
                                             data-placeholder="Бренд" data-prop="box">
                                            <div class="color-product-body" data-prop="label">
                                                <div class="color-product-search-head text-class">
                                                    <span data-prop="labelText">Бренд</span>
                                                </div>
                                            </div>
                                            <div class="filter-range-price color-category-choose" data-prop="content">
                                                <div class="input-search-brands">
                                                    <input type="text" placeholder="Поиск" data-prop="search"
                                                           data-notfount="Ничего не найдено">
                                                </div>
                                                <div class="select-main-block" data-prop="items">
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="11" data-item-id="60" data-item-active="0">
                                                        <input type="checkbox" name="60" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            ARA
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="15930"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15930" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Adanex
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="7546" data-item-active="0">
                                                        <input type="checkbox" name="7546" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Alberto Guardiani
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="15780"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15780" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Antonello
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15945"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15945" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            BREMENGEN
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="13" data-item-id="14140"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="14140" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Baden
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="26" data-item-id="15937"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15937" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Barcelo Biagi
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="7562" data-item-active="0">
                                                        <input type="checkbox" name="7562" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Barracuda
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="6" data-item-id="7548" data-item-active="0">
                                                        <input type="checkbox" name="7548" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Brimarts
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="298" data-item-id="15781"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15781" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Bugatti
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="12711"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="12711" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Calvin Klein Jeans
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="133" data-item-id="15836"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15836" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Casa Moda
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="23" data-item-id="15868"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15868" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            DESOTO
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="15922"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15922" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Evalli
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="7545" data-item-active="0">
                                                        <input type="checkbox" name="7545" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            FABI
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="12" data-item-id="15806"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15806" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Finn Line
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="11" data-item-id="15861"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15861" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            GLAMFOREVER
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="11319"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="11319" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            GNV
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="11320"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="11320" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            GOOD MAN
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="9" data-item-id="7547" data-item-active="0">
                                                        <input type="checkbox" name="7547" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Giampieronicola
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="7549" data-item-active="0">
                                                        <input type="checkbox" name="7549" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Gianfranco Butteri
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="7551" data-item-active="0">
                                                        <input type="checkbox" name="7551" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Giovanni Ciccioli
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="10476"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="10476" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Hardwood
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="6" data-item-id="15935"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15935" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Marko
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15797"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15797" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            NG
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="12" data-item-id="9267"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="9267" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            NordKraft
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15849"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15849" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            PATROL
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="43" data-item-id="15933"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15933" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            RAGMAN
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="32" data-item-id="9312"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="9312" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            ROMER
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="120" data-item-id="64" data-item-active="0">
                                                        <input type="checkbox" name="64" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Respect
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="127" data-item-id="6275"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="6275" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Rieker
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="7550" data-item-active="0">
                                                        <input type="checkbox" name="7550" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Roberto Serpentini
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="114" data-item-id="15785"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15785" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Roy Robson
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="22" data-item-id="9313"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="9313" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            S.Oliver
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="18" data-item-id="15946"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15946" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Salamander
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="10475"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="10475" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Sot Edition
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="15668"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15668" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            TFS
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="22" data-item-id="15805"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15805" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            TORSION FIELD
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="15" data-item-id="7867"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="7867" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            TRIEN
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15931"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15931" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Tapaki
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="114" data-item-id="65" data-item-active="0">
                                                        <input type="checkbox" name="65" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Tofa
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="52" data-item-id="15835"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15835" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Venti
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="11683"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="11683" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Vidorreta
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-block" data-filter="sz" data-type="offers" data-filter-active="0"
                                     data-filter-last="0">
                                    <div class="filter-parent-block">
                                        <div class="color-select-main brands-product-body brand-prod-body-main"
                                             data-placeholder="Размер" data-prop="box">
                                            <div class="color-product-body" data-prop="label">
                                                <div class="color-product-search-head text-class">
                                                    <span data-prop="labelText">Размер</span>
                                                </div>
                                            </div>
                                            <div class="filter-range-price color-category-choose" data-prop="content">
                                                <div class="input-search-brands">
                                                    <input type="text" placeholder="Поиск" data-prop="search"
                                                           data-notfount="Ничего не найдено">
                                                </div>
                                                <div class="select-main-block" data-prop="items">
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="8" data-item-id="595022058"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="595022058" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            100
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="3447271878"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3447271878"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            102
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="11" data-item-id="1394451557"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1394451557"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            105
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="3390371295"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3390371295"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            106
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="11" data-item-id="980181419"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="980181419" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            110
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="1241945380"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1241945380"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            115
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="289485416"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="289485416" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            120
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="633385576"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="633385576" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            17-26
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="1436604618"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1436604618"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            19-29
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="4290244609"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="4290244609"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            20-26
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="2293285015"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2293285015"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            20-27
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="265249909"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="265249909" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            20-30
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="4196041389"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="4196041389"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            25
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="1662243607"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1662243607"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            26
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="9" data-item-id="336913281"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="336913281" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            27
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="2225864208"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2225864208"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            28
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="2473281379"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2473281379"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            30
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="3832313845"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3832313845"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            31
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="302037738"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="302037738" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            31/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="4217577439"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="4217577439"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            31/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="2103780943"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2103780943"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="1436598330"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1436598330"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            32/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="6" data-item-id="3166921999"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3166921999"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            32/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="174200537"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="174200537" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            33
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="1757473162"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1757473162"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            33/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="2174962879"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2174962879"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            33/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="2483454842"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2483454842"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="3672126874"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3672126874"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            34/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="15" data-item-id="864260271"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="864260271" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            34/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="3717067139"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3717067139"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            34/L36
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="3808539628"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3808539628"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            35
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="8" data-item-id="3883932714"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3883932714"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            35/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="17" data-item-id="249805087"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="249805087" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            35/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="3773683763"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3773683763"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            35/L36
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="2047402582"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2047402582"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            36
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="2686478074"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2686478074"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            36/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="13" data-item-id="1229177807"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1229177807"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            36/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="2806883043"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2806883043"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            36/L36
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="219140800"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="219140800" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            37
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="2645610321"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2645610321"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            38
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="521197723"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="521197723" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            38/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="9" data-item-id="4134763950"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="4134763950"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            38/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="410852482"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="410852482" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            38/L36
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="84" data-item-id="3937927111"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3937927111"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            39
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="163" data-item-id="3563345980"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3563345980"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            3XL
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="311" data-item-id="3693793700"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3693793700"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            40
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="845521890"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="845521890" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            40/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="7" data-item-id="3674605271"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3674605271"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            40/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="889743355"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="889743355" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            40/L36
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="388" data-item-id="2871910706"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2871910706"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            41
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="2599998773"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2599998773"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            41/42
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="297" data-item-id="841265288"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="841265288" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            42
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="4283058765"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="4283058765"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            42/43
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="1218834562"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1218834562"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            42/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="2714129847"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2714129847"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            42/L34
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="279" data-item-id="1159954462"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1159954462"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            43
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="228" data-item-id="3678868925"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3678868925"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            44
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="860008612"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="860008612" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            44/45
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="3353675042"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3353675042"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            44/L32
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="207" data-item-id="2889884971"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2889884971"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            45
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="91" data-item-id="894006417"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="894006417" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            46
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="30" data-item-id="1112425479"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1112425479"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            47
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="25" data-item-id="3539032470"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3539032470"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            48
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="67" data-item-id="3509276345"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3509276345"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            4XL
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="56" data-item-id="3308380389"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3308380389"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            50
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="55" data-item-id="725582281"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="725582281" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            52
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="48" data-item-id="3260818684"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3260818684"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            54
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="47" data-item-id="743589328"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="743589328" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            56
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="32" data-item-id="3421137111"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3421137111"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            58
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="3504940174"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3504940174"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            5XL
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="3994858278"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3994858278"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            60
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="1233418"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1233418" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            62
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="3916527423"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3916527423"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            64
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="3534723799"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3534723799"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            6XL
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="16083495"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="16083495" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            85
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="7" data-item-id="1770303465"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1770303465"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            90
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="1860791280"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1860791280"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            94
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="7" data-item-id="435051366"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="435051366" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            95
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="1734289371"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1734289371"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            98
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="194" data-item-id="2909332022"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2909332022"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            L
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="162" data-item-id="3664761504"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3664761504"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            M
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="55" data-item-id="543223747"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="543223747" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            S
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="193" data-item-id="1288816664"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="1288816664"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            XL
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="3252274669"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="3252274669"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            XS
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="217" data-item-id="2431024381"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="2431024381"
                                                               class="visually-hidden">
                                                        <div class="color-product-search">
                                                            XXL
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-block" data-filter="cl" data-type="thesaurus" data-filter-active="0"
                                     data-filter-last="0">
                                    <div class="filter-parent-block">
                                        <div class="color-select-main brands-product-body brand-prod-body-main"
                                             data-placeholder="Цвет" data-prop="box">
                                            <div class="color-product-body" data-prop="label">
                                                <div class="color-product-search-head text-class">
                                                    <span data-prop="labelText">Цвет</span>
                                                </div>
                                            </div>
                                            <div class="filter-range-price color-category-choose" data-prop="content">
                                                <div class="input-search-brands">
                                                    <input type="text" placeholder="Поиск" data-prop="search"
                                                           data-notfount="Ничего не найдено">
                                                </div>
                                                <div class="select-main-block" data-prop="items">
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15630"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15630" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Антрацит
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="113" data-item-id="15503"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15503" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Бежевый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="53" data-item-id="15510"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15510" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Белый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="15522"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15522" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Бирюзовый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15555"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15555" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Бордо
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="12" data-item-id="15582"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15582" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Бордовый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="54" data-item-id="15519"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15519" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Голубой
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="15587"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15587" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Джинс
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="16" data-item-id="15523"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15523" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Желтый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="53" data-item-id="15513"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15513" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Зеленый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="126" data-item-id="15525"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15525" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            <span style="background: #660000"></span>
                                                            Коричневый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="22" data-item-id="15530"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15530" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Красный
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="15524"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15524" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Молочный
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15580"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15580" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Мультицвет
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="15648"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15648" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Оливковый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="20" data-item-id="15521"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15521" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Оранжевый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15533"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15533" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Рисовый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="8" data-item-id="15527"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15527" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Розовый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="12" data-item-id="15568"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15568" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Рыжий
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="15537"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15537" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Салатовый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="15557"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15557" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Серебряный
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="100" data-item-id="15520"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15520" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Серый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="347" data-item-id="15518"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15518" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            <span style="background: #0000ff"></span>
                                                            Синий
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="15563"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15563" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Фиолетовый
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="15590"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15590" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Хаки
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15542"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15542" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Цветные
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="368" data-item-id="15507"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15507" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            <span style="background: #000000"></span>
                                                            Черный
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-block" data-filter="sn" data-type="thesaurus" data-filter-active="0"
                                     data-filter-last="0">
                                    <div class="filter-parent-block">
                                        <div class="color-select-main brands-product-body brand-prod-body-main"
                                             data-placeholder="Сезон" data-prop="box">
                                            <div class="color-product-body" data-prop="label">
                                                <div class="color-product-search-head text-class">
                                                    <span data-prop="labelText">Сезон</span>
                                                </div>
                                            </div>
                                            <div class="filter-range-price color-category-choose" data-prop="content">
                                                <div class="select-main-block" data-prop="items">
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="635" data-item-id="15500"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15500" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Демисезон
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="293" data-item-id="15501"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15501" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Зима
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="856" data-item-id="15502"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15502" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Лето
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-block price-product" data-prop="box" data-filter="pr"
                                     data-type="price" data-filter-active="0" data-filter-last="0">
                                    <div class="price-block-header" data-placeholder="Цена">
                                        Цена
                                    </div>
                                    <div class="filter-parent-block">
                                        <div class="range filter-range-price">
                                            <div class="range-slider">
                                                <span class="range-selected"></span>
                                            </div>
                                            <div class="range-input">
                                                <input type="range" name="min" class="min input-range-value" min="500"
                                                       max="54170" value="500" step="10">
                                                <input type="range" name="max" class="max input-range-value" min="500"
                                                       max="54170" value="54170" step="10">
                                            </div>
                                            <div class="range-price">
                                                <div class="range-input-block">От<input type="number" name="min"
                                                                                        value="" placeholder="500"
                                                                                        min="500" max="54170"></div>
                                                <div class="range-input-block">До<input type="number" name="max"
                                                                                        value="" placeholder="54170"
                                                                                        min="500" max="54170"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-block" data-filter="mt" data-type="thesaurus" data-filter-active="0"
                                     data-filter-last="0">
                                    <div class="filter-parent-block">
                                        <div class="color-select-main brands-product-body brand-prod-body-main"
                                             data-placeholder="Материал верха" data-prop="box">
                                            <div class="color-product-body" data-prop="label">
                                                <div class="color-product-search-head text-class">
                                                    <span data-prop="labelText">Материал верха</span>
                                                </div>
                                            </div>
                                            <div class="filter-range-price color-category-choose" data-prop="content">
                                                <div class="input-search-brands">
                                                    <input type="text" placeholder="Поиск" data-prop="search"
                                                           data-notfount="Ничего не найдено">
                                                </div>
                                                <div class="select-main-block" data-prop="items">
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15885"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15885" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Акрил
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="15529"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15529" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Велюр
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="52" data-item-id="15869"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15869" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Вискоза
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="15576"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15576" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Замша натуральная
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="125" data-item-id="15511"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15511" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Искусственная кожа
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="15552"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15552" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Искусственные материалы
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="8" data-item-id="15884"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15884" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Кашемир
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15583"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15583" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Лаковая натуральная кожа
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="37" data-item-id="15832"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15832" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Лён
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="26" data-item-id="15504"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15504" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Натуральная замша
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="462" data-item-id="15508"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15508" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Натуральная кожа
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="50" data-item-id="15514"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15514" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Нубук
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="15834"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15834" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полиакрил
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="62" data-item-id="15833"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15833" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полиамид
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="7" data-item-id="15657"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15657" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полимер
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15859"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15859" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полиуретан
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="162" data-item-id="15829"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15829" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полиэстер
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15564"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15564" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Резина
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="15569"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15569" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Спилок
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="121" data-item-id="15515"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15515" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Текстиль
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="451" data-item-id="15830"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15830" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Хлопок
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="71" data-item-id="15837"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15837" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Шерсть
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15659"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15659" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            ЭВА
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="153" data-item-id="15831"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15831" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Эластан
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="4" data-item-id="15870"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15870" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Эластомультиэстер
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="15924"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15924" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            флис
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="filter-block" data-filter="ln" data-type="thesaurus" data-filter-active="0"
                                     data-filter-last="0">
                                    <div class="filter-parent-block">
                                        <div class="color-select-main brands-product-body brand-prod-body-main"
                                             data-placeholder="Подкладка" data-prop="box">
                                            <div class="color-product-body" data-prop="label">
                                                <div class="color-product-search-head text-class">
                                                    <span data-prop="labelText">Подкладка</span>
                                                </div>
                                            </div>
                                            <div class="filter-range-price color-category-choose" data-prop="content">
                                                <div class="input-search-brands">
                                                    <input type="text" placeholder="Поиск" data-prop="search"
                                                           data-notfount="Ничего не найдено">
                                                </div>
                                                <div class="select-main-block" data-prop="items">
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="19" data-item-id="15539"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15539" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Б/П
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="10" data-item-id="15554"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15554" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Байка
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="72" data-item-id="15531"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15531" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Без подкладки
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="5" data-item-id="15798"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15798" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Велюр
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="9" data-item-id="15561"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15561" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Ворсин
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15637"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15637" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Замша
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15647"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15647" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Искусственная Шерсть
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="47" data-item-id="15512"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15512" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Искусственная кожа
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15553"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15553" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Искусственные материалы
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15556"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15556" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Искусственный мех
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15794"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15794" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Микровелюр
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="15820"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15820" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Микрофибра
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="218" data-item-id="15505"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15505" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Натуральная кожа
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="2" data-item-id="15622"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15622" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Натуральные материалы
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="30" data-item-id="15548"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15548" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Натуральный мех
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15938"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15938" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полиамид
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="9" data-item-id="15939"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15939" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Полиэстер
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="241" data-item-id="15544"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15544" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Текстиль
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15613"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15613" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Текстиль с мембраной
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15654"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15654" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Хлопок
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="3" data-item-id="15940"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15940" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Шевро
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="82" data-item-id="15550"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15550" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Шерсть
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="11" data-item-id="15614"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15614" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Шерсть с мембраной
                                                        </div>
                                                    </label>
                                                    <label class="color-product-body tab-class" data-prop="item"
                                                           data-item-count="1" data-item-id="15958"
                                                           data-item-active="0">
                                                        <input type="checkbox" name="15958" class="visually-hidden">
                                                        <div class="color-product-search">
                                                            Эластан
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="reset-save-btns-main">
                                    <div class="reset-select-block close-selects-result">Сбросить фильтры</div>
                                    <a href="#" class="show-more-card save-change-filter">Показать товары</a>
                                </div>
                            </div>
                        </div>
                        <div id="productsContent">
                            <div class="product-filter-main-content">

                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22884"
                                     data-ecom="{&quot;id&quot;:22884,&quot;name&quot;:&quot;\u0422\u0443\u0444\u043b\u0438 \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22884&quot;,&quot;price&quot;:12740,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Barcelo Biagi,Туфли,1977Y-17-F07">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/tufli-muzhskie-barcelo-biagi-22884-1977y-17-f07"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22884-e06e16fdc2ed-1977y-17-f07-tufli-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/tufli-muzhskie-barcelo-biagi-22884-1977y-17-f07"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Туфли мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    12 740 ₽
                                                    <meta itemprop="price" content="12740">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                39, 40, 41, 42, 43
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22790"
                                     data-ecom="{&quot;id&quot;:22790,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22790&quot;,&quot;price&quot;:3790,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629226 180">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22790-629226-180"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22790-05e1893799ed-629226-180-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22790-629226-180"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    3 790 ₽
                                                    <meta itemprop="price" content="3790">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                20-26
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22828"
                                     data-ecom="{&quot;id&quot;:22828,&quot;name&quot;:&quot;\u0414\u0436\u0435\u043c\u043f\u0435\u0440 \u043c\u0443\u0436\u0441\u043a\u043e\u0439 Casa Moda 22828&quot;,&quot;price&quot;:9440,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Джемпер,413572800 668">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/dzhemper-muzhskoi-casa-moda-22828-413572800-668"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22828-44c6b01f79c5-413572800-668-dzhemper-muzhskoi-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/dzhemper-muzhskoi-casa-moda-22828-413572800-668"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Джемпер мужской Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    9 440 ₽
                                                    <meta itemprop="price" content="9440">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, 4XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22855"
                                     data-ecom="{&quot;id&quot;:22855,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Casa Moda 22855&quot;,&quot;price&quot;:5810,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Поло,004470 488">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22855-004470-488"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22855-1688824f0b3a-004470-488-polo-muzhskoye-k-r-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22855-004470-488"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    5 810 ₽
                                                    <meta itemprop="price" content="5810">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                L, M, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22810"
                                     data-ecom="{&quot;id&quot;:22810,&quot;name&quot;:&quot;\u0424\u0443\u0442\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Roy Robson 22810&quot;,&quot;price&quot;:4510,&quot;brand&quot;:&quot;Roy Robson&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Roy Robson,Футболка,090 14830 1228600 14830-90 A370">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/futbolka-muzhskaia-roy-robson-22810-090-14830-1228600-14830-90-a370"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/no/22810-61b2ad7c13a4-090-14830-1228600-14830-90-a370-futbolka-muzhskaya-roy-robson-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/futbolka-muzhskaia-roy-robson-22810-090-14830-1228600-14830-90-a370"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Футболка мужская Roy Robson
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    4 510 ₽
                                                    <meta itemprop="price" content="4510">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22776"
                                     data-ecom="{&quot;id&quot;:22776,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Bugatti 22776&quot;,&quot;price&quot;:8660,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Поло,8151 75100C 550">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22776-8151-75100c-550"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22776-dce2a4d8864e-8151-75100c-550-polo-muzhskoye-k-r-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22776-8151-75100c-550"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    8 660 ₽
                                                    <meta itemprop="price" content="8660">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                4XL, L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22870"
                                     data-ecom="{&quot;id&quot;:22870,&quot;name&quot;:&quot;\u041a\u0435\u0434\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22870&quot;,&quot;price&quot;:11980,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Barcelo Biagi,Кеды,2688AKB-0309">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/kedy-muzhskie-barcelo-biagi-22870-2688akb-0309"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22870-2508435de757-2688akb-0309-kedy-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/kedy-muzhskie-barcelo-biagi-22870-2688akb-0309"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Кеды мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    11 980 ₽
                                                    <meta itemprop="price" content="11980">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                39, 40, 41, 42, 43, 44
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22779"
                                     data-ecom="{&quot;id&quot;:22779,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Bugatti 22779&quot;,&quot;price&quot;:8430,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Поло,8150 75092C 340">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22779-8150-75092c-340"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22779-905d218f7d1f-8150-75092c-340-polo-muzhskoye-k-r-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22779-8150-75092c-340"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    8 430 ₽
                                                    <meta itemprop="price" content="8430">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, 4XL, L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22797"
                                     data-ecom="{&quot;id&quot;:22797,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22797&quot;,&quot;price&quot;:3790,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629208 180">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22797-629208-180"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22797-6b91ca7ab078-629208-180-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22797-629208-180"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    3 790 ₽
                                                    <meta itemprop="price" content="3790">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                20-30
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22829"
                                     data-ecom="{&quot;id&quot;:22829,&quot;name&quot;:&quot;\u0421\u043e\u0440\u043e\u0447\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Casa Moda 22829&quot;,&quot;price&quot;:7240,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Casa Moda,Рубашка,954393200 CF 100 кр">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sorochka-muzhskaia-casa-moda-22829-954393200-cf-100-kr"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22829-becaf926ee1d-954393200-cf-100-kr-sorochka-muzhskaya-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sorochka-muzhskaia-casa-moda-22829-954393200-cf-100-kr"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сорочка мужская Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 240 ₽
                                                    <meta itemprop="price" content="7240">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, 4XL, L, M, S, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22782"
                                     data-ecom="{&quot;id&quot;:22782,&quot;name&quot;:&quot;\u0421\u043e\u0440\u043e\u0447\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22782&quot;,&quot;price&quot;:8410,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Рубашка,9550 78900C 10">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sorochka-muzhskaia-bugatti-22782-9550-78900c-10"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22782-a9f5d0a24be1-9550-78900c-10-sorochka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sorochka-muzhskaia-bugatti-22782-9550-78900c-10"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сорочка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    8 410 ₽
                                                    <meta itemprop="price" content="8410">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22798"
                                     data-ecom="{&quot;id&quot;:22798,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22798&quot;,&quot;price&quot;:3790,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629208 410">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22798-629208-410"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22798-dd9f1b2838c1-629208-410-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22798-629208-410"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    3 790 ₽
                                                    <meta itemprop="price" content="3790">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                20-30
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22807"
                                     data-ecom="{&quot;id&quot;:22807,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Roy Robson 22807&quot;,&quot;price&quot;:7510,&quot;brand&quot;:&quot;Roy Robson&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Roy Robson,Поло,090 14804 1229700 14804-90 A450">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-roy-robson-22807-090-14804-1229700-14804-90-a450"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/no/22807-a16feffad502-090-14804-1229700-14804-90-a450-polo-muzhskoye-k-r-roy-robson-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-roy-robson-22807-090-14804-1229700-14804-90-a450"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Roy Robson
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 510 ₽
                                                    <meta itemprop="price" content="7510">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, M, S
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22793"
                                     data-ecom="{&quot;id&quot;:22793,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22793&quot;,&quot;price&quot;:3790,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629229 910">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22793-629229-910"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22793-5f8bc2328bfe-629229-910-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22793-629229-910"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    3 790 ₽
                                                    <meta itemprop="price" content="3790">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                19-29
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22873"
                                     data-ecom="{&quot;id&quot;:22873,&quot;name&quot;:&quot;\u041c\u043e\u043a\u0430\u0441\u0438\u043d\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22873&quot;,&quot;price&quot;:12740,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Barcelo Biagi,Мокасины,2560AQ-0306-D">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/mokasiny-muzhskie-barcelo-biagi-22873-2560aq-0306-d"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22873-23c2726e8b05-2560aq-0306-d-mokasiny-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/mokasiny-muzhskie-barcelo-biagi-22873-2560aq-0306-d"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Мокасины мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    12 740 ₽
                                                    <meta itemprop="price" content="12740">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                46, 47, 48
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22881"
                                     data-ecom="{&quot;id&quot;:22881,&quot;name&quot;:&quot;\u0421\u0430\u0431\u043e \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22881&quot;,&quot;price&quot;:7530,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Barcelo Biagi,Сабо,TK901-9-18">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sabo-muzhskie-barcelo-biagi-22881-tk901-9-18"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22881-6107e6abc3e0-tk901-9-18-sabo-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sabo-muzhskie-barcelo-biagi-22881-tk901-9-18"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сабо мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 530 ₽
                                                    <meta itemprop="price" content="7530">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                40, 41, 42, 43, 44, 45
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22834"
                                     data-ecom="{&quot;id&quot;:22834,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Casa Moda 22834&quot;,&quot;price&quot;:7240,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Поло,954385500 301">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22834-954385500-301"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22834-1a6a19cb1774-954385500-301-polo-muzhskoye-k-r-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22834-954385500-301"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 240 ₽
                                                    <meta itemprop="price" content="7240">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22774"
                                     data-ecom="{&quot;id&quot;:22774,&quot;name&quot;:&quot;\u0414\u0436\u0435\u043c\u043f\u0435\u0440 \u043c\u0443\u0436\u0441\u043a\u043e\u0439 Bugatti 22774&quot;,&quot;price&quot;:11010,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Джемпер,7400 75522C 550">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/dzhemper-muzhskoi-bugatti-22774-7400-75522c-550"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22774-579d4a269123-7400-75522c-550-dzhemper-muzhskoi-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/dzhemper-muzhskoi-bugatti-22774-7400-75522c-550"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Джемпер мужской Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    11 010 ₽
                                                    <meta itemprop="price" content="11010">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22812"
                                     data-ecom="{&quot;id&quot;:22812,&quot;name&quot;:&quot;\u0424\u0443\u0442\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Roy Robson 22812&quot;,&quot;price&quot;:5160,&quot;brand&quot;:&quot;Roy Robson&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Roy Robson,Футболка,090 14805 1229000 14805-90 A104">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/futbolka-muzhskaia-roy-robson-22812-090-14805-1229000-14805-90-a104"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/no/22812-16c318c14993-090-14805-1229000-14805-90-a104-futbolka-muzhskaya-roy-robson-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/futbolka-muzhskaia-roy-robson-22812-090-14805-1229000-14805-90-a104"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Футболка мужская Roy Robson
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    5 160 ₽
                                                    <meta itemprop="price" content="5160">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22818"
                                     data-ecom="{&quot;id&quot;:22818,&quot;name&quot;:&quot;\u0424\u0443\u0442\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22818&quot;,&quot;price&quot;:6610,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Футболка,8350 75043C 10">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/futbolka-muzhskaia-bugatti-22818-8350-75043c-10"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22818-29d5c07e24b2-8350-75043c-10-futbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/futbolka-muzhskaia-bugatti-22818-8350-75043c-10"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Футболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    6 610 ₽
                                                    <meta itemprop="price" content="6610">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22767"
                                     data-ecom="{&quot;id&quot;:22767,&quot;name&quot;:&quot;\u0428\u043e\u0440\u0442\u044b \u043f\u043b\u044f\u0436\u043d\u044b\u0435 \u043c\u0443\u0436\u0441\u043a\u0438\u0435 RAGMAN 22767&quot;,&quot;price&quot;:6210,&quot;brand&quot;:&quot;RAGMAN&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, RAGMAN,Шорты,9206741 903">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/shorty-pliazhnye-muzhskie-ragman-22767-9206741-903"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/na/22767-70f27ce0b3ba-9206741-903-shorty-plyazhnyye-muzhskiye-ragman-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/shorty-pliazhnye-muzhskie-ragman-22767-9206741-903"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Шорты пляжные мужские RAGMAN
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    6 210 ₽
                                                    <meta itemprop="price" content="6210">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22836"
                                     data-ecom="{&quot;id&quot;:22836,&quot;name&quot;:&quot;\u0421\u043e\u0440\u043e\u0447\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Casa Moda 22836&quot;,&quot;price&quot;:7240,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Casa Moda,Рубашка,954395900 100 кр">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sorochka-muzhskaia-casa-moda-22836-954395900-100-kr"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22836-a20feba267e3-954395900-100-kr-sorochka-muzhskaya-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sorochka-muzhskaia-casa-moda-22836-954395900-100-kr"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сорочка мужская Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 240 ₽
                                                    <meta itemprop="price" content="7240">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22757"
                                     data-ecom="{&quot;id&quot;:22757,&quot;name&quot;:&quot;\u0421\u0430\u0431\u043e \u043c\u0443\u0436\u0441\u043a\u0438\u0435 GLAMFOREVER 22757&quot;,&quot;price&quot;:1320,&quot;brand&quot;:&quot;GLAMFOREVER&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, GLAMFOREVER,Сабо,6074-251 BLACK">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sabo-muzhskie-glamforever-22757-6074-251-black"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/r/re/22757-0ff00b3f1c35-6074-251-black-sabo-muzhskiye-glamforever-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sabo-muzhskie-glamforever-22757-6074-251-black"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сабо мужские GLAMFOREVER
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    1 320 ₽
                                                    <meta itemprop="price" content="1320">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                41, 43, 45
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22806"
                                     data-ecom="{&quot;id&quot;:22806,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Roy Robson 22806&quot;,&quot;price&quot;:7510,&quot;brand&quot;:&quot;Roy Robson&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Roy Robson,Поло,090 14804 1229700 14804-90 A104">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-roy-robson-22806-090-14804-1229700-14804-90-a104"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/no/22806-3ebda659eb3c-090-14804-1229700-14804-90-a104-polo-muzhskoye-k-r-roy-robson-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-roy-robson-22806-090-14804-1229700-14804-90-a104"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Roy Robson
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 510 ₽
                                                    <meta itemprop="price" content="7510">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, S, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22833"
                                     data-ecom="{&quot;id&quot;:22833,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Casa Moda 22833&quot;,&quot;price&quot;:7240,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Поло,954385400 607">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22833-954385400-607"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22833-68d57838c071-954385400-607-polo-muzhskoye-k-r-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22833-954385400-607"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 240 ₽
                                                    <meta itemprop="price" content="7240">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22802"
                                     data-ecom="{&quot;id&quot;:22802,&quot;name&quot;:&quot;\u041a\u0443\u0440\u0442\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Roy Robson 22802&quot;,&quot;price&quot;:23390,&quot;brand&quot;:&quot;Roy Robson&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Roy Robson,Куртка,096 14920 1227100 14920-96 A401">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/kurtka-muzhskaia-roy-robson-22802-096-14920-1227100-14920-96-a401"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/no/22802-0791e869ac7c-096-14920-1227100-14920-96-a401-kurtka-muzhskaya-roy-robson-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/kurtka-muzhskaia-roy-robson-22802-096-14920-1227100-14920-96-a401"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Куртка мужская Roy Robson
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    23 390 ₽
                                                    <meta itemprop="price" content="23390">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                L, XL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22841"
                                     data-ecom="{&quot;id&quot;:22841,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Casa Moda 22841&quot;,&quot;price&quot;:7130,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Поло,954383700 336">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22841-954383700-336"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22841-8c8b0b87192a-954383700-336-polo-muzhskoye-k-r-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22841-954383700-336"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 130 ₽
                                                    <meta itemprop="price" content="7130">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, 4XL, L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22787"
                                     data-ecom="{&quot;id&quot;:22787,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22787&quot;,&quot;price&quot;:3790,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629222 360">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22787-629222-360"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22787-f7dfb7008d10-629222-360-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22787-629222-360"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    3 790 ₽
                                                    <meta itemprop="price" content="3790">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                20-27
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22844"
                                     data-ecom="{&quot;id&quot;:22844,&quot;name&quot;:&quot;\u0421\u043e\u0440\u043e\u0447\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Venti 22844&quot;,&quot;price&quot;:9620,&quot;brand&quot;:&quot;Venti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Venti,Рубашка,123963800 800">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sorochka-muzhskaia-venti-22844-123963800-800"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22844-7fed8758a72d-123963800-800-sorochka-muzhskaya-venti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sorochka-muzhskaia-venti-22844-123963800-800"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сорочка мужская Venti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    9 620 ₽
                                                    <meta itemprop="price" content="9620">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                41, 42, 43, 44, 45
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22825"
                                     data-ecom="{&quot;id&quot;:22825,&quot;name&quot;:&quot;\u041f\u0438\u0434\u0436\u0430\u043a \u043c\u0443\u0436\u0441\u043a\u043e\u0439 Venti 22825&quot;,&quot;price&quot;:19840,&quot;brand&quot;:&quot;Venti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Venti,Пиджак,554378300 105">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/pidzhak-muzhskoi-venti-22825-554378300-105"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22825-a58dc2f9fa02-554378300-105-pidzhak-muzhskoi-venti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/pidzhak-muzhskoi-venti-22825-554378300-105"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Пиджак мужской Venti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    19 840 ₽
                                                    <meta itemprop="price" content="19840">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                50, 52, 54, 56
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22785"
                                     data-ecom="{&quot;id&quot;:22785,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22785&quot;,&quot;price&quot;:4660,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629212 010">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22785-629212-010"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22785-66ec59637067-629212-010-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22785-629212-010"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    4 660 ₽
                                                    <meta itemprop="price" content="4660">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                17-26
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22768"
                                     data-ecom="{&quot;id&quot;:22768,&quot;name&quot;:&quot;\u0424\u0443\u0442\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f RAGMAN 22768&quot;,&quot;price&quot;:6210,&quot;brand&quot;:&quot;RAGMAN&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, RAGMAN,Футболка,3205580 298">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/futbolka-muzhskaia-ragman-22768-3205580-298"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/na/22768-f3febe37494e-3205580-298-futbolka-muzhskaya-ragman-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/futbolka-muzhskaia-ragman-22768-3205580-298"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Футболка мужская RAGMAN
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    6 210 ₽
                                                    <meta itemprop="price" content="6210">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22821"
                                     data-ecom="{&quot;id&quot;:22821,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Bugatti 22821&quot;,&quot;price&quot;:9340,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Поло,8150 75103C 340">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22821-8150-75103c-340"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22821-28da149c361a-8150-75103c-340-polo-muzhskoye-k-r-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22821-8150-75103c-340"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    9 340 ₽
                                                    <meta itemprop="price" content="9340">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, XL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22741"
                                     data-ecom="{&quot;id&quot;:22741,&quot;name&quot;:&quot;\u041c\u043e\u043a\u0430\u0441\u0438\u043d\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 BADEN TREND 22741&quot;,&quot;price&quot;:5110,&quot;brand&quot;:&quot;Baden&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Baden,Мокасины,WL201-012">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/mokasiny-muzhskie-baden-trend-22741-wl201-012"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/d/dn/22741-41171ece00f8-wl201-012-mokasiny-muzhskiye-baden-trend-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/mokasiny-muzhskie-baden-trend-22741-wl201-012"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Мокасины мужские BADEN TREND
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    5 110 ₽
                                                    <meta itemprop="price" content="5110">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                40, 41, 42, 43, 44
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22848"
                                     data-ecom="{&quot;id&quot;:22848,&quot;name&quot;:&quot;\u0428\u043e\u0440\u0442\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Casa Moda 22848&quot;,&quot;price&quot;:6410,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Шорты,554388700 338">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/shorty-muzhskie-casa-moda-22848-554388700-338"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22848-148175035ce5-554388700-338-shorty-muzhskiye-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/shorty-muzhskie-casa-moda-22848-554388700-338"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Шорты мужские Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    6 410 ₽
                                                    <meta itemprop="price" content="6410">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                32, 34, 36, 38
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22784"
                                     data-ecom="{&quot;id&quot;:22784,&quot;name&quot;:&quot;\u0428\u043e\u0440\u0442\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Bugatti 22784&quot;,&quot;price&quot;:7790,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Шорты,4409GD 76404C 30">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/shorty-muzhskie-bugatti-22784-4409gd-76404c-30"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22784-4511830f4191-4409gd-76404c-30-shorty-muzhskiye-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/shorty-muzhskie-bugatti-22784-4409gd-76404c-30"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Шорты мужские Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 790 ₽
                                                    <meta itemprop="price" content="7790">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                48, 50, 52, 54, 56
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22864"
                                     data-ecom="{&quot;id&quot;:22864,&quot;name&quot;:&quot;\u0421\u0430\u043d\u0434\u0430\u043b\u0435\u0442\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Rieker 22864&quot;,&quot;price&quot;:7960,&quot;brand&quot;:&quot;Rieker&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Rieker,Сандалии,29151-00">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sandalety-muzhskie-rieker-22864-29151-00"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/r/re/22864-037d24b381dd-sandalety-muzhskiye-rieker-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sandalety-muzhskie-rieker-22864-29151-00"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сандалеты мужские Rieker
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 960 ₽
                                                    <meta itemprop="price" content="7960">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                41, 42, 44, 45, 46, 47
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22775"
                                     data-ecom="{&quot;id&quot;:22775,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Bugatti 22775&quot;,&quot;price&quot;:8660,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Поло,8151 75100C 390">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22775-8151-75100c-390"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22775-e3c947a61db0-8151-75100c-390-polo-muzhskoye-k-r-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-bugatti-22775-8151-75100c-390"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    8 660 ₽
                                                    <meta itemprop="price" content="8660">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22819"
                                     data-ecom="{&quot;id&quot;:22819,&quot;name&quot;:&quot;\u0424\u0443\u0442\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22819&quot;,&quot;price&quot;:6610,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Футболка,8350 75044C 10">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/futbolka-muzhskaia-bugatti-22819-8350-75044c-10"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22819-f0ac15ef8c51-8350-75044c-10-futbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/futbolka-muzhskaia-bugatti-22819-8350-75044c-10"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Футболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    6 610 ₽
                                                    <meta itemprop="price" content="6610">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, 4XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22882"
                                     data-ecom="{&quot;id&quot;:22882,&quot;name&quot;:&quot;\u0421\u043b\u0438\u043f\u043e\u043d\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22882&quot;,&quot;price&quot;:12740,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Barcelo Biagi,Слипоны,MC278AB-5A">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/slipony-muzhskie-barcelo-biagi-22882-mc278ab-5a"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22882-83a81ed5629b-mc278ab-5a-slipony-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/slipony-muzhskie-barcelo-biagi-22882-mc278ab-5a"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Слипоны мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    12 740 ₽
                                                    <meta itemprop="price" content="12740">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                40, 41, 43, 44, 45
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22875"
                                     data-ecom="{&quot;id&quot;:22875,&quot;name&quot;:&quot;\u041c\u043e\u043a\u0430\u0441\u0438\u043d\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22875&quot;,&quot;price&quot;:11980,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Barcelo Biagi,Мокасины,78590B-1-961-BNP-L">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/mokasiny-muzhskie-barcelo-biagi-22875-78590b-1-961-bnp-l"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22875-cc526a75a3c5-78590b-1-961-bnp-l-mokasiny-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/mokasiny-muzhskie-barcelo-biagi-22875-78590b-1-961-bnp-l"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Мокасины мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    11 980 ₽
                                                    <meta itemprop="price" content="11980">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                46, 47, 48
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22878"
                                     data-ecom="{&quot;id&quot;:22878,&quot;name&quot;:&quot;\u0422\u0443\u0444\u043b\u0438 \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22878&quot;,&quot;price&quot;:12740,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Barcelo Biagi,Туфли,5240A-946A-ZNP">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/tufli-muzhskie-barcelo-biagi-22878-5240a-946a-znp"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22878-8214799fa46d-5240a-946a-znp-tufli-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/tufli-muzhskie-barcelo-biagi-22878-5240a-946a-znp"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Туфли мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    12 740 ₽
                                                    <meta itemprop="price" content="12740">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                40, 41, 44, 45
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22874"
                                     data-ecom="{&quot;id&quot;:22874,&quot;name&quot;:&quot;\u041c\u043e\u043a\u0430\u0441\u0438\u043d\u044b \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Barcelo Biagi 22874&quot;,&quot;price&quot;:12740,&quot;brand&quot;:&quot;Barcelo Biagi&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Barcelo Biagi,Мокасины,2560AKN-1006-D">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/mokasiny-muzhskie-barcelo-biagi-22874-2560akn-1006-d"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/ig/22874-ec1a4b8a747e-2560akn-1006-d-mokasiny-muzhskiye-barcelo-biagi-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/mokasiny-muzhskie-barcelo-biagi-22874-2560akn-1006-d"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Мокасины мужские Barcelo Biagi
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    12 740 ₽
                                                    <meta itemprop="price" content="12740">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                46, 47, 48
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22766"
                                     data-ecom="{&quot;id&quot;:22766,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 RAGMAN 22766&quot;,&quot;price&quot;:7380,&quot;brand&quot;:&quot;RAGMAN&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, RAGMAN,Поло,3409791 835">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-ragman-22766-3409791-835"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/na/22766-1a61022911cd-3409791-835-polo-muzhskoye-k-r-ragman-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-ragman-22766-3409791-835"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р RAGMAN
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 380 ₽
                                                    <meta itemprop="price" content="7380">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, L, M, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22795"
                                     data-ecom="{&quot;id&quot;:22795,&quot;name&quot;:&quot;\u0411\u0435\u0439\u0441\u0431\u043e\u043b\u043a\u0430 \u043c\u0443\u0436\u0441\u043a\u0430\u044f Bugatti 22795&quot;,&quot;price&quot;:4660,&quot;brand&quot;:&quot;Bugatti&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Bugatti,Бейсболка,629233 580">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22795-629233-580"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/i/it/22795-baf96d33c0fe-629233-580-beisbolka-muzhskaya-bugatti-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/beisbolka-muzhskaia-bugatti-22795-629233-580"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Бейсболка мужская Bugatti
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    4 660 ₽
                                                    <meta itemprop="price" content="4660">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                20-27
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22840"
                                     data-ecom="{&quot;id&quot;:22840,&quot;name&quot;:&quot;\u041f\u043e\u043b\u043e \u043c\u0443\u0436\u0441\u043a\u043e\u0435 \u043a\/\u0440 Casa Moda 22840&quot;,&quot;price&quot;:7130,&quot;brand&quot;:&quot;Casa Moda&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, Casa Moda,Поло,954383700 105">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22840-954383700-105"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/a/ad/22840-0ac3afe48a19-954383700-105-polo-muzhskoye-k-r-casa-moda-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/polo-muzhskoe-k-r-casa-moda-22840-954383700-105"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Поло мужское к/р Casa Moda
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    7 130 ₽
                                                    <meta itemprop="price" content="7130">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                3XL, 4XL, L, XL, XXL
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22755"
                                     data-ecom="{&quot;id&quot;:22755,&quot;name&quot;:&quot;\u0421\u0430\u0431\u043e \u043c\u0443\u0436\u0441\u043a\u0438\u0435 GLAMFOREVER 22755&quot;,&quot;price&quot;:1520,&quot;brand&quot;:&quot;GLAMFOREVER&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0431\u0443\u0432\u044c&quot;} ">
                                    <meta itemprop="description" content="дом, обуви, GLAMFOREVER,Сабо,6075-251 BLACK">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/sabo-muzhskie-glamforever-22755-6075-251-black"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/r/re/22755-3ae21f680ee2-6075-251-black-sabo-muzhskiye-glamforever-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/sabo-muzhskie-glamforever-22755-6075-251-black"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Сабо мужские GLAMFOREVER
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    1 520 ₽
                                                    <meta itemprop="price" content="1520">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                41, 42, 43, 44, 45
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-filter-card" itemscope="" itemtype="https://schema.org/Product"
                                     data-id="22815"
                                     data-ecom="{&quot;id&quot;:22815,&quot;name&quot;:&quot;\u0411\u0440\u044e\u043a\u0438 \u043c\u0443\u0436\u0441\u043a\u0438\u0435 Roy Robson 22815&quot;,&quot;price&quot;:12480,&quot;brand&quot;:&quot;Roy Robson&quot;,&quot;category&quot;:&quot;\u041c\u0443\u0436\u0447\u0438\u043d\u0430\u043c\/\u041e\u0434\u0435\u0436\u0434\u0430&quot;} ">
                                    <meta itemprop="description"
                                          content="дом, обуви, Roy Robson,Брюки,051 14360 1158100 951-51 A410">
                                    <div class="product-card-type news-product">
                                        <span>New</span>
                                    </div>
                                    <div class="product-card-main">
                                        <div class="product-card-content">
                                            <a href="/detail/briuki-muzhskie-roy-robson-22815-051-14360-1158100-951-51-a410"
                                               class="product-img-main" itemprop="url">
                                                <img itemprop="image"
                                                     src="https://dom-obuv.ru/uploads/products/thumbs/n/no/22815-39ab00e3975d-051-14360-1158100-951-51-a410-bryuki-muzhskiye-roy-robson-265x398.jpg"
                                                     alt="" title="">
                                            </a>
                                            <a href="/detail/briuki-muzhskie-roy-robson-22815-051-14360-1158100-951-51-a410"
                                               class="product-review-main stretched-link" itemprop="url">
                                                <div class="product-name" itemprop="name">
                                                    Брюки мужские Roy Robson
                                                </div>
                                                <div class="product-price" itemprop="offers" itemscope=""
                                                     itemtype="https://schema.org/Offer">
                                                    12 480 ₽
                                                    <meta itemprop="price" content="12480">
                                                    <meta itemprop="priceCurrency" content="RUB">
                                                    <link itemprop="availability" href="https://schema.org/InStock">
                                                </div>
                                            </a>
                                            <div class="card-size-content-card">
                                                Размеры:
                                                50
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <nav aria-label="Page navigation" style="margin-top: 20px">
                                <ul class="pagination pagination-card-body">


                                    <li class="page-item active">
                                        <a class="page-link" data-page="1" href="/catalog/muzhchinam?pn=1">1</a>
                                    </li>

                                    <li class="page-item">
                                        <a class="page-link" data-page="2" href="/catalog/muzhchinam?pn=2">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" data-page="3" href="/catalog/muzhchinam?pn=3">3</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" data-page="4" href="/catalog/muzhchinam?pn=4">4</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" data-page="5" href="/catalog/muzhchinam?pn=5">5</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" data-page="6" href="/catalog/muzhchinam?pn=6">6</a>
                                    </li>

                                    <li class="page-item">
                                        <a class="page-link" data-page="2" href="/catalog/muzhchinam?pn=2"
                                           aria-label="Next" rel="next">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9 18L15 12L9 6" stroke="#3B3B3B" stroke-width="2"
                                                      stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </li>

                                </ul>
                            </nav>
                        </div>

                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="footer-body">
        <div class="container">
            <div class="main-footer-content">
                <div class="contacts-footer-content">
                    <a href="/" class="logo-footer">
                        <img src="https://dom-obuv.ru/uploads/block/source/p/pi/23-6cd307a6d507-podval-logotip.png"
                             alt="" title="">
                    </a>
                    <div class="contacts-footer">
                        <div class="first-footer-block">
                            <div itemscope="" itemtype="http://schema.org/ShoeStore">
                                <a href="#" class="del-called" data-bs-toggle="modal" data-bs-dismiss="modal"
                                   data-bs-target="#order-call">Заказать звонок</a>
                                <a href="tel:+7(495) 529-37-33" class="phone-footer" itemprop="telephone">+7(495)
                                    529-37-33</a>
                                <a href="tel:8(800) 250-29-29" class="phone-footer" itemprop="telephone">8(800)
                                    250-29-29</a>
                                <div class="days-work" itemprop="openingHours"
                                     datetime="Mo, Tu, We, Th, Fr 10:00−21:00">Пн.-пт. 10:00 - 19:00
                                </div>
                            </div>
                        </div>
                        <div class="second-footer-block">
                            <a href="https://vk.com/dom.obuvi" class="we-in-vk" target="_blank">
                                <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_180_2887)">
                                        <path
                                            d="M13.07 0H6.93063C1.32813 0 0 1.32812 0 6.93062V13.07C0 18.6725 1.32813 20.0006 6.93063 20.0006H13.07C18.6725 20.0006 20.0006 18.6725 20.0006 13.07V6.93062C20.0006 1.32812 18.6594 0 13.07 0ZM16.1462 14.2675H14.6944C14.1444 14.2675 13.975 13.8312 12.9856 12.8287C12.1262 11.9956 11.7456 11.885 11.5337 11.885C11.2344 11.885 11.1494 11.9694 11.1494 12.38V13.6919C11.1494 14.0437 11.0387 14.255 10.1075 14.255C8.5675 14.255 6.85875 13.3237 5.66062 11.5887C3.85375 9.04625 3.35938 7.14187 3.35938 6.74813C3.35938 6.53625 3.44375 6.33812 3.85062 6.33812H5.30562C5.67375 6.33812 5.81375 6.5075 5.95687 6.90125C6.67625 8.97812 7.87438 10.7975 8.36875 10.7975C8.55125 10.7975 8.63562 10.7131 8.63562 10.2475V8.1025C8.58 7.11312 8.05938 7.02812 8.05938 6.67687C8.05938 6.5075 8.19938 6.33812 8.42375 6.33812H10.7119C11.0212 6.33812 11.135 6.5075 11.135 6.87187V9.76562C11.135 10.0781 11.275 10.1888 11.3594 10.1888C11.5419 10.1888 11.6981 10.0781 12.0362 9.73938C13.0812 8.5675 13.83 6.76063 13.83 6.76063C13.9275 6.54875 14.0969 6.35063 14.465 6.35063H15.92C16.3563 6.35063 16.4538 6.575 16.3563 6.8875C16.1737 7.73375 14.3931 10.2469 14.3931 10.2469C14.24 10.5006 14.1812 10.6112 14.3931 10.8944C14.5494 11.1062 15.0575 11.5456 15.3956 11.9394C16.0175 12.6456 16.4956 13.2381 16.6231 13.6481C16.7663 14.055 16.555 14.2669 16.1444 14.2669L16.1462 14.2675Z"
                                            fill="white"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_180_2887">
                                            <rect width="20" height="20" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                                Мы Вконтакте
                            </a>
                            <div itemscope="" itemtype="http://schema.org/ShoeStore">
                                <a href="mailto:info@dom-obuv.ru" class="phone-footer"
                                   itemprop="email">info@dom-obuv.ru</a>
                                <div class="phone-footer">г. <span itemprop="addressLocality">Балашиха</span>, <span
                                        itemprop="streetAddress">ш. Энтузиастов 60</span></div>
                                <div class="days-work">
                                    <time itemprop="openingHours" datetime="Mo, Tu, We, Th, Fr 10:00−21:00">Пн-сб: 10 –
                                        21
                                    </time>
                                    ,
                                    <time itemprop="openingHours" datetime="Sa, Su 10:00−20:00"> вс: 10 – 20</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="catalog-content">
                    <a href="/" class="name-category-block">Каталог</a>
                    <a href="/catalog/zhenshchinam" class="catalog-footer">Женщинам</a>
                    <a href="/catalog/muzhchinam" class="catalog-footer">Мужчинам</a>
                    <a href="/catalog/detyam" class="catalog-footer">Детям</a>
                </div>
                <div class="catalog-content">
                    <a href="/about" class="name-category-block">О нас</a>
                    <a href="/news/" class="catalog-footer">Новости</a>
                    <a href="/contacts" class="catalog-footer">Контакты</a>
                </div>
                <div class="catalog-content">
                    <a href="/contacts" class="name-category-block">Покупателям</a>
                    <a href="/help/delivery" class="catalog-footer">Условия доставки</a>
                    <a href="/help/order" class="catalog-footer">Оформление заказа</a>
                    <a href="/help/payback" class="catalog-footer">Условия возврата</a>
                    <a href="/help/oferta" class="catalog-footer">Публичная оферта</a>
                </div>
            </div>
            <div class="second-footer-content">
                <div>Дом Обуви © 2024</div>
            </div>
        </div>
    </footer>
    <div class="modal fade" id="order-call" tabindex="-1" aria-labelledby="order-callLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-log-in">
            <div class="modal-content modal-content-main">
                <svg data-bs-dismiss="modal" aria-label="Close" class="modal-close-block" viewBox="0 0 24 24"
                     fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 16L12 12M12 12L8 8M12 12L16 8M12 12L8 16" stroke="#3B3B3B" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                </svg>
                <div class="modal-body">
                    <div class="modal-body-content"></div>
                </div>
            </div>
        </div>
    </div>
@endif



{{--<script>--}}
{{--    const block = document.getElementById('block_menu');--}}
{{--    const inner = document.getElementById('block_menu2');--}}

{{--    function updateTopValue() {--}}
{{--        const blockHeight = block.offsetHeight;--}}
{{--        const viewportHeight = window.innerHeight;--}}

{{--        const diff = blockHeight - viewportHeight;--}}
{{--        const topValue = diff > 0 ? -diff : 0;--}}

{{--        inner.style.top = topValue + 'px';--}}

{{--        console.log(`Высота блока: ${blockHeight}px, Высота экрана: ${viewportHeight}px, top: ${topValue}px`);--}}
{{--    }--}}

{{--    // Пересчитать при загрузке страницы--}}
{{--    window.addEventListener('load', updateTopValue);--}}
{{--    // При изменении размера окна--}}
{{--    window.addEventListener('resize', updateTopValue);--}}

{{--    // Отслеживаем изменение размера блока с помощью ResizeObserver--}}
{{--    if (window.ResizeObserver) {--}}
{{--        const resizeObserver = new ResizeObserver(() => {--}}
{{--            updateTopValue();--}}
{{--        });--}}
{{--        resizeObserver.observe(block);--}}
{{--    }--}}
{{--</script>--}}

</body>


<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Отступ от нижней границы экрана
        const offsetBottom = 30;
        const block = document.querySelector('.catalog-product-main'); // ищем по классу

        if (!block) {
            console.log('Блок с классом .catalog-product-main не найден');
        } else {

            function updateTopValue() {
                const blockHeight = block.offsetHeight;
                const viewportHeight = window.innerHeight;
                const diff = blockHeight - viewportHeight;
                const topValue = diff > 0 ? -(diff + offsetBottom) : 0;
                block.style.top = `${topValue}px`;
                //console.log(`Высота блока: ${blockHeight}px, Высота окна: ${viewportHeight}px, Установка top: ${topValue}px`);
            }

            window.addEventListener('load', updateTopValue);
            window.addEventListener('resize', updateTopValue);

            if ('ResizeObserver' in window) {
                const resizeObserver = new ResizeObserver(updateTopValue);
                resizeObserver.observe(block);
            } else {
                console.warn('ResizeObserver не поддерживается в вашем браузере');
            }
        }
    });
</script>


</html>
