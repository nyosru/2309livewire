<?php

use App\Http\Controllers\Dzudo\ApplicationController;
use Illuminate\Support\Facades\Route;

foreach (['dzudo.local', 'ЦентрДзюдо.рф', 'xn--d1aabj2ajkp7a5f.xn--p1ai'] as $index => $domain) {
    Route::domain($domain)->name('dzudo.'.$index.'.')->group(function () {
        Route::view('/', 'dzudo.index')->name('home');
        Route::post('/applications', [ApplicationController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('applications.store');
    });
}
