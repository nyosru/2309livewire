<?php

use App\Livewire\ar\table;
use Illuminate\Support\Facades\Route;

$d = function () {
//    Route::get('/', News::class)->name('index');
    Route::get('/', table::class)->name('index');
//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
     Route::get('/ring', function () { return view('ring'); });
//    Route::fallback(function () { return redirect('/'); });
};

$inRoute = [
    [
        'as' => 'ar.',
        'domain' => (env('APP_ENV', 'local') == 'local') ? 'ar.php-cat.local' : 'ar.php-cat.com'
    ]
];

foreach ($inRoute as $i) {
    Route::group($i, $d);
}
