<?php

use App\Http\Controllers\Calls\RecorderController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'calls.',
    'domain' => 'calls.local',
], function () {
    Route::get('/', [RecorderController::class, 'index'])->name('index');
    Route::get('/file/{filename}', [RecorderController::class, 'file'])
        ->where('filename', '.*')
        ->name('file');

    Route::get('/audio/{source}/{filename}', [RecorderController::class, 'audioFile'])
        ->where('filename', '.*')->name('audio');
    Route::post('/branches', [RecorderController::class, 'storeBranch'])->name('branches.store');
    Route::post('/contacts', [RecorderController::class, 'storeContact'])->name('contacts.store');
    Route::put('/branches/{branch}', [RecorderController::class, 'updateBranch'])->name('branches.update');
    Route::put('/recordings/{key}/branch', [RecorderController::class, 'assignBranch'])->name('recordings.branch');
    Route::put('/recordings/{key}/status', [RecorderController::class, 'updateRecordingStatus'])->name('recordings.status');

    Route::post('/tags', [RecorderController::class, 'storeTag'])->name('tags.store');
    Route::put('/tags/{tag}', [RecorderController::class, 'updateTag'])->name('tags.update');
    Route::delete('/tags/{tag}', [RecorderController::class, 'destroyTag'])->name('tags.destroy');

    Route::post('/recordings/{basename}/tags', [RecorderController::class, 'attachTag'])->name('recordings.tags.attach');
    Route::delete('/recordings/{basename}/tags/{tag}', [RecorderController::class, 'detachTag'])->name('recordings.tags.detach');
});
