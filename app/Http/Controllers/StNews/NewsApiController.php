<?php

namespace App\Http\Controllers\StNews;

use App\Http\Controllers\Controller;
use App\Models\StNews;
use App\Models\StNewsMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

/**
 * Публичный CRUD-API для «Самых Тюменских Новостей».
 *
 * Чтение (index/show) — открыто.
 * Запись (store/update/destroy/media) — за middleware stn.api (X-STN-Api-Key).
 *
 * Медиа (фото/видео) хранятся в StNewsMedia, связаны с новостью.
 */
class NewsApiController extends Controller
{
    /**
     * Список последних новостей.
     * ?limit=N (по умолчанию config('stn.default_per_page')), ?all=1 — без фильтра модерации.
     */
    public function index(Request $request): JsonResponse
    {
        $limit = min(
            max((int) $request->input('limit', config('stn.default_per_page', 20)), 1),
            config('stn.max_per_page', 100)
        );

        $query = StNews::query()
            ->where('content', '!=', '')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->with(['media' => fn ($q) => $q->orderBy('sort_order')->orderBy('id'), 'coverPhoto']);

        // По умолчанию — только видимые посетителям (опубликованные: published_at задан). ?all=1 — всё.
        if (! $request->boolean('all', false)) {
            $query->whereNotNull('published_at');
        }

        return response()->json($query->paginate($limit));
    }

    /**
     * Одна новость с медиа.
     */
    public function show(StNews $news): JsonResponse
    {
        return response()->json($news->load(['media' => fn ($q) => $q->orderBy('sort_order')->orderBy('id'), 'coverPhoto']));
    }

    /**
     * Создать новость + вложить фото/видео.
     */
    public function store(Request $request): JsonResponse
    {
        // Авто-публикация черновиков старше 2 суток (не удалённых) при очередном добавлении новости.
        StNews::whereNull('published_at')
            ->whereNull('deleted_at')
            ->where('created_at', '<=', now()->subDays(2))
            ->update(['published_at' => now()]);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'source' => ['nullable', 'url', 'max:500'],
            'cat_id' => ['nullable', 'integer'],
            'site_id' => ['nullable', 'integer'],
            'moderation' => ['nullable', 'boolean'],
            'moderation_required' => ['nullable', 'boolean'],
            'cover_photo_id' => ['nullable', 'integer'],
            'photos' => ['nullable', 'array'],
            'videos' => ['nullable', 'array'],
            'video' => ['nullable', 'array'],
        ]);

        $news = StNews::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'summary' => $data['summary'] ?? null,
            'source' => $data['source'] ?? null,
            // Всегда черновик: видимость ручная, не ранее чем через 2 дня после создания.
            'published_at' => null,
            'cat_id' => $data['cat_id'] ?? null,
            'site_id' => $data['site_id'] ?? null,
            // API — доверенный источник: по умолчанию публикуем (как на сайте).
            'moderation' => $request->boolean('moderation', true),
            'moderation_required' => $request->boolean('moderation_required', true),
        ]);

        // Загруженные файлы (multipart: photos[] как Files)
        foreach ($request->file('photos', []) as $file) {
            $this->storeUploadedPhoto($news, $file);
        }

        // JSON-фото: [{url, alt, sort}]
        foreach ($data['photos'] ?? [] as $p) {
            if (empty($p['url'])) {
                continue;
            }
            StNewsMedia::create($this->mediaAttrs($news, StNewsMedia::TYPE_PHOTO, [
                'photo_path' => $p['url'],
                'alt' => $p['alt'] ?? null,
                'sort_order' => (int) ($p['sort'] ?? 0),
            ]));
        }

        // JSON-видео: videos[] + video (одно)
        $videos = array_filter($data['videos'] ?? [], 'is_array');
        if (is_array($data['video'] ?? null)) {
            $videos[] = $data['video'];
        }
        foreach ($videos as $v) {
            if (empty($v['url'])) {
                continue;
            }
            StNewsMedia::create($this->mediaAttrs($news, StNewsMedia::TYPE_VIDEO, [
                'video_url' => $v['url'],
                'provider' => $v['provider'] ?? null,
                'video_title' => $v['title'] ?? null,
                'duration' => $v['duration'] ?? null,
                'alt' => $v['alt'] ?? null,
                'sort_order' => (int) ($v['sort'] ?? 0),
            ]));
        }

        // Обложка: явная или первое фото
        $coverId = $data['cover_photo_id'] ?? null;
        if (! $coverId) {
            $first = $news->media()->where('media_type', StNewsMedia::TYPE_PHOTO)->orderBy('sort_order')->orderBy('id')->first();
            $coverId = $first?->id;
        }
        if ($coverId) {
            $news->update(['cover_photo_id' => $coverId]);
        }

        return response()->json([
            'message' => 'Новость создана',
            'news' => $news->load(['media', 'coverPhoto']),
        ], 201);
    }

    /**
     * Обновить новость.
     */
    public function update(Request $request, StNews $news): JsonResponse
    {
        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'content' => ['sometimes', 'required', 'string'],
            'summary' => ['nullable', 'string', 'max:1000'],
            'source' => ['nullable', 'url', 'max:500'],
            'published_at' => ['nullable', 'date'],
            'cat_id' => ['nullable', 'integer'],
            'site_id' => ['nullable', 'integer'],
            'cover_photo_id' => ['nullable', 'integer'],
        ]);

        $fill = [];
        foreach (['title', 'content', 'summary', 'source', 'published_at', 'cat_id', 'site_id'] as $field) {
            if ($request->has($field)) {
                $fill[$field] = $data[$field];
            }
        }
        if ($request->has('moderation')) {
            $fill['moderation'] = $request->boolean('moderation');
        }
        if ($request->has('moderation_required')) {
            $fill['moderation_required'] = $request->boolean('moderation_required');
        }
        if ($request->has('cover_photo_id')) {
            $fill['cover_photo_id'] = $data['cover_photo_id'];
        }

        $news->update($fill);

        return response()->json([
            'message' => 'Новость обновлена',
            'news' => $news->load(['media', 'coverPhoto']),
        ]);
    }

    /**
     * Удалить новость (soft delete).
     */
    public function destroy(StNews $news): JsonResponse
    {
        $news->delete();

        return response()->json([
            'message' => 'Новость удалена',
            'id' => $news->id,
        ]);
    }

    /**
     * Прикрепить фото или видео к существующей новости.
     * photo: {url|file, alt, sort}  video: {type:video, url, provider, title, duration}
     */
    public function attachMedia(Request $request, StNews $news): JsonResponse
    {
        $data = $request->validate([
            'type' => ['nullable', Rule::in(['photo', 'video'])],
            'url' => ['nullable', 'url', 'max:500'],
            'file' => ['nullable', 'file'],
            'provider' => ['nullable', 'string', 'max:50'],
            'title' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'integer'],
            'alt' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'integer'],
        ]);

        $type = $data['type'] ?? StNewsMedia::TYPE_PHOTO;
        $sort = (int) ($data['sort'] ?? 0);

        if ($data['file'] instanceof UploadedFile) {
            $media = $this->storeUploadedPhoto($news, $data['file'], $data['alt'] ?? null, $sort);
        } elseif (! empty($data['url'])) {
            if ($type === StNewsMedia::TYPE_VIDEO) {
                $media = StNewsMedia::create($this->mediaAttrs($news, StNewsMedia::TYPE_VIDEO, [
                    'video_url' => $data['url'],
                    'provider' => $data['provider'] ?? null,
                    'video_title' => $data['title'] ?? null,
                    'duration' => $data['duration'] ?? null,
                    'alt' => $data['alt'] ?? null,
                    'sort_order' => $sort,
                ]));
            } else {
                $media = StNewsMedia::create($this->mediaAttrs($news, StNewsMedia::TYPE_PHOTO, [
                    'photo_path' => $data['url'],
                    'alt' => $data['alt'] ?? null,
                    'sort_order' => $sort,
                ]));
            }
        } else {
            return response()->json([
                'error' => 'bad_request',
                'message' => 'Для фото передайте url или file, для видео — url.',
            ], 422);
        }

        return response()->json([
            'message' => 'Медиа добавлено',
            'media' => $media->fresh('news'),
        ], 201);
    }

    /**
     * Сохранить загруженный файл фото на диск и создать запись медиа.
     */
    protected function storeUploadedPhoto(StNews $news, UploadedFile $file, ?string $alt = null, int $sort = 0): StNewsMedia
    {
        $disk = config('stn.media_disk', 'public');
        $path = $file->store("st_news_media/{$news->id}", $disk);

        return StNewsMedia::create($this->mediaAttrs($news, StNewsMedia::TYPE_PHOTO, [
            'photo_path' => $path,
            'local_photo' => $path,
            'alt' => $alt,
            'sort_order' => $sort,
        ]));
    }

    protected function mediaAttrs(StNews $news, string $type, array $attrs): array
    {
        return array_merge(['st_news_id' => $news->id, 'media_type' => $type], $attrs);
    }
}
