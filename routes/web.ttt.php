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
    //    Route::get('/aa/', \App\Livewire\Cfa\Index::class)->name('index2');
    //    // Новости
    //    Route::get('/news', NewsList::class)->name('news.index');
    //    Route::get('/news/{slug}', NewsShow::class)->name('news.show');
    //
    //    Route::get('/datar', DatarList::class)->name('datar.list');
    //
    //    Route::get('/login',function () {
    // //    return response('Привет буфет, ещё пару сек пожалуйста');
    //        return redirect('/');
    //    });

};
// Route::group([
//    'as' => 'cfa.',
// //    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa2.local' : 'cfa-center.ru'
//    'domain' => (env('APP_ENV', 'x') == 'local') ? 'cfa.local' : 'cfa-center.ru'
// ], $d);

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

//
// // для cfa
// Route::middleware(['auth'])->group(function () {
//    Route::prefix('tech')->name('tech.')->group(function () {
//
//        // Админка Datar
//        Route::prefix('datar2')->as('datar2')->group(function () {
//            Route::get('/', \App\Livewire\Phpcatcom\Datar2\Admin\DatarAdmin::class)->name('');
//            // Родители
//            Route::get('/parents/create', \App\Livewire\Phpcatcom\Datar2\Admin\DatarParent2Create::class)->name('.parents.create');
// //                Route::get('/parents/create', \App\Livewire\Phpcatcom\Datar2\Admin\DatarParentCreate::class)->name('.parents.create');
//
//            Route::get('/parents/edit/{id}', \App\Livewire\Phpcatcom\Datar2\Admin\DatarParentEdit::class)->name('.parents.edit');
//
// //                // Дети
//            Route::get('/children/create', \App\Livewire\Phpcatcom\Datar2\Admin\DatarChildCreate::class)->name('.children.create');
//            Route::get('/children/edit/{id}', \App\Livewire\Phpcatcom\Datar2\Admin\DatarChildEdit::class)->name('.children.edit');
//        });
//
//        // Админка новостей
//        Route::prefix('admin/news')->as('news.admin')->group(function () {
//            Route::get('/', \App\Livewire\Phpcatcom\News\Admin\NewsAdmin::class)->name('');
//            Route::get('/create', \App\Livewire\Phpcatcom\News\Admin\NewsCreate::class)->name('.create');
//            Route::get('/edit/{id}', \App\Livewire\Phpcatcom\News\Admin\NewsEdit::class)->name('.edit');
//        });
//
//    });
// });
