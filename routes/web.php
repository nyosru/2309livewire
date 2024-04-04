<?php

use App\Livewire\Phpcat\News;
use Illuminate\Support\Facades\Route;

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



require('web.domainwaiter.php');
require('web.uprav.php');
require('web.phpcat.files.php');
require('web.ar.php');
// земельный кадастр
require('web.zem.php');
require('web.phpcat.php');



Route::get('/', function() {
//    dd([__FILE__, __LINE__, env('APP_ENV', 'x')]);
         return view('zaglushka.index');
});

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

