<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Phpcatcom\News\NewsList;
use App\Livewire\Phpcatcom\News\NewsShow;
use App\Livewire\Phpcatcom\Datar2\DatarList;

$d = function () {
    Route::get('/', \App\Livewire\Krostu\Index::class)->name('index');
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

// Route::group([
//    'as' => 'cfa.',
// //    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa2.local' : 'cfa-center.ru'
//    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa.local' : 'cfa-center.ru'
//], $d);

Route::group([
    'as' => 'krostu.',
    'domain' => ( (request()->getHost() === 'krostu.local') ? 'krostu.local' : 'krostu.com' )
], $d);


# кросту.рф
Route::group([
    'as' => 'krostu2.',
    'domain' => 'xn--j1aifffg.xn--p1ai'
], $d);

//Route::group([
//    'as' => 'krostu2.',
//    'domain' => 'www.krostu.com'
//], $d);


//Route::domain('krostu.com')->group(function () {
////    Route::get('{any}', function () {
//        return redirect('https://www.krostu.com', 301);
////    })->where('any', '.*')
////;
//});

