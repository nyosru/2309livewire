<?php

use Illuminate\Support\Facades\Route;





use App\Livewire\Phpcat\Develop;
use App\Livewire\Phpcat\News;

$d = function() {
    Route::get('/', News::class)->name('index');
    Route::get('/develop/{item}', Develop::class)->name('develop');
};

Route::group([
    'as' => 'phpcat.',
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'php-cat.local' : 'php-cat.com'
], $d);





//Route::get('{.*}',function () {
//    return response( $_SERVER['HTTP_HOST'] ?? 'x' );
////    return redirect('/');
//});


//dd($_SERVER['HTTP_HOST']);

require('web.phpcat.php');
require('web.domainwaiter.php');
require('web.uprav.php');
require('web.phpcat.files.php');
require('web.ar.php');
// земельный кадастр
require('web.zem.php');

//Route::get('{.*}',function () {
//    return response('Привет буфет, ещё пару сек пожалуйста');
////    return redirect('/');
//});
//
