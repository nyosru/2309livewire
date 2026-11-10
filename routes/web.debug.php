<?php

/*
|--------------------------------------------------------------------------
| Debug routes — domains inventory
|--------------------------------------------------------------------------
|
| Registers /debug/domains only when APP_DEBUG=true.
| When debug is off the route simply does not exist, so the page is
| available *only* if debug = true.
|
*/

if (config('app.debug')) {
    Route::get('/debug/domains', function () {
        $categories = [
            /* ---------- Вкусняки (vkusno) ---------- */
            'vkusno' => [
                'label' => 'Вкусняки (vkusno)',
                'items' => [
                    ['value' => 'vkusno.local',        'env' => 'local', 'file' => 'routes/web.vkusno.php', 'note' => 'локальный'],
                    ['value' => 'xn--72-dlcqkkbw9at8k.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.vkusno.php', 'note' => 'продакшн (punycode, "vkusno72")'],
                    ['value' => 'xn--72-dlcyjau5ar6c5d.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.vkusno.php', 'note' => 'простой IDN → 301-редирект на xn--72-dlcqkkbw9at8k.xn--p1ai'],
                ],
            ],

            /* ---------- Цеп-кафа (cfa) ---------- */
            'cfa' => [
                'label' => 'Cfa (кафе)',
                'items' => [
                    ['value' => 'cfa.local',              'env' => 'local', 'file' => 'routes/web.cfa.php', 'note' => 'локальный'],
                    ['value' => 'cfa-center.ru',          'env' => 'prod', 'file' => 'routes/web.cfa.php', 'note' => 'продакшн'],
                    ['value' => 'cfa.php-cat.com',        'env' => 'prod', 'file' => 'routes/web.cfa.php', 'note' => 'CFA2 (админка)'],
                ],
            ],

            /* ---------- Cals ---------- */
            'cals' => [
                'label' => 'Cals (звонки)',
                'items' => [
                    ['value' => 'cals.local', 'env' => 'local', 'file' => 'routes/web.cals.php', 'note' => 'локальный'],
                ],
            ],

            /* ---------- Hleb ---------- */
            'hleb' => [
                'label' => 'Hleb (хлебная)',
                'items' => [
                    ['value' => 'hleb.local',          'env' => 'local', 'file' => 'routes/web.hleb.php', 'note' => 'локальный'],
                    ['value' => 'xn--80ablnmob2dxa6f.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.hleb.php', 'note' => 'продакшн (punycode)'],
                    ['value' => 'хлебничная.рф',        'env' => 'prod', 'file' => 'routes/web.hleb.php', 'note' => 'продакшн (IDN)'],
                ],
            ],

            /* ---------- Dzudo ---------- */
            'dzudo' => [
                'label' => 'Dzudo (дзюдо)',
                'items' => [
                    ['value' => 'dzudo.local',            'env' => 'local', 'file' => 'routes/web.dzudo.php', 'note' => 'локальный'],
                    ['value' => 'ЦентрДзюдо.рф',          'env' => 'prod', 'file' => 'routes/web.dzudo.php', 'note' => 'продакшн (IDN)'],
                    ['value' => 'xn--d1aabj2ajkp7a5f.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.dzudo.php', 'note' => 'продакшн (punycode)'],
                ],
            ],

            /* ---------- Concept mebel ---------- */
            'mebel' => [
                'label' => 'Концепт мебель',
                'items' => [
                    ['value' => 'mebel.local',              'env' => 'local', 'file' => 'routes/web.concept-mebel.php', 'note' => 'локальный'],
                    ['value' => 'xn--90ahabvkdgim7a8b8e.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.concept-mebel.php', 'note' => 'продакшн (punycode, концепт мебель.рф)'],
                ],
            ],

            /* ---------- Krostu ---------- */
            'krostu' => [
                'label' => 'Krostu',
                'items' => [
                    ['value' => 'krostu.local', 'env' => 'local', 'file' => 'routes/web.krostu.php', 'note' => 'локальный'],
                    ['value' => 'krostu.com',   'env' => 'prod', 'file' => 'routes/web.krostu.php', 'note' => 'продакшн'],
                    ['value' => 'xn--j1aifffg.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.krostu.php', 'note' => 'продакшн (punycode, кросту.рф)'],
                ],
            ],

            /* ---------- Catcom ---------- */
            'catcom' => [
                'label' => 'Katkom (катком)',
                'items' => [
                    ['value' => 'catcom.local',     'env' => 'local', 'file' => 'routes/web.catcom.php', 'note' => 'локальный'],
                    ['value' => 'xn--80atbijw.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.catcom.php', 'note' => 'продакшн (punycode, катком.рф)'],
                ],
            ],

            /* ---------- PHP CAT (phpcat) ---------- */
            'phpcat' => [
                'label' => 'PHP CAT (основной сайт)',
                'items' => [
                    ['value' => 'phpcat.local',      'env' => 'local', 'file' => 'routes/web.phpcat.php', 'note' => 'локальный'],
                    ['value' => 'php-cat.com',       'env' => 'prod', 'file' => 'routes/web.phpcat.php', 'note' => 'продакшн'],
                    ['value' => 'seotel.ru',         'env' => 'prod', 'file' => 'routes/web.phpcat.php', 'note' => 'продакшн (alias)'],
                    ['value' => '1.php-cat.local',   'env' => 'local', 'file' => 'routes/web.phpcat.php', 'note' => 'локальный'],
                    ['value' => '1.php-cat.com',     'env' => 'prod', 'file' => 'routes/web.phpcat.php', 'note' => 'продакшн'],
                ],
            ],

            /* ---------- PHP CAT ru ---------- */
            'phpcatru' => [
                'label' => 'PHP CAT ru (русская версия)',
                'items' => [
                    ['value' => 'phpcatru.local', 'env' => 'local', 'file' => 'routes/web.phpcat_ru.php', 'note' => 'локальный'],
                    ['value' => 'php-cat.ru',     'env' => 'prod', 'file' => 'routes/web.phpcat_ru.php', 'note' => 'продакшн'],
                ],
            ],

            /* ---------- Mannik ---------- */
            'mannik' => [
                'label' => 'Mannik',
                'items' => [
                    ['value' => 'mannik.local',       'env' => 'local', 'file' => 'routes/web.mannik.php', 'note' => 'локальный'],
                    ['value' => 'xn--80aayihhat9j.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.mannik.php', 'note' => 'продакшн (punycode, юраманник.рф)'],
                ],
            ],

            /* ---------- TTT ---------- */
            'ttt' => [
                'label' => 'TTT',
                'items' => [
                    ['value' => 'ttt.local',     'env' => 'local', 'file' => 'routes/web.ttt.php', 'note' => 'локальный (или 127.0.0.1 / localhost)'],
                    ['value' => 'ttt72.ru',      'env' => 'prod', 'file' => 'routes/web.ttt.php', 'note' => 'продакшн (по умолчанию при не-local хосте)'],
                    ['value' => 'xn--72-qmcaa.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.ttt.php', 'note' => 'продакшн (punycode, ттт72.рф)'],
                ],
            ],

            /* ---------- Afisha ---------- */
            'afisha' => [
                'label' => 'Afisha (тюмень)',
                'items' => [
                    ['value' => 'afisha.local',       'env' => 'local', 'file' => 'routes/web.afisha.php', 'note' => 'локальный'],
                    ['value' => 'xn--80aaarrjmj0bg3a3c0dua.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.afisha.php', 'note' => 'продакшн (punycode, тюменскаяафиша.рф)'],
                ],
            ],

            /* ---------- Uprav / управлятор ---------- */
            'uprav' => [
                'label' => 'Uprav / управлятор.рф',
                'items' => [
                    ['value' => 'uprav1.local',                          'env' => 'local', 'file' => 'routes/web.uprav.php', 'note' => 'локальный'],
                    ['value' => 'xn--80ae1ambgeod9j.xn--p1ai',           'env' => 'prod', 'file' => 'routes/web.uprav.php', 'note' => 'продакшн (punycode, управлятор.рф)'],
                    ['value' => 'commutator.local',                      'env' => 'local', 'file' => 'routes/web.uprav.php', 'note' => 'локальный (Commutator/коммутатор)'],
                    ['value' => 'xn--80atgaidonbh.xn--80ae1ambgeod9j.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.uprav.php', 'note' => 'продакшн (punycode, коммутатор.управлятор.рф)'],
                ],
            ],

            /* ---------- VK files.php-cat ---------- */
            'vkfiles' => [
                'label' => 'VK files.php-cat',
                'items' => [
                    ['value' => 'vk.files.php-cat.local', 'env' => 'local', 'file' => 'routes/web.phpcat.files.php', 'note' => 'локальный'],
                    ['value' => 'vk.files.php-cat.com',  'env' => 'prod', 'file' => 'routes/web.phpcat.files.php', 'note' => 'продакшн'],
                ],
            ],

            /* ---------- AR ---------- */
            'ar' => [
                'label' => 'AR (ar.php-cat)',
                'items' => [
                    ['value' => 'ar.php-cat.local', 'env' => 'local', 'file' => 'routes/web.ar.php', 'note' => 'локальный'],
                    ['value' => 'ar.php-cat.com',  'env' => 'prod', 'file' => 'routes/web.ar.php', 'note' => 'продакшн'],
                ],
            ],

            /* ---------- Timer (сергейсб) ---------- */
            'timer' => [
                'label' => 'Timer (таймер.сергейсб.рф)',
                'items' => [
                    ['value' => 'timer.local',          'env' => 'local', 'file' => 'routes/web.timer.php', 'note' => 'локальный'],
                    ['value' => 'xn--80aklmvh.xn--90adfbu3bff.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.timer.php', 'note' => 'продакшн (punycode, таймер.сергейсб.рф)'],
                ],
            ],

            /* ---------- Skidki (сергейсб) ---------- */
            'skidki' => [
                'label' => 'Skidki (скидки.сергейсб.рф)',
                'items' => [
                    ['value' => 'skidki.local',                                  'env' => 'local', 'file' => 'routes/web.skidki.php', 'note' => 'локальный'],
                    ['value' => 'xn--d1ahbfc2b.xn--90adfbu3bff.xn--p1ai',      'env' => 'prod', 'file' => 'routes/web.skidki.php', 'note' => 'продакшн (punycode, скидки.сергейсб.рф)'],
                ],
            ],

            /* ---------- STN / news-storage ---------- */
            'stn' => [
                'label' => 'STN / news-storage',
                'items' => [
                    ['value' => 'stn.local',                   'env' => 'local', 'file' => 'routes/web.stn.php', 'note' => 'локальный'],
                    ['value' => 'stn.dev.php-cat.com',         'env' => 'prod', 'file' => 'routes/web.stn.php', 'note' => 'продакшн (dev, закомментировано в web.stn.php)'],
                    ['value' => 'news.local',                  'env' => 'local', 'file' => 'routes/web.stn.php', 'note' => 'локальный (основной news.local)'],
                    ['value' => 'stn.news',                    'env' => 'local', 'file' => 'routes/web.news_storage.php', 'note' => 'alias / news-storage'],
                    ['value' => 'news.api.php-cat.ru',         'env' => 'prod', 'file' => 'routes/web.news_storage.php', 'note' => 'продакшн (api)'],
                    ['value' => 'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.stn.php', 'note' => 'продакшн (punycode, самыеюменскиеновости.рф)'],
                ],
            ],

            /* ---------- Raal ---------- */
            'raal' => [
                'label' => 'Raal (РААЛ)',
                'items' => [
                    ['value' => 'raal.local',      'env' => 'local', 'file' => 'routes/web.raal.php', 'note' => 'локальный'],
                    ['value' => 'xn--80aa7ar.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.raal.php', 'note' => 'продакшн (punycode, продажаавтоаккумуляторов.рф)'],
                ],
            ],

            /* ---------- Marudi ---------- */
            'marudi' => [
                'label' => 'Marudi',
                'items' => [
                    ['value' => 'marudi.local',      'env' => 'local', 'file' => 'routes/web.marudi.php', 'note' => 'локальный'],
                    ['value' => 'xn--80aimnvs.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.marudi.php', 'note' => 'продакшн (punycode)'],
                ],
            ],

            /* ---------- Gerchik ---------- */
            'gerchik' => [
                'label' => 'Gerbchik / гербчик',
                'items' => [
                    ['value' => 'gerchick.local', 'env' => 'local', 'file' => 'routes/web.gerchik.php', 'note' => 'локальный (вариант 1)'],
                    ['value' => 'gerchik.local',  'env' => 'local', 'file' => 'routes/web.gerchik.php', 'note' => 'локальный (вариант 2)'],
                    ['value' => 'xn--c1aeji2a6b.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.gerchik.php', 'note' => 'продакшн (punycode)'],
                ],
            ],

            /* ---------- Domainwaiter ---------- */
            'domainwaiter' => [
                'label' => 'Domainwaiter',
                'items' => [
                    ['value' => 'domainwaiter.lw',      'env' => 'local', 'file' => 'routes/web.domainwaiter.php', 'note' => 'локальный'],
                    ['value' => 'domainwaiter.com',     'env' => 'prod', 'file' => 'routes/web.domainwaiter.php', 'note' => 'продакшн'],
                ],
            ],

            /* ---------- Snowkait ---------- */
            'snowkait' => [
                'label' => 'Snowkait (снoукайтинг)',
                'items' => [
                    ['value' => 'snow.local',  'env' => 'local', 'file' => 'routes/web.php', 'note' => 'локальный'],
                    ['value' => 'xn--80agoddredzph.xn--p1ai', 'env' => 'prod', 'file' => 'routes/web.php', 'note' => 'продакшн (punycode, snowkait.product_punycode)'],
                    ['value' => 'сноукайтинг.рф', 'env' => 'prod', 'file' => 'routes/web.php', 'note' => 'продакшн (IDN, snowkait.product_idn)'],
                ],
            ],
        ];

        $config = [
            'app.debug' => config('app.debug'),
            'app.env'   => config('app.env'),
            'app.url'   => config('app.url'),
            'app.name'  => config('app.name'),
        ];

        return view('debug.domains', compact('categories', 'config'));
    })->name('debug.domains');
}
