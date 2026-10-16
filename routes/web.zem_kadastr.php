<?php

use App\Livewire\Zem_kadastr\Index;
use Illuminate\Support\Facades\Route;

$zemKadastrRoutes = function () {
    Route::get('/', Index::class)->name('index');
};

Route::group([
    'as' => 'zem2.local.',
    'domain' => 'zem2.local',
], $zemKadastrRoutes);

Route::group([
    'as' => 'zem.',
    // земельныйкадастр.рф
    'domain' => 'xn--80aalcakqihin5bmo2koa.xn--p1ai',
], $zemKadastrRoutes);
