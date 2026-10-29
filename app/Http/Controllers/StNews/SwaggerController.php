<?php

namespace App\Http\Controllers\StNews;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * Swagger/OpenAPI-документация для API «Самых Тюменских Новостей».
 *
 * Страница-хаб («лагерь») с переключателем тем API справа наверху.
 * Каждая тема — это отдельная OpenAPI-спецификация. Пока реализована одна: stn.
 */
class SwaggerController extends Controller
{
    /**
     * Страница Swagger с селектором тем (справа наверху).
     */
    public function index()
    {
        // Темы API: ключ => [заголовок, url спецификации]. Добавляются сюда новые темы.
        $themes = [
            'stn' => [
                'title' => 'Самые Тюменские Новости',
                'url' => url('/api/openapi/stn'),
            ],
        ];

        $active = request('theme', 'stn');
        if (! isset($themes[$active])) {
            $active = 'stn';
        }

        return view('st_news.swagger.docs', [
            'themes' => $themes,
            'active' => $active,
        ]);
    }

    /**
     * OpenAPI-спецификация темы (JSON).
     */
    public function spec(string $theme): JsonResponse
    {
        return response()->json($this->specStn());
    }

    /**
     * OpenAPI 3.0.3 для CRUD-API новостей (/api/stn/news).
     * Пути даны относительно servers.base = <host>/api/stn.
     */
    protected function specStn(): array
    {
        return [
            'openapi' => '3.0.3',
            'info' => [
                'title' => 'Самые Тюменские Новости — API',
                'description' => 'CRUD-API для управления новостями: список, показ, создание, редактирование, удаление, прикрепление медиа. '
                    . 'Чтение (index/show) — открыто; запись (store/update/delete/media) — по заголовку `X-STN-Api-Key`.',
                'version' => '1.0.0',
            ],
            'servers' => [
                ['url' => rtrim(request()->getSchemeAndHttpHost().'/api/stn', '/'), 'description' => 'Текущий домен'],
            ],
            'tags' => [
                ['name' => 'News', 'description' => 'Новости'],
            ],
            'components' => [
                'securitySchemes' => [
                    'ApiKey' => [
                        'type' => 'apiKey',
                        'in' => 'header',
                        'name' => 'X-STN-Api-Key',
                        'description' => 'Ключ доступа к записи. Указывается в заголовке запроса.',
                    ],
                ],
                'schemas' => [
                    'News' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer', 'example' => 2],
                            'title' => ['type' => 'string', 'example' => 'Заголовок новости'],
                            'summary' => ['type' => ['string', 'null']],
                            'content' => ['type' => 'string'],
                            'source' => ['type' => ['string', 'null'], 'format' => 'uri'],
                            'source_domain' => ['type' => ['string', 'null']],
                            'published_at' => ['type' => ['string', 'null'], 'format' => 'date-time'],
                            'cover_photo_id' => ['type' => ['integer', 'null']],
                            'created_at' => ['type' => 'string', 'format' => 'date-time'],
                            'updated_at' => ['type' => 'string', 'format' => 'date-time'],
                            'deleted_at' => ['type' => ['string', 'null'], 'format' => 'date-time'],
                            'media' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/Media']],
                            'cover_photo' => ['$ref' => '#/components/schemas/Media'],
                        ],
                    ],
                    'Media' => [
                        'type' => 'object',
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'st_news_id' => ['type' => 'integer'],
                            'media_type' => ['type' => 'string', 'enum' => ['photo', 'video']],
                            'url' => ['type' => ['string', 'null'], 'description' => 'Готовый URL (для фото — локальная копия или исходник).'],
                            'is_photo' => ['type' => 'boolean'],
                            'is_video' => ['type' => 'boolean'],
                            'photo_path' => ['type' => ['string', 'null']],
                            'video_url' => ['type' => ['string', 'null']],
                            'alt' => ['type' => ['string', 'null']],
                        ],
                    ],
                    'NewsInput' => [
                        'type' => 'object',
                        'required' => ['title', 'content'],
                        'properties' => [
                            'title' => ['type' => 'string', 'maxLength' => 255, 'example' => 'Заголовок новости'],
                            'content' => ['type' => 'string', 'example' => 'Полный текст новости.'],
                            'summary' => ['type' => 'string', 'maxLength' => 1000, 'description' => 'Краткое описание (до 1000 символов).'],
                            'source' => ['type' => 'string', 'format' => 'uri', 'maxLength' => 500],
                            'cat_id' => ['type' => ['integer', 'null']],
                            'site_id' => ['type' => ['integer', 'null']],
                            'cover_photo_id' => ['type' => ['integer', 'null']],
                            'photos' => ['type' => 'array', 'description' => 'JSON-фото: [{url, alt, sort}]', 'items' => ['type' => 'object']],
                            'videos' => ['type' => 'array', 'description' => 'JSON-видео: [{url, provider, title, duration, alt, sort}]', 'items' => ['type' => 'object']],
                        ],
                    ],
                ],
            ],
            'paths' => [
                '/news' => [
                    'get' => [
                        'tags' => ['News'],
                        'summary' => 'Список новостей',
                        'description' => 'Последние новости. По умолчанию — только опубликованные (published_at задан).',
                        'parameters' => [
                            ['name' => 'limit', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'default' => 20, 'maximum' => 100], 'description' => 'Кол-во (1–100).'],
                            ['name' => 'all', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'boolean'], 'description' => 'all=1 — всё, включая неопубликованные (для администратора).'],
                        ],
                        'responses' => [
                            '200' => [
                                'description' => 'Пагинированный список',
                                'content' => ['application/json' => ['schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'data' => ['type' => 'array', 'items' => ['$ref' => '#/components/schemas/News']],
                                        'total' => ['type' => 'integer'],
                                        'per_page' => ['type' => 'integer'],
                                        'current_page' => ['type' => 'integer'],
                                    ],
                                ]]],
                            ],
                        ],
                    ],
                    'post' => [
                        'tags' => ['News'],
                        'summary' => 'Создать новость',
                        'security' => [['ApiKey' => []]],
                        'requestBody' => [
                            'required' => true,
                            'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/NewsInput']]],
                        ],
                        'responses' => [
                            '201' => [
                                'description' => 'Создана (всегда черновик: published_at = null, видимость — ручная)',
                                'content' => ['application/json' => ['schema' => [
                                    'type' => 'object',
                                    'properties' => ['message' => ['type' => 'string'], 'news' => ['$ref' => '#/components/schemas/News']],
                                ]]],
                            ],
                        ],
                    ],
                ],
                '/news/{news}' => [
                    'get' => [
                        'tags' => ['News'],
                        'summary' => 'Показать одну новость',
                        'parameters' => [
                            ['name' => 'news', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer'], 'description' => 'ID новости.'],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Новость с медиа и обложкой', 'content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/News']]]],
                            '404' => ['description' => 'Не найдена'],
                        ],
                    ],
                    'put' => [
                        'tags' => ['News'],
                        'summary' => 'Обновить новость',
                        'security' => [['ApiKey' => []]],
                        'parameters' => [
                            ['name' => 'news', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'requestBody' => ['content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/NewsInput']]]],
                        'responses' => ['200' => ['description' => 'Обновлена', 'content' => ['application/json' => ['schema' => ['type' => 'object', 'properties' => ['message' => ['type' => 'string'], 'news' => ['$ref' => '#/components/schemas/News']]]]]]],
                    ],
                    'patch' => [
                        'tags' => ['News'],
                        'summary' => 'Обновить новость (PATCH, частичное)',
                        'security' => [['ApiKey' => []]],
                        'parameters' => [
                            ['name' => 'news', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'requestBody' => ['content' => ['application/json' => ['schema' => ['$ref' => '#/components/schemas/NewsInput']]]],
                        'responses' => ['200' => ['description' => 'Обновлена', 'content' => ['application/json' => ['schema' => ['type' => 'object', 'properties' => ['message' => ['type' => 'string'], 'news' => ['$ref' => '#/components/schemas/News']]]]]]],
                    ],
                    'delete' => [
                        'tags' => ['News'],
                        'summary' => 'Удалить новость (soft-delete)',
                        'security' => [['ApiKey' => []]],
                        'parameters' => [
                            ['name' => 'news', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'responses' => [
                            '200' => ['description' => 'Удалена (остаётся в БД с deleted_at)', 'content' => ['application/json' => ['schema' => ['type' => 'object', 'properties' => ['message' => ['type' => 'string'], 'id' => ['type' => 'integer']]]]]],
                        ],
                    ],
                ],
                '/news/{news}/media' => [
                    'post' => [
                        'tags' => ['News'],
                        'summary' => 'Прикрепить фото или видео к новости',
                        'security' => [['ApiKey' => []]],
                        'parameters' => [
                            ['name' => 'news', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']],
                        ],
                        'requestBody' => [
                            'content' => ['application/json' => ['schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'type' => ['type' => 'string', 'enum' => ['photo', 'video'], 'default' => 'photo'],
                                    'url' => ['type' => 'string', 'description' => 'URL фото/видео.'],
                                    'file' => ['type' => 'string', 'description' => 'Или multipart-файл фото.'],
                                    'provider' => ['type' => 'string', 'enum' => ['youtube', 'vk', 'vimeo', 'rutube', 'dzen', 'tiktok', 'other']],
                                    'title' => ['type' => 'string'],
                                    'duration' => ['type' => 'integer', 'description' => 'Длительность видео (сек).'],
                                    'alt' => ['type' => 'string'],
                                    'sort' => ['type' => 'integer', 'default' => 0],
                                ],
                            ]]],
                        ],
                        'responses' => ['201' => ['description' => 'Добавлено', 'content' => ['application/json' => ['schema' => ['type' => 'object', 'properties' => ['message' => ['type' => 'string'], 'media' => ['$ref' => '#/components/schemas/Media']]]]]]],
                    ],
                ],
            ],
        ];
    }
}
