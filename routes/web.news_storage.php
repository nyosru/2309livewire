<?php

use App\Livewire\NewsStorage\ApiDocs;
use App\Livewire\NewsStorage\Index;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', Index::class)->name('index');
    Route::get('/api-docs', ApiDocs::class)->name('api-docs');

    Route::fallback(function () {
        return redirect('/');
    });
};

$domain = ( request()->getHost() === 'news.local') ? 'news.local' : 'news.api.php-cat.ru' ;
//env('APP_ENV', 'local') == 'local' ? 'news.local' : 'news.api.php-cat.ru'

Route::group([
    'as' => 'news-storage.',
    'domain' => $domain ,
], $d);
