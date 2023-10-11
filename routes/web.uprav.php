<?php

use App\Livewire\Uprav;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', Uprav\UpravIndex::class )->name('index');
//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
////    Route::get('news', News::class)->name('news');
////    Route::get('torrent', News::class)->name('torrent');
////    Route::get('money', News::class)->name('money');
//    // Route::get('{.*}', News::class)->name('other');
//    //    Route::fallback(function () { return redirect('/'); });
};

$inRoute = [];

$inRoute[] =
    [
        'as' => 'uprav.',
//            'domain' => (env('APP_ENV', 'x') == 'local') ? 'php-cat.local' : 'php-cat.com'
//    'domain' => (env('APP_ENV', 'x') == 'local' ? 'uprav.local' : 'управлятор.рф')
    'domain' => (env('APP_ENV', 'x') == 'local' ? 'uprav.local' : 'xn--80ae1ambgeod9j.xn--p1ai')
];

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
