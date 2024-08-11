<?php

use Illuminate\Support\Facades\Route;

// Определение базового маршрута для Livewire
$d = function () {
    // Главная страница (список афиш)
    Route::get('/', \App\Livewire\Afisha\Index::class)->name('index');

    // Отображение списка афиш
    Route::get('/afisha/list', \App\Livewire\Afisha\PosterComponent::class)->name('list');

    // Форма добавления новой афиши
    Route::get('/afisha/add', \App\Livewire\Afisha\AddForm::class)->name('add');

    // Отображение подробностей одной афиши
    Route::get('/afisha/{posterId}', \App\Livewire\Afisha\PosterDetail::class)->name('detail');
};

// Определение домена и группы маршрутов
$inRoute = [
    [
        'as' => 'afisha.',
        'domain' => (env('APP_ENV', 'local') == 'local'
            ? 'afisha.local'
            //IDN: тюменскаяафиша.рф
            : 'xn--80aaarrjmj0bg3a3c0dua.xn--p1ai')
    ]
];

// Применение маршрутов
foreach ($inRoute as $i) {
    Route::group($i, $d);
}
