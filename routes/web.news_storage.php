<?php

use App\Livewire\NewsStorage;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', NewsStorage\Index::class)->name('index');
    Route::get('/api-docs', NewsStorage\ApiDocs::class)->name('api-docs');
    Route::get('/news/{id}', NewsStorage\Show::class)->name('show');

    Route::fallback(function () {
        return redirect('/');
    });
};

$domain = (request()->getHost() === 'news.local') ? 'news.local' : 'news.api.php-cat.ru';
// env('APP_ENV', 'local') == 'local' ? 'news.local' : 'news.api.php-cat.ru'

Route::group([
    'as' => 'news-storage.',
    'domain' => $domain,
], $d);
