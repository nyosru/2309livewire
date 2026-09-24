<?php

use App\Livewire\Phpcatcom\Datar2\DatarList;
use App\Livewire\Phpcatcom\News\NewsList;
use App\Livewire\Phpcatcom\News\NewsShow;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', \App\Livewire\Cups\Index::class)->name('index');
    Route::get('/a123_', \App\Livewire\Cups\Admin::class)->name('admin');
};

Route::group([
    'as' => 'cups.',
    'domain' => 'cups.php-cat.ru',
], $d);
Route::group([
    'as' => 'cups_local.',
    'domain' => 'cups.local',
], $d);
