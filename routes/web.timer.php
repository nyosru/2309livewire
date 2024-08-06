<?php

use Illuminate\Support\Facades\Route;

$d = function () {
//    Route::get('/', News::class)->name('index');
//    Route::get('/', \App\Livewire\ar\table::class)->name('index');
//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
    Route::get('/', function () {
        return view('ring');
    });
//    Route::fallback(function () { return redirect('/'); });
};

$inRoute = [
    [
        'as' => 'ar.',
        'domain' => (env('APP_ENV', 'local') == 'local') ?
            'timer.local' :
//            таймер.сергейсб.рф
            'xn--80aklmvh.xn--90adfbu3bff.xn--p1ai'
    ]
];

foreach ($inRoute as $i) {
    Route::group($i, $d);
}
