<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

$routes = function () {

    Route::get('/', \App\Livewire\Phpcatru\IndexComponent::class)->name('index');
    Route::get('/services', \App\Livewire\Phpcatru\ServicesList::class)->name('services');
    Route::get('/service/{slug}', \App\Livewire\Phpcatru\ServiceDetail::class)->name('service.detail');
    Route::get('/cases', \App\Livewire\Phpcatru\Cases::class)->name('cases');
    Route::get('/blog', \App\Livewire\Phpcatru\BlogList::class)->name('blog');
    Route::get('/blog/{slug}', \App\Livewire\Phpcatru\BlogShow::class)->name('blog.show');
    Route::get('/contacts', \App\Livewire\Phpcatru\ContactForm::class)->name('contacts');

    Route::fallback(function () {
        return redirect('/');
    });

};

$domain = App::environment('local') ? 'phpcatru.local' : 'php-cat.ru';

Route::group([
    'as' => 'phpcat.',
    'domain' => $domain
], $routes);

