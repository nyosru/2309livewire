<?php

use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', \App\Livewire\Skidki\Index::class)->name('index');
};

$inRoute = [
    [
        'as' => 'skidki.',
        'domain' => (env(
            'APP_ENV',
            'local'
        ) == 'local' ? 'skidki.local'
            //IDN: скидки.сергейсб.рф
            : 'xn--d1ahbfc2b.xn--90adfbu3bff.xn--p1ai')
    ]
];

foreach ($inRoute as $i) {
    Route::group($i, $d);
}
