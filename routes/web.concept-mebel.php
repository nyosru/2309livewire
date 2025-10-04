<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Phpcatcom\News\NewsList;
use App\Livewire\Phpcatcom\News\NewsShow;
use App\Livewire\Phpcatcom\Datar2\DatarList;

$d = function () {
    Route::get('/', \App\Livewire\ConceptMebel\Index::class)->name('index');
//    Route::get('/aa/', \App\Livewire\Cfa\Index::class)->name('index2');
//    // Новости
//    Route::get('/news', NewsList::class)->name('news.index');
//    Route::get('/news/{slug}', NewsShow::class)->name('news.show');
//
//    Route::get('/datar', DatarList::class)->name('datar.list');
//
//    Route::get('/login',function () {
////    return response('Привет буфет, ещё пару сек пожалуйста');
//        return redirect('/');
//    });

    Route::fallback(function () {

        if (request()->isMethod('get')) {
            return redirect('/');
        }

        abort(404);
    });

};

Route::group([
    'as' => 'mebel.',
    // концепт мебель.рф
    'domain' => ( (request()->getHost() === 'mebel.local') ? 'mebel.local' : 'xn--90ahabvkdgim7a8b8e.xn--p1ai' )
], $d);
