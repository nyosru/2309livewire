<?php

use App\Livewire\Phpcat\News;
use App\Livewire\SnowkStart;
use Illuminate\Support\Facades\Route;

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

require('web.stn.php');

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

