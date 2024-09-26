<?php

use App\Http\Controllers\StNews\ParseController;
use App\Models\StNews;
use Illuminate\Support\Facades\Route;
use App\Livewire\StNews\StNewsModeration;
use App\Livewire\StNews\ModerateNews;
use App\Livewire\StNews\Index as StNewsIndex;
use Nyos\Msg;

//use App\Livewire\StNews\Create as StNewsCreate;
//use App\Livewire\StNews\Show as StNewsShow;

$d = function () {

//    // Маршрут для главной страницы новостей
//    Route::get('/', StNewsIndex::class)->name('index');
//
////    // Маршрут для показа одной новости
////    Route::get('/news/{id}', StNewsShow::class)->name('show');
////
////    // Маршрут для создания новости

    Route::get('parse', [ParseController::class,'go'])->name('parse-go');

    Route::get('/parser', [ParseController::class,'parse'])->name('parse');
    // nтащим каталоги
    Route::get('/parsing/catalog', [ParseController::class,'parseCatalog'])->name('parse.catalog');
    // список новостей с каталога
    Route::get('/parsing/news', [ParseController::class,'parseNewsListCatalog'])->name('parse.news_list');
    // грузим содержимое новостей
    Route::get('/parsing/news_full', [ParseController::class,'parseNewsFull'])->name('parse.news_list');

//    // Маршрут для страницы модерации новостей
//    Route::get('/moderation', StNewsModeration::class)->name('moderation');
//
//    // Маршрут для модерации конкретной новости
//    Route::get('/news/moderate/{id}', ModerateNews::class)->name('mod');

    Route::get('/download-photos', function () {
        Msg::sendTelegramm('api download-photos',null,2);
        Artisan::call('StNews:news-download-photo');
        return response()->json(['message' => 'Photos download process initiated.']);
    });

    Route::get('/auto-moderate', function () {
        Msg::sendTelegramm('api auto-moderate',null,2);
        Artisan::call('StNews:news-auto-moderate');
        return response()->json(['message' => 'auto-moderate initiated.']);
    });

//    // Фоллбэк на случай отсутствия других маршрутов
//    Route::fallback(function () {
//        return redirect('/');
//    });
};

// Группировка маршрутов для домена
Route::group([
    'as' => 'stn.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai'
], $d);
