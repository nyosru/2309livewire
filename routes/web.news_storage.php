<?php

use App\Livewire\NewsStorage;
use App\Livewire\StNews\Show as StNewsShow;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::view('/', 'livewire.news-storage.feed')->name('index');
    Route::get('/manage', NewsStorage\Index::class)->name('manage');
    Route::get('/api-docs', NewsStorage\ApiDocs::class)->name('api-docs');
    Route::get('/news/{id}', NewsStorage\Show::class)->name('show');
    Route::get('/articles/{id}', StNewsShow::class)->whereNumber('id')->name('stn-show');
    Route::get('/storage-news/{id}', NewsStorage\Show::class)->whereNumber('id')->name('feed-storage-show');

    Route::fallback(function () {
        return redirect('/');
    });
};

// news.local — локальный адрес, остальные — публичные адреса той же ленты.
// IDN указывается в punycode: именно так домен приходит в HTTP Host.
foreach ([
    'news.local',
    'stn.news',
    'news.api.php-cat.ru',
    'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai', // самыетюменскиеновости.рф
] as $index => $domain) {
    Route::group([
        // Сохраняем существующие имена маршрутов для основного домена.
        'as' => $index === 0 ? 'news-storage.' : "news-storage.alias{$index}.",
        'domain' => $domain,
    ], $d);
}
