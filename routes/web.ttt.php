<?php

use App\Livewire\Phpcatcom\Datar2\DatarList;
use App\Livewire\Phpcatcom\News\NewsList;
use App\Livewire\Phpcatcom\News\NewsShow;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', \App\Livewire\Ttt\Index::class)->name('index');
    Route::get('/admin/clubs', \App\Livewire\Ttt\Admin\Clubs::class)
        ->middleware(['auth', 'can:manage-ttt-clubs'])
        ->name('admin.clubs');

};

$requestHost = request()->getHost();
$localHosts = ['ttt.local', '127.0.0.1', 'localhost'];

Route::group([
    'as' => 'ttt.',
    'domain' => in_array($requestHost, $localHosts, true) ? $requestHost : 'ttt72.ru',
], $d);
Route::group([
    'as' => 'ttt2.',
    //    'domain' => 'ттт72.рф'
    'domain' => 'xn--72-qmcaa.xn--p1ai',
], $d);
