<?php

use App\Livewire\Phpcat\News;
use App\Livewire\SnowkStart;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/







use App\Livewire\Phpcatcom\News\NewsList;
use App\Livewire\Phpcatcom\News\NewsShow;
use App\Livewire\Phpcatcom\Datar2\DatarList;

$d = function () {
    Route::get('/', \App\Livewire\Cfa\Index::class)->name('index');
    Route::get('/aa/', \App\Livewire\Cfa\Index::class)->name('index2');
    // Новости
    Route::get('/news', NewsList::class)->name('news.index');
    Route::get('/news/{slug}', NewsShow::class)->name('news.show');

    Route::get('/datar', DatarList::class)->name('datar.list');

    Route::get('/login',function () {
//    return response('Привет буфет, ещё пару сек пожалуйста');
        return redirect('/');
    });

};
Route::group([
    'as' => 'cfa.',
//    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa2.local' : 'cfa-center.ru'
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa.local' : 'cfa-center.ru'
], $d);
Route::group([
    'as' => 'cfa2.',
    'domain' => 'cfa.php-cat.com'
], $d);

Route::middleware(['auth'])->group(function () {
    Route::prefix('tech')->name('tech.')->group(function () {

        // Админка Datar
        Route::prefix('datar2')->as('datar2')->group(function () {
            Route::get('/', \App\Livewire\Phpcatcom\Datar2\Admin\DatarAdmin::class)->name('');
            // Родители
            Route::get('/parents/create', \App\Livewire\Phpcatcom\Datar2\Admin\DatarParent2Create::class)->name('.parents.create');
//                Route::get('/parents/create', \App\Livewire\Phpcatcom\Datar2\Admin\DatarParentCreate::class)->name('.parents.create');

            Route::get('/parents/edit/{id}', \App\Livewire\Phpcatcom\Datar2\Admin\DatarParentEdit::class)->name('.parents.edit');

//                // Дети
            Route::get('/children/create', \App\Livewire\Phpcatcom\Datar2\Admin\DatarChildCreate::class)->name('.children.create');
            Route::get('/children/edit/{id}', \App\Livewire\Phpcatcom\Datar2\Admin\DatarChildEdit::class)->name('.children.edit');
        });

        // Админка новостей
        Route::prefix('admin/news')->as('news.admin')->group(function () {
            Route::get('/', \App\Livewire\Phpcatcom\News\Admin\NewsAdmin::class)->name('');
            Route::get('/create', \App\Livewire\Phpcatcom\News\Admin\NewsCreate::class)->name('.create');
            Route::get('/edit/{id}', \App\Livewire\Phpcatcom\News\Admin\NewsEdit::class)->name('.edit');
        });

    });
});














//Route::view('/', 'welcome');
//
//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::view('profile', 'profile')
//    ->middleware(['auth'])
//    ->name('profile');
//
require __DIR__ . '/auth.php';


//$files = scandir( __DIR__.'/web/');
//foreach ($files as $f) {
//    if (strpos($f, '.php') != false ) {
//        require(__DIR__.'/web/' . $f);
//    }
//}

require('web.afisha.php');


////Route::get('{.*}',function () {
////    return response( $_SERVER['HTTP_HOST'] ?? 'x' );
//////    return redirect('/');
////});
//
//
////dd($_SERVER['HTTP_HOST']);
//


//$ee = function() {
//    Route::get('/', function() {
//        dd([__FILE__, __LINE__, env('APP_ENV', 'x')]);
//////         return view('phpcat.index');
//    });
//};
//
//
//
//Route::group(['domain' => 'управлятор.рф'], $ee);
//Route::group(['domain' => 'xn--80ae1ambgeod9j.xn--p1ai'], $ee);
//
//Route::group(['domain' => 'php-cat.com'], $ee);
//Route::group(['domain' => 'domainwaiter.com'], $ee);
//Route::group(['domain' => 'bu72.ru'], $ee);
//Route::group(['domain' => 'vk.files.php-cat.com'], $ee);
//
//Route::group(['domain' => 'продукты72.рф'], $ee);
//Route::group(['domain' => 'xn--72-jlcysfhth6f.xn--p1ai'], $ee);
//
//Route::group(['domain' => 'приватизациягаража.рф'], $ee);
//Route::group(['domain' => 'xn--80aaaaahj0aehcc8fojz5e1i.xn--p1ai'], $ee);
//
//Route::group(['domain' => 'земельныйкадастр.рф'], $ee);
//Route::group(['domain' => 'xn--80aalcakqihin5bmo2koa.xn--p1ai'], $ee);


//require('web.domainwaiter.php');
require('web.uprav.php');
require('web.phpcat.files.php');
require('web.ar.php');
//            таймер.сергейсб.рф
require('web.timer.php');
// земельный кадастр
require('web.zem.php');
require('web.phpcat.php');
require('web.phpcat_ru.php');
require('web.skidki.php');

$d = function () {
    Route::get('/', SnowkStart::class)->name('index');
//    Route::get('/develop/{item}', Develop::class)->name('develop');
};
Route::group([
    'as' => 'snowkait.',
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'snowk.local' : 'сноукайтинг.рф'
], $d);


$d = function () {
    Route::get('/', SnowkStart::class)->name('index');
//    Route::get('/develop/{item}', Develop::class)->name('develop');
};
Route::group([
    'as' => 'as.php-cat.com.',
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'as.php-cat.com.local' : 'as.php-cat.com'
], $d);


use App\Livewire\Auth\Vk;

Route::get('/auth/vk', [Vk::class, 'redirect'])->name('auth.vk');
Route::get('/auth/vk/callback', [Vk::class, 'handleVKCallback'])->name('auth.vk.callback');






require('web.stn.php');
require('web.mannik.php');

Route::fallback([\App\Http\Controllers\ZaglushkaController::class, 'show']);

//Route::get('/', [ \App\Http\Controllers\ZaglushkaController::class, 'show']);
//Route::get('{.*}', [ \App\Http\Controllers\ZaglushkaController::class, 'show']);

//Route::get('/', function() {
//
//    //    dd([__FILE__, __LINE__, env('APP_ENV', 'x')]);
//         return view('zaglushka.index');
//});

//Route::group(['domain' => ''], $ee );

//Route::get('/', News::class)->name('index');

//
//Route::get('',function () {
////    return '<html>Привет</html>';
//    return response( 'Привет', 200);
////    return response()->json(['message' => 'Привет'], 200);
////    return 'Привет буфет, ещё пару сек пожалуйста';
//});
//Route::get('{.*}',function () {
//    return response('Привет буфет, ещё пару сек пожалуйста');
////    return redirect('/');
//});

