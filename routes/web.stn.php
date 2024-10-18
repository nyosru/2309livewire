<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Livewire\StNews\StNewsModeration;
use App\Livewire\StNews\ModerateNews;
use App\Livewire\StNews\Index as StNewsIndex;
use App\Livewire\StNews\Show;
use Nyos\Msg;

//use App\Livewire\StNews\Create as StNewsCreate;
//use App\Livewire\StNews\Show as StNewsShow;

$d = function () {
    // Маршрут для главной страницы новостей
    Route::get('/', StNewsIndex::class)->name('index');

//    // Маршрут для показа одной новости
//    Route::get('/news/{id}', StNewsShow::class)->name('show');
//
//    // Маршрут для создания новости
//    Route::get('/create', StNewsCreate::class)->name('create');

    // Маршрут для страницы модерации новостей
    Route::get('/caddy', \App\Livewire\CaddyfileDomainChecker::class)->name('caddy-checker');
    Route::get('/caddy2', \App\Livewire\CaddyDomainFetcher::class)->name('caddy-fetcher');

    Route::get('/moderation', StNewsModeration::class)->name('moderation');
    Route::get('/m', [StNewsModeration::class,'m'])->name('moderation1');

    Route::group(['a' => 'a.', 'prefix' => 'a'], function () {
        Route::get('/m', \App\Livewire\StNews\A\Index::class)->name('index');
    });


    Route::get('news/download-photo', function () {
        Artisan::call('StNews:news-download-photo');
        Msg::sendTelegramm('запуск команды StNews:news-download-photo',null,2);
        return 'News download photo command executed!';
    });

    Route::group(['as' => 'news.', 'prefix' => 'news'], function () {
        // Маршрут для модерации конкретной новости
        Route::get('moderate/{id}', ModerateNews::class)->name('mod');
        Route::get('{id}', Show::class)->name('show');


    });

    // Фоллбэк на случай отсутствия других маршрутов
    Route::fallback(function () {
        return redirect('/');
    });
};

// Группировка маршрутов для домена
Route::group([
    'as' => 'stn.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai'
], $d);
Route::group([
    'as' => 'stn2.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'stn.dev.php-cat.com'
], $d);
