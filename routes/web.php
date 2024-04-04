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
require('web.phpcat.php');
require('web.domainwaiter.php');
require('web.uprav.php');
require('web.phpcat.files.php');
require('web.ar.php');
// земельный кадастр
require('web.zem.php');

$ee =     function() {
    Route::get('/', function() {
        dd([__FILE__,__LINE__]);
////         return view('phpcat.index');
    });
};

Route::group(['domain' => 'bu72.ru'], $ee );
Route::group(['domain' => 'vk.files.php-cat.com'], $ee );
Route::group(['domain' => 'продукты72.рф'], $ee );
Route::group(['domain' => 'xn--72-jlcysfhth6f.xn--p1ai'], $ee );
//Route::group(['domain' => ''], $ee );
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

