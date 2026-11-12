<?php

use App\Http\Controllers\VkManagerController;
use Illuminate\Support\Facades\Route;

Route::group(['domain' => 'vk.php-cat.ru', 'as' => 'vk-manager.'], function () {
    Route::get('/', [VkManagerController::class, 'index'])->name('index');
    Route::get('/login', [VkManagerController::class, 'login'])->name('login');
    Route::post('/logout', [VkManagerController::class, 'logout'])->name('logout');
    Route::get('/auth/master', [VkManagerController::class, 'startAuth'])->name('auth.master');
    Route::get('/auth/master/callback', [VkManagerController::class, 'callback'])->name('auth.master.callback');
    Route::post('/friends/{vkFriendId}/favorite', [VkManagerController::class, 'favorite'])->middleware('auth')->whereNumber('vkFriendId')->name('favorite');
    Route::post('/friends/{vkFriendId}/comment', [VkManagerController::class, 'comment'])->middleware('auth')->whereNumber('vkFriendId')->name('comment');
});
