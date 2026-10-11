<?php

use App\Livewire\Catcom\Index;
use Illuminate\Support\Facades\Route;

$catcomRoutes = function () {
    Route::get('/', Index::class)->name('index');
};

Route::group([
    'as' => 'catcom.local.',
    'domain' => 'catcom.local',
], $catcomRoutes);

Route::group([
    'as' => 'catcom.',
    // катком.рф
    'domain' => 'xn--80atbijw.xn--p1ai',
], $catcomRoutes);
