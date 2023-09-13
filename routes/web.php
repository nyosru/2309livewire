<?php

use App\Livewire\Phpcat\News;
use App\Livewire\ShowPosts;
use App\Livewire\ShowPostsSearch;
use App\Livewire\ShowRoom;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', ShowPosts::class)->name('index');

// Route::get('/', ShowPosts::class)->name('index');
// Route::get('/p1', ShowPosts::class)->name('p1');
// Route::get('/p2', ShowPostsSearch::class)->name('p2');
// Route::get('/p3', ShowRoom::class)->name('p3');

$d = function () {
// Route::get('/', function () { return view('phpcat.index'); });
Route::get('/', News::class)->name('index');
Route::get('news', News::class)->name('news');
Route::get('torrent', News::class)->name('torrent');
Route::get('services', News::class)->name('services');
Route::get('money', News::class)->name('money');
// Route::get('{.*}', News::class)->name('other');
Route::fallback(function () { return redirect('/'); });
};
Route::group([
//    'as' => 'phpcat.',
    'domain' => 'phpcat.local'
], $d);
Route::group([
    'as' => 'phpcat.',
    'domain' => 'livewire.php-cat.com'
], $d);
