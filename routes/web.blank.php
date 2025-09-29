<?php

use App\Http\Controllers\SocWebController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\StNews\StNewsModeration;
use App\Livewire\StNews\ModerateNews;
use App\Livewire\StNews\Index as StNewsIndex;
use App\Livewire\StNews\Show;
use Nyos\Msg;

//use App\Livewire\StNews\Create as StNewsCreate;
//use App\Livewire\StNews\Show as StNewsShow;

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
//use Socialite;


use App\Http\Controllers\VkAuthController;


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


//    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
//        Route::get('friends', \App\Livewire\Vk\FriendsComponent::class)->name('friends');
//    });
//
//// Маршрут для авторизации через ВКонтакте
//    Route::get('login/vk', [LoginController::class, 'redirectToProvider'])->name('login');
//    Route::get('callback/vk', [LoginController::class, 'handleProviderCallback']);

    Route::any('/vk/enter', [SocWebController::class, 'enter'])->name('vk-enter');
    Route::any('/vk/call-back', [SocWebController::class, 'callBack'])->name('vk-callback');
    Route::any('v', function(){
        Auth::loginUsingId(3);
        redirect()->to('/');
    });


    // Фоллбэк на случай отсутствия других маршрутов
    Route::fallback(function () {
        return redirect('/');
    });
};


//Route::group([
//    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai'
//],
//    function () {
//        #Route::get('login/vk', [LoginController::class, 'redirectToProvider'])->name('login');
//
//        Route::get('login/vk', [VkAuthController::class, 'redirectToVk'])->name('login.vk');
//        Route::get('callback/vk', [VkAuthController::class, 'handleVkCallback'])->name('vk.callback');
//
//    }
//);


// Группировка маршрутов для домена
Route::group([
    'as' => 'stn.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai'
], $d);
//Route::group([
//    'as' => 'stn2.',
//    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'stn.dev.php-cat.com'
//], $d);
