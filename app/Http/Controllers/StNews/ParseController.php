<?php

namespace App\Http\Controllers\StNews;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\DateService;
use App\Models\StNews;
use App\Models\StNewsParsingCategory;
use App\Models\StNewsParsingSite;
use App\Models\StNewsPhoto;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ParseController extends Controller
{

    public static $host = 'http://web_scraper2:5047';
    public static $site_id = null;
    /**
     * сколько новостей сканить когда обогащаем новости
     * @var int
     */
    public static $count_scan_news_full = 1;


    public function __construct()
    {
        self::$count_scan_news_full = env('COUNT_SCAN_NEWS_FULL', 1);
    }

    /**
     * Добавление нового каталога, если он отсутствует
     *
     * @param string $category_name
     * @param string $category_url
     * @param int $site_id
     * @return array
     */
    public function addCatalogIfNotExists(string $category_name, string $category_url, StNewsParsingSite $site): array
    {
        $catalog_link = $this->createCatalogLink($site, $category_url);

        // Поиск существующего каталога
        $catalog = StNewsParsingCategory::
//            where('category_name', $category_name)
//            ->
        where('category_url', $catalog_link)
            ->where('site_id', $site->id)
            ->first();

        // Если каталог уже существует, возвращаем его
        if ($catalog) {
            return [
                'status' => 'ok',
                'message' => 'Каталог уже существует.',
                'catalog' => $catalog
            ];
        }
        // Если каталог не найден, создаём новый
        $newCatalog = StNewsParsingCategory::create([
            'site_id' => $site->id,
            'category_name' => $category_name,
            'category_url' => $catalog_link,
            'last_scan' => null,  // По умолчанию пустое время последнего сканирования
            'scan_status' => false // По умолчанию статус сканирования отключён
        ]);

        // Возвращаем новый элемент
        return [
            'status' => 'ok',
            'message' => 'Новый каталог успешно добавлен.',
            'catalog' => $newCatalog
        ];
    }

    /**
     * показ инфы о каталогах
     * @return array
     */
    public function scanCatalogInfo(): array
    {
        $return = [];

        // Общее количество каталогов
        $countAll = StNewsParsingCategory::count();

        // Количество каталогов с полем last_scan меньше чем за 24 часа или пустое
        $countRecentScans = StNewsParsingCategory::where(function ($query) {
            $query->where('last_scan', '<', now()->subDay())
                ->orWhereNull('last_scan');
        })->count();

        // Количество каталогов с полем scan_status = true
        $countScanStatusTrue = StNewsParsingCategory::whereScanStatus(true)->count();

        // Добавляем данные в массив $return
        $return['count_all'] = $countAll;
        $return['count_recent_scans'] = $countRecentScans;
        $return['count_scan_status_true'] = $countScanStatusTrue;

        return $return;
    }

    public function scanCatalog()
    {
        $res = StNewsParsingCategory::whereScanStatus(true)
            ->where(function ($query) {
                $query
//                    ->where('last_scan', '<', now()->subDay())
                    ->where('last_scan', '<', now()->subHour())
                    ->orWhereNull('last_scan');
            })
            ->whereHas('site', function ($query) {
                $query->where('scan_status', true); // Проверяем, что статус сканирования включён
            })
            ->limit(1)
            ->get();

        // Проверяем, если результат пустой, возвращаем false
        if ($res->isEmpty()) {
            return false;
        } else {
            foreach ($res as $catalog) {
                // обновляем время последнего сканирования
                if (1 == 2) {
//            if(1==1) {
                    $catalog->last_scan = now();
                    $catalog->save();
                }
                self::$site_id = $catalog->site_id;
            }

            return [
                'site' => $catalog->site,
                'catalog' => $res[0] ?? null,
            ];
        }
    }

    public function go()
    {
        $return = [
            'data' => [
                'scan' => '',
                'data' => []
            ]
        ];

        // формирование списка новостей для парсинга
        if (1 == 2) {
            // проверяем есть ли каталог для сканирования
            $r = $_REQUEST['skip_catalog'] ?? '';
            if (!empty($r)) {
                $scan_cat = false;
            } else {
                $scan_cat = $this->scanCatalog();
            }

//        dd($scan_cat);

            // получаем список новостей из каталога
            if (!empty($scan_cat)) {
                $data = $this->getParseRes(
                    self::$host . '/news_list?rand=' . time() . '&url=' . $scan_cat['catalog']->category_url
                );
//            dd($data);
                $add_items = $this->addNewsList($data['items'], $scan_cat['catalog']);
                dd($add_items);
//            dd([
//                $scan_cat,
//                $add_items
//                    ]
//            );
////            return $add_items;
            }
        }


//        // показ доп инфы
//        $r = $_REQUEST['show_info'] ?? '';
//        if ($r) {
//            $return['info']['catalog'] = $this->scanCatalogInfo();
//        }
//
//        if ($scan_cat) {
//            $return['data']['scan'] = 'catalog';
//            $return['data']['data'] = $scan_cat;
//        }


        // сканим новости
//        else {


        $a = $this->parseNewsFull();

        $r = $_REQUEST['show_info'] ?? false;
        if ($r) {
            $return['info']['scan_news_full'] = $this->parseNewsFullInfo();
        }

        $return['data']['scan'] = 'news';
        $return['data']['data'] = $a;
//        }

        return response()->json($return);

//        // получаем 1 новость
//        $uri0 = '/novosti/demografiya/lyubov-v-kazhdom-podarke-tyumentsy-mogut-podderzhat-babushek-i-dedushek/';
//        $uri = 'https://тюменскаяобласть.рф';
//        return $this->getParseRes(self::$host . '/parse_item?url=' . $uri . $uri0);
//
//        // получаем список новостей из каталога
//        $uri = 'https://тюменскаяобласть.рф/novosti/demografiya/';
//        return $this->getParseRes(self::$host . '/news_list?rand=' . time() . '&url=' . $uri);
//
//        // получаем каталоги
//        $uri = 'https://тюменскаяобласть.рф/novosti/';
//        return $this->getParseRes(self::$host . '/catalogs?url=' . $uri);


//        return json_encode([1=>2]);
//        return $this->getParseRes('http://'.$_SERVER['HTTP_HOST'].':5017/scrape?url=https://тюменскаяобласть.рф/novosti/');
//        return $this->getParseRes('http://parser22.local:5017/catalogs?url=https://тюменскаяобласть.рф/novosti/');


//        return $this->getParseRes('http://web_scraper:5017/catalogs?url=https://тюменскаяобласть.рф/novosti/');
//        return $this->getParseRes('http://web_scraper:5017/scrape?url=https://тюменскаяобласть.рф/novosti/');
    }


    public function getParseRes(
        $url = 'http://web_scraper:5047/scrape?url=https://xn--80aacozicjl1agbl4lraw.xn--p1ai/novosti/',
        $param = []
    ) {
        // URL, который необходимо запросить
//        $url = 'http://web_scraper:5007/scrape?url=https://xn--80aacozicjl1agbl4lraw.xn--p1ai/novosti/';
//dd($html);
        // Создаем новый HTTP-клиент
//        $client = new Client();

        try {
            // Выполняем GET-запрос к заданному URL
//            $response = $client->request('GET', $url.( !empty($html) ? $html : '' ));
//            $response = $client->request('POST', $url , ['html' => ( !empty($html) ? $html : '' ) ]);
//            $response = $client->request('POST', $url , $param );

//            $response = Http::timeout(2)->post($url, $param)->json();
            $response = Http::asForm()->post($url, $param)->json();
//            $response = Http::timeout(10)->get($url, $param)->json();
//            $response = Http::get($url, $param)->json();

            dd($response);
//            dd([$response, $url, $param]);

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
     * Сканируем каталог на новости, получение списка новостей без содержания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveNewNewsList($list, StNewsParsingSite $site)
    {
        $res = [];
        $add_db = [];
        $check = [];
        foreach ($list as $n) {
            try {
                // Проверяем, существует ли уже новость с таким источником
                $ee = StNews::whereSource($site->site_url .$n->link)->firstOrFail();
            } catch (\Exception $e) {
                // Если новость не найдена, добавляем её
//                $get['msg'][] = $e->getMessage();

                $in = new StNews();
                $in->site_id = $site->id;
                $in->title = $n->title;
                $in->summary = $n->anons;
                $in->source = $site->site_url . $n->link;

                $d = DateService::convertDateTime($n->date);
                $in->published_at = date('Y-m-d', strtotime($d));

                $in->moderation_required = 1;
//                    $get['msg'][] = $in->save();
                $in->save();
                $res[] = $in->id;

                // Добавляем фото новости с доменом (раскомментировать, если нужно)
                // $p = new StNewsPhoto();
                // $p->st_news_id = $in->id;
                // $p->image_path = 'https://' . $domain . $n['image'];  // Добавляем домен к пути изображения
                // $get['msg'][] = 'save photo:' . ($p->save() ? 1 : 0);
            }
        }
        return $res;
    }

    /**
     * Сканируем каталог на новости, получение списка новостей без содержания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function parseNewsListCatalog(Request $request)
    {
        try {
            // Получаем каталог для парсинга новостей только если статус сканирования включен
            $parsingCatalog0 = StNewsParsingCategory::whereNotNull('category_url')
                ->where(function ($query) {
                    $query->where('last_scan', '<', now()->subHour())
                        ->orWhereNull('last_scan');
                })
                ->whereHas('site', function ($query) {
                    $query->where('scan_status', true); // Проверяем, что статус сканирования включён
                })
                ->orderBy('last_scan')
                ->firstOrFail();

            // Обновляем время последнего сканирования
//            $parsingCatalog0->last_scan = now();
//            $parsingCatalog0->save();

            if (strpos(strtolower($parsingCatalog0->category_url), 'vsluh.ru') !== false) {
                $go = ['type' => 'parse_vsluh_news_list', 'url' => $parsingCatalog0->category_url];
//                $url = 'http://parser_service:5047/news_list?url=' . $parsingCatalog0->category_url;
//                $url = 'http://parser_service:5047/get_html?' . http_build_query($go);
                $url = 'http://web_scraper2:5047/get_html?' . http_build_query($go);
                $json = file_get_contents($url);
                $list = json_decode($json);
                $add_db_res = $this->saveNewNewsList($list, $parsingCatalog0->site);
                return response()->json(['url' => $url, 'data' => $list, 'add_db_res' => $add_db_res]);
//                echo $url;
            }


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

                        // Добавляем фото новости с доменом (раскомментировать, если нужно)
                        // $p = new StNewsPhoto();
                        // $p->st_news_id = $in->id;
                        // $p->image_path = 'https://' . $domain . $n['image'];  // Добавляем домен к пути изображения
                        // $get['msg'][] = 'save photo:' . ($p->save() ? 1 : 0);
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


    /**
     * получить ссылку на каталог
     * @param StNewsParsingSite $site
     * @param $url
     * @return string
     */
    static function createCatalogLink(StNewsParsingSite $site, $url): string
    {
        if ($site->id == 2) {
            // Удаляем слеш в конце, если он есть
            $trimmedUrl = rtrim($url, '/');
            // Извлекаем последнее слово с помощью basename
            return $site->site_url . '/text/?rubric=' . basename($trimmedUrl);
        } else {
            return $site->site_url . $url;
        }
    }


    function addNewsList($items, StNewsParsingCategory $cat)
    {
        $get = [
            __FUNCTION__,
            $items,
            $cat
        ];

        foreach ($items as $n) {
            $get[] = $n;

            try {
                // Проверяем, существует ли уже новость с таким источником
                $ee = StNews::whereSource($n['source'])->firstOrFail();
//                $get[] = 'есть такая';
            } catch (\Exception $e) {
//                $get[] = 'нет такая';

                if ($cat->site->id == 2) {
                    $catalog_search = $this->addCatalogIfNotExists($n['category'], $n['category_link'], $cat->site);
                } else {
                    $catalog_search = $cat;
                }

//                $get[] = $catalog_search;

                if (empty($catalog_search['catalog'])) {
                    continue;
                }

                // Если новость не найдена, добавляем её
                $in = new StNews();
                $in->site_id = $cat->site_id;
                $in->cat_id = $catalog_search['catalog']->id;
                $in->title = $n['title'];
                $in->source = $n['source'];
                $in->published_at = date('Y-m-d H:i:s', strtotime($n['date']));
                $in->moderation_required = 1;
                $in->save();
                $get[$in->id] = $in->title;

//                        // Добавляем фото новости с доменом
//                        $p = new StNewsPhoto();
//                        $p->st_news_id = $in->id;
//                        $p->image_path = 'https://' . $domain . $n['image'];  // Добавляем домен к пути изображения
//                        $get['msg'][] = 'save photo:' . ($p->save() ? 1 : 0);
            }
        }
        return $get;
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

    public function parseNewsFullInfo(): array
    {
        $return = [];

        // Общее количество
        $countAll = StNews::count();

        $countContentNull = StNews::whereNull('content')->count();

//        // Количество каталогов с полем last_scan меньше чем за 24 часа или пустое
//        $countRecentScans = StNews::where(function ($query) {
//            $query->where('last_scan', '<', now()->subDay())
//                ->orWhereNull('last_scan');
//        })->count();
//
//        // Количество каталогов с полем scan_status = true
//        $countScanStatusTrue = StNewsParsingCategory::whereScanStatus(true)->count();

        // Добавляем данные в массив $return
        $return['count_all'] = $countAll;
        $return['count_content_null'] = $countContentNull;
//        $return['full_news']['count_scan_status_true'] = $countScanStatusTrue;

        return $return;
    }

    public function parseNewsFull()
    {
        $return = [];

        try {
            // Получаем каталог для парсинга новостей
            $parsingCatalog0 = StNews::with('site', 'photos')
                ->where('site_id', '=', 2)
                ->whereNull('content')
//                ->where(function ($query) {
//                    $query->where('last_scan', '<', now()->subHour())
//                        ->orWhereNull('last_scan');
//                })
                ->orderBy('updated_at')
//                ->firstOrFail()
                ->limit(self::$count_scan_news_full);
//                ->limit(1);

            //dd($parsingCatalog0->get());

//            // Получаем домен из URL
//            $urlParts = parse_url($parsingCatalog0->category_url);
//            $domain = $urlParts['host'];

            $parsingCatalog = $parsingCatalog0->get();

            $return['in'] = [];
            foreach ($parsingCatalog as $i) {
                $source_url = $i->site->site_url . $i->source;
//                dd($i->site->site_url.$i->source);

                $return['in'][] = $i;
//                $return['i'][] = $i->site->site_name;
//                echo $i->source;

                $param = [];

                if ($i->site->id == 2) {
                    $client = new Client();
                    $response = $client->request('GET', $source_url);
                    $param['html'] =
                    $html = $response->getBody()->getContents();
//                    $param['html'] =
//                    $html = '<html>111</html>';
                }
                $param['url'] = $source_url;
//                $url = self::$host . '/parse_item?url=' . $source_url;
                $url = self::$host . '/parse_item';
                $get = $this->getParseRes($url, $param);

                dd([$url, $get, $html]);

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
//            return response()->json($return);
            return $return;
//            return response()->json([
//                'parsingCatalog' => $parsingCatalog0,
//                'data' => $get
//            ], 200);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'e' => $e->getTrace()
            ];
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


    /**
     * Проверить новости и автоматически проставить поле moderation
     */
    public function autoModerateNews()
    {
        // Получаем новости, у которых moderation пустой
        $newsWithoutModeration = StNews::whereNull('moderation')
            ->whereHas('site', function ($query) {
                // Проверяем, чтобы у сайта было значение в time_to_auto_publish
                $query->whereNotNull('time_to_auto_publish');
            })
            ->get();

        foreach ($newsWithoutModeration as $news) {
            // Вычисляем время автопубликации
            $publishTimeLimit = Carbon::parse($news->created_at)
                ->addMinutes($news->site->time_to_auto_publish);

            // Если текущее время больше времени автопубликации, то обновляем поле moderation
            if (Carbon::now()->greaterThanOrEqualTo($publishTimeLimit)) {
                $news->update(['moderation' => true]);
            }
        }
    }

}
