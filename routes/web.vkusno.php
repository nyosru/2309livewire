<?php

use App\Http\Controllers\Vkusno\CafeController;
use Illuminate\Support\Facades\Route;



# вкусняжки72.рф вкусняшки72.рф
$domain = ['vkusno.local', 'xn--72-dlcqkkbw9at8k.xn--p1ai', 'xn--72-dlcyjau5ar6c5d.xn--p1ai'];

foreach ( $domain as $index => $domain) {
    Route::domain($domain)->name('vkusno.'.$index.'.')->group(function () {
        Route::get('/', [CafeController::class, 'index'])->name('home');
        Route::post('/orders', [CafeController::class, 'store'])->middleware('throttle:10,1')->name('order');
        Route::view('/privacy', 'vkusno.privacy')->name('privacy');
        Route::get('/admin/orders', [CafeController::class, 'orders'])->middleware(['auth', 'can:manage-vkusno'])->name('orders');
    });
}
