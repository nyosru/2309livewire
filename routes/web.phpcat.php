<?php

use App\Http\Controllers\Phpcat\MsgSendController;
use App\Http\Controllers\RedirectController;
use App\Livewire\Phpcat\Develop;
use App\Livewire\Phpcat\News;
use Illuminate\Support\Facades\Route;
use App\Livewire\Phpcat\VkFriends;

$d = function () {
    Route::get('/', News::class)->name('index');
    Route::get('/develop/{item}', Develop::class)->name('develop');
    Route::any('/msg', MsgSendController::class)->name('msg.send');

//	Route::any('/f', \App\Livewire\Phpcat\VkFriends::class)->name('vk_friends');
//	Route::any('/f/{code}', \App\Livewire\Phpcat\VkFriends::class)->name('vk_friends3');

//	Route::get('/f', function () {
//		return view('pages.friends', ['component' => new VkFriends()]);
//	});
//
////	Route::get('/callback', \App\Livewire\Phpcat\VkFriends::class)->name('vk_friends2');
//	Route::get('/callback', function (\Illuminate\Http\Request $request) {
////		return app(\App\Livewire\Phpcat\VkFriends::class)->getAccessToken($request->code);
//		$vkFriendsComponent = app(\App\Livewire\Phpcat\VkFriends::class);
//		$vkFriendsComponent->getAccessToken($request->code);
//
//		// Перенаправляем пользователя обратно на главную страницу
//		return redirect('/f');
//
//	});

	Route::get('/f', function () {
		return view('pages.friends', ['component' => new VkFriends()]);
	});
//	Route::get('/callback', function (\Illuminate\Http\Request $request) {
//		$vkFriendsComponent = app(VkFriends::class);
//		$vkFriendsComponent->getAccessToken($request->code);
//
//		return redirect('/f');
//	});
	Route::get('/callback', function (\Illuminate\Http\Request $request) {
		session(['auth_code' => $request->code]);
		return redirect('/f');
	});


//	Route::get('/callback', function (\Illuminate\Http\Request $request) {
//		$e = new \App\Livewire\Phpcat\VkFriends();
////		return $e->getAccessToken($request->code);
//		$e->getAccessToken($request->code);
//		return response()->json($e->getFriends());
//	});

//    Route::get('services', News::class)->name('services');
//    // Route::get('/', function () { return view('phpcat.index'); });
////    Route::get('news', News::class)->name('news');
////    Route::get('torrent', News::class)->name('torrent');
////    Route::get('money', News::class)->name('money');
//    // Route::get('{.*}', News::class)->name('other');
    Route::get('go/{get}', RedirectController::class)->name('redirect');

    Route::fallback(function () {
        return redirect('/');
    });
};

Route::group([
    'as' => 'phpcat.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'php-cat.local' : 'php-cat.com'
], $d);

Route::group([
    'as' => 'phpcat1.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? '1.php-cat.local' : '1.php-cat.com'
], $d);

