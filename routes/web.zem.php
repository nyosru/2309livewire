<?php

use App\Http\Controllers\Zem\Index;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::get('/', [Index::class, 'show'])->name('index');
    //    //    Route::fallback(function () { return redirect('/'); });
};

Route::group([
    'as' => 'zem.',
    'domain' => (env('APP_ENV', 'x') == 'local') ? 'zem.local' : 'xn--80aaaaahj0aehcc8fojz5e1i.xn--p1ai',
], $d);

