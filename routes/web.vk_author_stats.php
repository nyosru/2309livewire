<?php

use App\Http\Controllers\VkAuthorStatsController;
use Illuminate\Support\Facades\Route;

Route::domain('go.vk.local')
    ->middleware('throttle:60,1')
    ->get('/', [VkAuthorStatsController::class, 'index'])
    ->name('vk-author-stats.index');
