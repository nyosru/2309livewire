<?php

use Illuminate\Support\Facades\Route;

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

