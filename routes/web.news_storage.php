<?php

use App\Livewire\NewsStorage;
use App\Livewire\StNews\Show as StNewsShow;
use App\Http\Controllers\NewsStorage\AdminAuthController;
use App\Http\Controllers\NewsStorage\AdminController;
use App\Http\Middleware\EnsureNewsStorageAdministrator;
use App\Http\Middleware\EnsureNewsStorageModerator;
use App\Livewire\StNews\ModerateNews;
use Illuminate\Support\Facades\Route;

$d = function () {
    Route::view('/', 'livewire.news-storage.feed')->name('index');
    Route::redirect('/manage', '/admin/news')->name('manage');
    Route::get('/api-docs', NewsStorage\ApiDocs::class)->name('api-docs');
    Route::get('/news/{id}', NewsStorage\Show::class)->name('show');
    Route::get('/articles/{id}', StNewsShow::class)->whereNumber('id')->name('stn-show');
    Route::get('/storage-news/{id}', NewsStorage\Show::class)->whereNumber('id')->name('feed-storage-show');

    Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::get('/admin/auth/master', [AdminAuthController::class, 'redirect'])->middleware('throttle:10,1')->name('admin.master');
    Route::get('/admin/auth/master/callback', [AdminAuthController::class, 'callback'])->middleware('throttle:10,1')->name('admin.master.callback');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::prefix('admin')->middleware(EnsureNewsStorageModerator::class)->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/moderation', ModerateNews::class)->name('admin.moderation');

        Route::middleware(EnsureNewsStorageAdministrator::class)->group(function () {
            Route::get('/news', NewsStorage\Index::class)->name('admin.news');
            Route::get('/topics', NewsStorage\Topics::class)->name('admin.topics');
            Route::redirect('/stn-news', '/admin/news')->name('admin.stn-news');
            Route::put('/access/{administrator}', [AdminController::class, 'updateAccess'])->name('admin.access.update');
        });
    });

    Route::fallback(function () {
        return redirect('/');
    });
};

// news.local — локальный адрес, остальные — публичные адреса той же ленты.
// IDN указывается в punycode: именно так домен приходит в HTTP Host.
foreach ([
    'news.local',
    'stn.news',
    'news.api.php-cat.ru',
    'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai', // самыетюменскиеновости.рф
] as $index => $domain) {
    Route::group([
        // Сохраняем существующие имена маршрутов для основного домена.
        'as' => $index === 0 ? 'news-storage.' : "news-storage.alias{$index}.",
        'domain' => $domain,
    ], $d);
}
