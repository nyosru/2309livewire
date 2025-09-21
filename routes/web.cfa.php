<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Phpcatcom\News\NewsList;
use App\Livewire\Phpcatcom\News\NewsShow;
use App\Livewire\Phpcatcom\Datar2\DatarList;

$d = function () {
    Route::get('/', \App\Livewire\Cfa\Index::class)->name('index');
    Route::get('/aa/', \App\Livewire\Cfa\Index::class)->name('index2');
    // Новости
    Route::get('/news', NewsList::class)->name('news.index');
    Route::get('/news/{slug}', NewsShow::class)->name('news.show');

    Route::get('/datar', DatarList::class)->name('datar.list');

    Route::get('/login',function () {
//    return response('Привет буфет, ещё пару сек пожалуйста');
        return redirect('/');
    });

};
// Route::group([
//    'as' => 'cfa.',
// //    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa2.local' : 'cfa-center.ru'
//    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa.local' : 'cfa-center.ru'
//], $d);

Route::group([
    'as' => 'cfa.',
    'domain' => ( (request()->getHost() === 'cfa.local') ? 'cfa.local' : 'cfa-center.ru' )
], $d);
Route::group([
    'as' => 'cfa2.',
    'domain' => 'cfa.php-cat.com'
], $d);
