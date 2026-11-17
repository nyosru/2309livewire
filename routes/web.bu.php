<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\BuAuthController;
use Illuminate\Support\Facades\Route;

// ---- публичные ----
Route::domain(app()->environment('local', 'testing') ? 'bu.local' : 'bu72.ru')->group(function () {
    Route::get('/', [BoardController::class, 'index'])->name('board.index');
    Route::get('/category/{category}', [BoardController::class, 'category'])->name('board.category');
    Route::get('/ads/{ad}', [BoardController::class, 'show'])->name('ads.show');

    // ---- личный кабинет (только для авторизованных) ----
    Route::middleware('auth')->group(function () {
        Route::get('/cabinet', [CabinetController::class, 'index'])->name('cabinet.index');
        Route::get('/cabinet/ads', [App\Livewire\Cabinet\AdIndex::class, 'render'])->name('cabinet.ads.index');
        Route::post('/cabinet/ads/store', [AdController::class, 'store'])->name('cabinet.ads.store');
        Route::delete('/cabinet/ads/{ad}', [AdController::class, 'destroy'])->name('cabinet.ads.destroy');
        Route::get('/cabinet/categories', [CategoryController::class, 'index'])->name('cabinet.categories.index');
        Route::post('/cabinet/categories', [CategoryController::class, 'store'])->name('cabinet.categories.store');
        Route::put('/cabinet/categories/{category}', [CategoryController::class, 'update'])->name('cabinet.categories.update');
        Route::delete('/cabinet/categories/{category}', [CategoryController::class, 'destroy'])->name('cabinet.categories.destroy');
        Route::post('/logout', function () {
            auth()->logout();
            return redirect('/');
        })->name('logout');
    });

    // ---- вход через ВКонтакте ----
    Route::get('/login', [BuAuthController::class, 'login'])->name('bu.login');
    Route::get('/auth/master', [BuAuthController::class, 'startAuth'])->name('bu.auth.master.start');
    Route::get('/auth/master/callback', [BuAuthController::class, 'callback'])->name('bu.auth.master.callback');
});
