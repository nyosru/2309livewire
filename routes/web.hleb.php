<?php

use App\Http\Controllers\Hleb\LandingController;
use Illuminate\Support\Facades\Route;

foreach (['hleb.local', 'xn--80ablnmob2dxa6f.xn--p1ai', 'хлебничная.рф'] as $index => $domain) {
    Route::domain($domain)->name('hleb.'.$index.'.')->group(function () {
        Route::get('/', [LandingController::class, 'index'])->name('home');
        Route::view('/franchise', 'hleb.franchise')->name('franchise');
        Route::post('/requests', [LandingController::class, 'store'])->middleware('throttle:5,1')->name('requests');
    });
}
