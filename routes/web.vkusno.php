<?php

use App\Http\Controllers\Vkusno\AccessAdminController;
use App\Http\Controllers\Vkusno\AuthController;
use App\Http\Controllers\Vkusno\CafeController;
use App\Http\Controllers\Vkusno\CatalogAdminController;
use App\Http\Controllers\Vkusno\MaxAuthController;
use App\Http\Controllers\Vkusno\ProductAdminController;
use App\Http\Middleware\EnsureVkusnoAdmin;
use App\Http\Middleware\EnsureVkusnoSuperAdmin;
use Illuminate\Support\Facades\Route;

// Редирект с вкусняшки72.рф на вкуснякжки72.рф
Route::domain('xn--72-dlcyjau5ar6c5d.xn--p1ai')->group(function () {
    return redirect('https://xn--72-dlcqkkbw9at8k.xn--p1ai');
});

$d = function () {
    Route::get('/', [CafeController::class, 'index'])->name('home');
    Route::post('/orders', [CafeController::class, 'store'])->middleware('throttle:10,1')->name('order');
    Route::view('/privacy', 'vkusno.privacy')->name('privacy');
    Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/admin/auth/max/request', [MaxAuthController::class, 'requestCode'])->middleware('throttle:10,1')->name('admin.max.request');
    Route::post('/admin/auth/max/verify', [MaxAuthController::class, 'verify'])->middleware('throttle:20,1')->name('admin.max.verify');
    Route::post('/admin/auth/max/reset', [MaxAuthController::class, 'reset'])->name('admin.max.reset');
    Route::get('/admin/auth/vk', [AuthController::class, 'redirect'])->middleware('throttle:10,1')->name('admin.vk');
    Route::get('/admin/auth/vk/callback', [AuthController::class, 'callback'])->middleware('throttle:10,1')->name('admin.vk.callback');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::prefix('admin')->middleware(EnsureVkusnoAdmin::class)->group(function () {
        Route::redirect('/', '/admin/products')->name('admin');
        Route::get('/orders', [CafeController::class, 'orders'])->name('orders');
        Route::get('/products', [ProductAdminController::class, 'index'])->name('products');
        Route::get('/products/create', [ProductAdminController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductAdminController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');
        Route::get('/sections', [CatalogAdminController::class, 'sections'])->name('sections');
        Route::post('/sections', [CatalogAdminController::class, 'saveSection'])->name('sections.store');
        Route::put('/sections/{section}', [CatalogAdminController::class, 'saveSection'])->name('sections.update');
        Route::delete('/sections/{section}', [CatalogAdminController::class, 'destroySection'])->name('sections.destroy');
        Route::get('/categories', [CatalogAdminController::class, 'categories'])->name('categories');
        Route::post('/categories', [CatalogAdminController::class, 'saveCategory'])->name('categories.store');
        Route::put('/categories/{category}', [CatalogAdminController::class, 'saveCategory'])->name('categories.update');
        Route::delete('/categories/{category}', [CatalogAdminController::class, 'destroyCategory'])->name('categories.destroy');
        Route::middleware(EnsureVkusnoSuperAdmin::class)->group(function () {
            Route::get('/access', [AccessAdminController::class, 'index'])->name('access');
            Route::post('/access', [AccessAdminController::class, 'store'])->name('access.store');
            Route::post('/access/phones', [AccessAdminController::class, 'storePhone'])->name('access.phones.store');
            Route::delete('/access/phones/{phoneAdministrator}', [AccessAdminController::class, 'destroyPhone'])->name('access.phones.destroy');
            Route::delete('/access/{administrator}', [AccessAdminController::class, 'destroy'])->name('access.destroy');
        });
    });
};

// вкусняжки72
Route::group([
    'as' => 'vkusno.',
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'vkusno . local' : 'xn--72-dlcqkkbw9at8k.xn--p1ai',
], $d);
