<?php

use Illuminate\Support\Facades\Route;

//Route::get('{.*}',function () {
    return response( $_SERVER['HTTP_HOST'] ?? 'x' );
//    return redirect('/');
//});


//dd($_SERVER['HTTP_HOST']);

require('web.phpcat.php');
require('web.domainwaiter.php');
require('web.uprav.php');
require('web.phpcat.files.php');
require('web.ar.php');
// земельный кадастр
require('web.zem.php');

Route::get('{.*}',function () {
    return response('Привет буфет, ещё пару сек пожалуйста');
//    return redirect('/');
});

