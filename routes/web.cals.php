<?php

use App\Http\Controllers\Cals\CallTreeController;
use Illuminate\Support\Facades\Route;

Route::domain('cals.local')->name('cals.')->group(function () {
    Route::get('/', [CallTreeController::class, 'index'])->name('index');
    Route::post('/contacts', [CallTreeController::class, 'storeContact'])->name('contacts.store');
    Route::get('/contacts/{contact}', [CallTreeController::class, 'showContact'])->name('contacts.show');
    Route::put('/contacts/{contact}', [CallTreeController::class, 'updateContact'])->name('contacts.update');
    Route::post('/contacts/{contact}/comments', [CallTreeController::class, 'storeComment'])->name('contacts.comments.store');
    Route::post('/calls', [CallTreeController::class, 'storeCall'])->name('calls.store');
    Route::post('/calls/attach', [CallTreeController::class, 'attachCalls'])->name('calls.attach-many');
});
