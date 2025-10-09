<?php

use Illuminate\Support\Facades\Route;

$d = function () {
//    Route::get('/', News::class)->name('index');
//    Route::get('/', \App\Livewire\ar\table::class)->name('index');
//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
    Route::get('/', \App\Livewire\Mannik\IndexComponent::class)->name('home');
//    Route::get('/', function () {
//        return view('ring');
//    });
    Route::fallback(function () { return redirect('/'); });
};

$inRoute = [
    [
        'as' => 'm.',
        'domain' => (request()->getHost() === 'mannik.local') ?
            'mannik.local' :
//            юраманник.рф
            'xn--80aayihhat9j.xn--p1ai'
    ]
];

foreach ($inRoute as $i) {
    Route::group($i, $d);
}
