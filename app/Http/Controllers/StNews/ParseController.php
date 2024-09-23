<?php

namespace App\Http\Controllers\StNews;

use App\Http\Controllers\Controller;
use App\Models\StNews;
use App\Models\StNewsParsingCategory;
use App\Models\StNewsParsingSite;
use App\Models\StNewsPhoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ParseController extends Controller
{

    public function getParseRes(
        $url = 'http://web_scraper:5007/scrape?url=https://xn--80aacozicjl1agbl4lraw.xn--p1ai/novosti/'
    ) {
        // URL, который необходимо запросить
//        $url = 'http://web_scraper:5007/scrape?url=https://xn--80aacozicjl1agbl4lraw.xn--p1ai/novosti/';

        // Создаем новый HTTP-клиент
        $client = new Client();

        try {
            // Выполняем GET-запрос к заданному URL
            $response = $client->request('GET', $url);

            // Проверяем, успешен ли запрос (код 200)
            if ($response->getStatusCode() == 200) {
                // Получаем тело ответа
                $body = $response->getBody()->getContents();

                // Преобразуем его в массив, если это JSON-ответ
                $data = json_decode($body, true);
                $data['result'] = 1;
                // Возвращаем JSON-ответ
                return $data;
            } else {
                // В случае ошибки возвращаем сообщение с кодом ошибки
                return ['error' => 'Request failed with status code: ' . $response->getStatusCode()];
            }
        } catch (\Exception $e) {
            // Обрабатываем исключения и возвращаем сообщение об ошибке
            return ['error' => $e->getMessage()];
        }
    }

    public function parseCatalog(Request $request)
    {
        try {
            // Получаем сайт, у которого категория для парсинга не пустая, и дата последнего сканирования либо пустая, либо старше недели
            $parsingSite0 = StNewsParsingSite::whereNotNull('category_parsing_url')
                ->where(function ($query) {
                    $query->where('last_catalog_scan', '<', now()->subWeek())
                        ->orWhereNull('last_catalog_scan');
                })
                ->firstOrFail();

            // Преобразуем выборку в коллекцию
            $parsingSite = $parsingSite0->get();

            if ($parsingSite) {
                // Обновляем дату последнего сканирования каталога
                $parsingSite0->last_catalog_scan = now();
                $parsingSite0->save();

                // Формируем URL для парсера
                $url = 'http://parser_service:5047/catalogs?url=' . $parsingSite[0]->category_parsing_url;
                $get = $this->getParseRes($url);

                if (!empty($get['catalogs'])) {
                    $cat_in = [];

                    foreach ($get['catalogs'] as $v) {
                        // Проверяем, существует ли уже данный каталог
                        try {
                            $e = StNewsParsingCategory::where('category_url', $v['link'])
                                ->where('site_id', $parsingSite[0]->id)
                                ->firstOrFail()->get();
                        } catch (\Exception $e) {
                            // Если каталог не найден, добавляем его
                            $cat_in[] = [
                                'site_id' => $parsingSite[0]->id,
                                'category_name' => $v['title'],
                                'category_url' => $parsingSite[0]->site_url . $v['link'],
                            ];
                        }
                    }

                    if (!empty($cat_in)) {
                        // Добавляем временные метки вручную
                        foreach ($cat_in as &$cat) {
                            $cat['created_at'] = now();
                            $cat['updated_at'] = now();
                        }

                        $get['db'][] = $cat_in;
                        $status = StNewsParsingCategory::insert($cat_in);
                    }
                }

                return response()->json(['data' => $get, 'new_cat_add' => $status ?? 'skip'], 200);
            } else {
                $get = 'no';
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * сканируем каталог на новости, получение списка новостей без содержания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parseNewsListCatalog(Request $request)
    {
        try {
            // Получаем каталог для парсинга новостей
            $parsingCatalog0 = StNewsParsingCategory::whereNotNull('category_url')
                ->where(function ($query) {
                    $query->where('last_scan', '<', now()->subHour())
                        ->orWhereNull('last_scan');
                })
                ->orderBy('last_scan')
                ->firstOrFail();

            // Обновляем время последнего сканирования
            $parsingCatalog0->last_scan = now();
            $parsingCatalog0->save();

            // Получаем домен из URL
            $urlParts = parse_url($parsingCatalog0->category_url);
            $domain = $urlParts['host'];

            // Формируем URL для парсера
            $url = 'http://parser_service:5047/news_list?url=' . $parsingCatalog0->category_url;
            $get = $this->getParseRes($url);

            if (!empty($get['news'])) {
                $add_db = [];
                $check = [];
                foreach ($get['news'] as $n) {
                    try {
                        // Проверяем, существует ли уже новость с таким источником
                        $ee = StNews::whereSource($n['source'])->firstOrFail();
                    } catch (\Exception $e) {
                        // Если новость не найдена, добавляем её
                        $get['msg'][] = $e->getMessage();

                        $in = new StNews();
                        $in->site_id = $parsingCatalog0->site_id;
                        $in->title = $n['title'];
                        $in->source = $n['source'];
                        $in->published_at = date('Y-m-d', strtotime($n['date']));
                        $in->moderation_required = 1;
                        $get['msg'][] = $in->save();
                        $get['msg'][] = $in->id;

//                        // Добавляем фото новости с доменом
//                        $p = new StNewsPhoto();
//                        $p->st_news_id = $in->id;
//                        $p->image_path = 'https://' . $domain . $n['image'];  // Добавляем домен к пути изображения
//                        $get['msg'][] = 'save photo:' . ($p->save() ? 1 : 0);
                    }
                }
            }

            return response()->json([
                'parsingCatalog' => $parsingCatalog0,
                'data' => $get
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function removePhotoCredit($content)
    {
        // Регулярное выражение для поиска строки, начинающейся с "Фото:" и любых символов после нее
        $pattern = '/Фото:.*$/m';

        // Замена найденной строки на пустую строку
        $content = preg_replace($pattern, '', $content);

        // Возвращаем измененный контент
        return $content;
    }

    public function parseNewsFull(Request $request)
    {
        $return = [];

        try {
            // Получаем каталог для парсинга новостей
            $parsingCatalog0 = StNews::with('site', 'photos')->whereNull('content')
//                ->where(function ($query) {
//                    $query->where('last_scan', '<', now()->subHour())
//                        ->orWhereNull('last_scan');
//                })
                ->orderBy('updated_at')
//                ->firstOrFail()
                ->limit(5);
//                ->limit(1);


            //dd($parsingCatalog0->site->site_name);
//            dd($parsingCatalog0->site);
//            dd($parsingCatalog0->get());

//            // Получаем домен из URL
//            $urlParts = parse_url($parsingCatalog0->category_url);
//            $domain = $urlParts['host'];

            $parsingCatalog = $parsingCatalog0->get();
            $return['in'] = [];
            foreach ($parsingCatalog as $i) {
                $return['in'][] = $i;
//                $return['i'][] = $i->site->site_name;
//                echo $i->source;

                $url = 'http://parser_service:5047/parse_item?url=https://' . $i->site->site_name . $i->source;
                $get = $this->getParseRes($url);
                $return['in'][] = '$get';
                $return['in'][] = $get;
//                $return['in'][] = $get['news_item'];
//                $return['in'][] = $get['news_item']['content'];
//                $return['in'][] = $this->removePhotoCredit($get['news_item']['content']);
//                content
//                echo '<Br/>';
//                echo 'url:' . $url;


//                var_dump($get['news_item']);
//                var_dump($get['news_item']['site']);

                if (1 == 1) {
                    $i->content = $this->removePhotoCredit($get['news_item']['content']);
                    $i->updated_at = now();
                    $i->save();

                    // добавляем фотки
                    if (!empty($get['news_item']['image'])) {
                        $this->saveImgToNews(
                            $i->id,
                            $get['news_item']['image'],
                            $i->site->site_name
                        );
//                        $return['in'][] = '$get[news_item][site]->site_name';
//                        $return['in'][] = $get['news_item']['site']->site_name;
//                        $return['in'][] = $get['news_item']['site']['site_name'];
                    }
                }


//                echo '<Br/>';
//                echo '<Br/>';
            }

//            dd($parsingCatalog0);
//            $return[] = $parsingCatalog0;
//
//            // Обновляем время последнего сканирования
//            $parsingCatalog0->last_scan = now();
//            $parsingCatalog0->save();
//
//            // Получаем домен из URL
//            $urlParts = parse_url($parsingCatalog0->category_url);
//            $domain = $urlParts['host'];
//
//            // Формируем URL для парсера
//            $url = 'http://parser_service:5047/news_list?url=' . $parsingCatalog0->category_url;
//            $get = $this->getParseRes($url);
//
//            if (!empty($get['news'])) {
//                $add_db = [];
//                $check = [];
//                foreach ($get['news'] as $n) {
//                    try {
//                        // Проверяем, существует ли уже новость с таким источником
//                        $ee = StNews::whereSource($n['source'])->firstOrFail();
//                    } catch (\Exception $e) {
//                        // Если новость не найдена, добавляем её
//                        $get['msg'][] = $e->getMessage();
//
//                        $in = new StNews();
//                        $in->title = $n['title'];
//                        $in->source = $n['source'];
//                        $in->moderation_required = 1;
//                        $get['msg'][] = $in->save();
//                        $get['msg'][] = $in->id;
//
//                        // Добавляем фото новости с доменом
//                        $p = new StNewsPhoto();
//                        $p->st_news_id = $in->id;
//                        $p->image_path = 'https://' . $domain . $n['image'];  // Добавляем домен к пути изображения
//                        $get['msg'][] = 'save photo:' . ($p->save() ? 1 : 0);
//                    }
//                }
//            }
//            $return['ss'] = 1;
            return response()->json($return);
//            return response()->json([
//                'parsingCatalog' => $parsingCatalog0,
//                'data' => $get
//            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'e' => $e->getTrace()
            ], 500);
        }
    }

    public function saveImgToNews(int $news_id, array $images, $domain = '')
    {
        $insertData = [];

        foreach ($images as $imagePath) {
            if (!empty($imagePath)) {
                $insertData[] = [
                    'st_news_id' => $news_id,
                    // ID новости
                    'image_path' => (!strpos(strtolower($imagePath), $domain) ? 'https://' . $domain : '') . $imagePath,
                    // Путь к изображению
                    'created_at' => now(),
                    // Время создания
                    'updated_at' => now(),
                    // Время обновления
                ];
            }
        }

        StNewsPhoto::insert($insertData);       // Вставляем все данные разом
    }

    public function parse(Request $request)
    {
        try {
            $url = 'http://web_scraper:5007/scrape?url=https://xn--80aacozicjl1agbl4lraw.xn--p1ai/novosti/';
            $newsItems = $this->getParseRes($url)['news'];

            $res = [];

            foreach ($newsItems as $item) {
                // Создаем новый объект модели StNews
                $news = new StNews();

                // Заполняем поля модели
                $news->title = $item['title'] ?? null;
//                $news->summary = $item['summary'] ?? null;
//                $news->content = $item['content'] ?? null;
                $news->source = $item['source'] ?? null;
                $news->moderation_required = 1;

                // Преобразуем дату публикации в нужный формат и сохраняем
                $publishedAt = Carbon::parse($item['date'])->format('Y-m-d H:i:s');
                $news->published_at = $publishedAt;

                // Устанавливаем текущую дату и время как created_at
                $news->created_at = Carbon::now();

                // Сохраняем объект в базу данных
                $res[] = $news->save();
            }

            // Возвращаем JSON-ответ с данными
            return response()->json(['status' => 'success', 'add_in_db' => $res, 'data' => $newsItems]);
        } catch (\Exception $e) {
            // Обрабатываем исключения и возвращаем сообщение об ошибке
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
