<?php

use Illuminate\Support\Facades\Route;

$gerchikDomains = app()->environment('local', 'testing')
    ? ['gerchick.local', 'gerchik.local']
    : ['xn--c1aeji2a6b.xn--p1ai'];

foreach ($gerchikDomains as $index => $domain) {
    Route::domain($domain)->group(function () use ($index) {
        Route::view('/', 'gerchik.index')->name($index === 0 ? 'gerchik.home' : 'gerchik.local.alias');
    });
}
