<?php

use App\Http\Controllers\Service\QrController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
// });

require 'api.stn.php';
require 'api.phpcat.php';

Route::get('qr', [QrController::class, 'create'])->name('qr.create');

Route::post('blog', [\App\Http\Controllers\Api\BlogApiController::class, 'store'])->name('api.blog.store');
Route::post('max/webhook', \App\Http\Controllers\Max\WebhookController::class)->middleware('throttle:120,1')->name('api.max.webhook');
Route::prefix('max/service')->middleware([\App\Http\Middleware\EnsureMaxServiceClient::class, 'throttle:60,1'])->group(function () {
    Route::post('message', [\App\Http\Controllers\Max\ServiceController::class, 'message']);
    Route::post('auth/start', [\App\Http\Controllers\Max\ServiceController::class, 'start']);
    Route::post('auth/check', [\App\Http\Controllers\Max\ServiceController::class, 'check']);
});

Route::prefix('news-storage')->group(function () {
    Route::post('news', [\App\Http\Controllers\Api\NewsStorageController::class, 'store'])->name('api.news-storage.store');
    Route::patch('news/{id}/status', [\App\Http\Controllers\Api\NewsStorageController::class, 'updateStatus'])->name('api.news-storage.status');
});
