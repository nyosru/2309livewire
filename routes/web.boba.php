<?php

use App\Http\Controllers\Boba\ConsultationController;
use Illuminate\Support\Facades\Route;

$boba = function () {
    Route::view('/', 'boba.index')->name('home');
    Route::post('/consultation', [ConsultationController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('consultation.store');
};

foreach (['boba.local', 'боба.рф', 'xn--80aba5c.xn--p1ai'] as $index => $domain) {
    Route::domain($domain)->name('boba.'.$index.'.')->group($boba);
}
