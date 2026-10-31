<?php

use Illuminate\Support\Facades\Route;

foreach ([
    'local' => 'marudi.local',
    'production' => 'xn--80aimnvs.xn--p1ai',
] as $environment => $domain) {
    Route::domain($domain)->name("marudi.{$environment}.")->group(function () {
        Route::view('/', 'marudi.index')->name('index');
    });
}
