<?php

use App\Http\Controllers\Vkusno\CafeController;
use Illuminate\Support\Facades\Route;



# вкусняжки72.рф (основной), вкусняшки72.рф (редирект на вкусняжки)

// Редирект с вкусняшки72.рф на вкуснякжки72.рф
Route::domain('xn--72-dlcqkkbw9at8k.xn--p1ai')->group(function () {
    return redirect('https://xn--72-dlcyjau5ar6c5d.xn--p1ai');
});

// Основной домен вкуснякжки72.рф
foreach (['vkusno.local', 'xn--72-dlcyjau5ar6c5d.xn--p1ai'] as $index => $domain) {
    Route::domain($domain)->name('vkusno.'.$index.'.')->group(function () {
        Route::get('/', [CafeController::class, 'index'])->name('home');
        Route::post('/orders', [CafeController::class, 'store'])->middleware('throttle:10,1')->name('order');
        Route::view('/privacy', 'vkusno.privacy')->name('privacy');
        Route::get('/admin/orders', [CafeController::class, 'orders'])->middleware(['auth', 'can:manage-vkusno'])->name('orders');
    });
}
