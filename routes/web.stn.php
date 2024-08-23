<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\StNews\StNewsModeration;
use App\Livewire\StNews\ModerateNews;
use App\Livewire\StNews\Index as StNewsIndex;
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
    Route::get('/moderation', StNewsModeration::class)->name('moderation');

    // Маршрут для модерации конкретной новости
    Route::get('/news/moderate/{id}', ModerateNews::class)->name('mod');

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
