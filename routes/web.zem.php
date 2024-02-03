<?php

use App\Livewire\Phpcat\Develop;
use App\Livewire\Phpcat\News;
use Illuminate\Support\Facades\Route;

$d = function () {

//    Route::get('/', News::class)->name('index');
//    Route::get('/develop/{item}', Develop::class)->name('develop');
//    Route::get('services', News::class)->name('services');
     Route::get('/', function () {
        dd([__FILE__,__LINE__]);
//         return view('phpcat.index');
     });
////    Route::get('news', News::class)->name('news');
////    Route::get('torrent', News::class)->name('torrent');
////    Route::get('money', News::class)->name('money');
//    // Route::get('{.*}', News::class)->name('other');
//    //    Route::fallback(function () { return redirect('/'); });

};

Route::group([
    'as' => 'zem.',
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'zem.local' : 'земельныйкадастр.рф'
], $d);

