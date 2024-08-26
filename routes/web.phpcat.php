<?php

use App\Http\Controllers\Phpcat\MsgSendController;
use App\Livewire\Phpcat\Develop;
use App\Livewire\Phpcat\News;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', News::class)->name('index');
    Route::get('/develop/{item}', Develop::class)->name('develop');
    Route::any('/msg', MsgSendController::class)->name('msg.send');
//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
////    Route::get('news', News::class)->name('news');
////    Route::get('torrent', News::class)->name('torrent');
////    Route::get('money', News::class)->name('money');
//    // Route::get('{.*}', News::class)->name('other');
//    //    Route::fallback(function () { return redirect('/'); });
};

Route::group([
    'as' => 'phpcat.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'php-cat.local' : 'php-cat.com'
], $d);

