<?php

use App\Http\Controllers\StNews\ParseController;
use App\Services\ServiceController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Nyos\Msg;

$d = function () {
    Route::get('parse', [ParseController::class, 'go'])->name('parse-go');

    Route::get('parser', [ParseController::class, 'parse'])->name('parse');
    // nтащим каталоги
    Route::get('parsing/catalog', [ParseController::class, 'parseCatalog'])->name('parse.catalog');
    // список новостей с каталога
    Route::get('parsing/news', [ParseController::class, 'parseNewsListCatalog'])->name('parse.news_list');
    // грузим содержимое новостей
    Route::get('parsing/news_full', [ParseController::class, 'parseNewsFull'])->name('parse.news_list');


    Route::get('get-html', function () {
        // Создаем новый HTTP-клиент
        $client = new Client();
        $url = 'https://72.ru/text/world/2024/09/29/74144597/';
        // Выполняем GET-запрос к заданному URL
        $response = $client->request('GET', $url);
        // Проверяем, успешен ли запрос (код 200)
//            if ($response->getStatusCode() == 200) {
        // Получаем тело ответа
        $body = $response->getBody()->getContents();
        return response()->json([
            'getStatusCode' => $response->getStatusCode(),
            'body' => $body
        ]);
    });


    Route::get('download-photos-size', function () {
        $p = new \App\Services\StNews\NewsPhotoService();
        $storagePath = storage_path('app/public/' . $p->dir_for_photo); // Получаем путь к папке storage
        $result = ServiceController::getFolderSizeFull($storagePath);
        return response()->json($result);
    });

    Route::get('download-photos', function () {
//        Msg::sendTelegramm('api download-photos', null, 2);
        Artisan::call('StNews:news-download-photo');

        $p = new \App\Services\StNews\NewsPhotoService();
        $storagePath = storage_path('app/public/' . $p->dir_for_photo); // Получаем путь к папке storage
        $result = ServiceController::getFolderSizeFull($storagePath);
//        return response()->json($result);
        Msg::sendTelegramm('api download-photos (' . $result['mb'] . 'Mb)', null, 2);

        return response()->json(['message' => 'Photos download process initiated.']);
    });

    Route::get('auto-moderate', function () {
        Msg::sendTelegramm('api auto-moderate', null, 2);
        Artisan::call('StNews:news-auto-moderate');
        return response()->json(['message' => 'auto-moderate initiated.']);
    });

//    // Маршрут для главной страницы новостей
//    Route::get('/', StNewsIndex::class)->name('index');
//
////    // Маршрут для показа одной новости
////    Route::get('/news/{id}', StNewsShow::class)->name('show');
////
////    // Маршрут для создания новости

//    // Маршрут для страницы модерации новостей
//    Route::get('/moderation', StNewsModeration::class)->name('moderation');
//
//    // Маршрут для модерации конкретной новости
//    Route::get('/news/moderate/{id}', ModerateNews::class)->name('mod');

//    // Фоллбэк на случай отсутствия других маршрутов
//    Route::fallback(function () {
//        return redirect('/');
//    });

};

// Группировка маршрутов для домена
Route::group([
    'as' => 'stn.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'xn--80aeiaarcmpbmdnb6aghgm9nrc.xn--p1ai'
], $d);

// Группировка маршрутов для домена
Route::group([
    'as' => 'stn2.',
    'domain' => (env('APP_ENV', 'local') == 'local') ? 'stn.local' : 'stn.dev.php-cat.com'
], $d);
