<?php

use App\Livewire\Uprav\UpravIndex ;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', [UpravIndex::class,'index'] )->name('index');
//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
////    Route::get('news', News::class)->name('news');
////    Route::get('torrent', News::class)->name('torrent');
////    Route::get('money', News::class)->name('money');
//    // Route::get('{.*}', News::class)->name('other');
//    //    Route::fallback(function () { return redirect('/'); });
};

$inRoute = [];

if (env('APP_ENV', 'x') == 'local') {
    $inRoute[] =
        [
            'as' => 'uprav.',
//            'domain' => (env('APP_ENV', 'x') == 'local') ? 'php-cat.local' : 'php-cat.com'
        'domain' => 'uprav.local'
    ];
} else {
    $inRoute[] =
        [
            'as' => 'uprav.',
//            'domain' => (env('APP_ENV', 'x') == 'local') ? 'php-cat.local' : 'php-cat.com'
        'domain' => 'управлятор.рф'
    ];
}


foreach ($inRoute as $i) {
    Route::group($i, $d);
}

//Route::group([
////    'as' => 'phpcat.',
//    'domain' => 'php-cat.com'
//], $d);
//Route::group([
////    'as' => 'phpcat.',
//    'domain' => 'livewire.php-cat.com'
//], $d);
