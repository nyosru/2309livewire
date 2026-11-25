<?php

namespace App\Services;

use App\Models\VkAuthorVideoDailySnapshot;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class VkAuthorStatsService
{
    public function refreshIfDue(CarbonImmutable $date): ?string
    {
        $latestCapture = VkAuthorVideoDailySnapshot::query()
            ->whereDate('snapshot_date', $date->toDateString())
            ->max('captured_at');

        if ($latestCapture && CarbonImmutable::parse($latestCapture)->gt(now()->subMinutes(config('services.vk_author_stats.refresh_interval_minutes', 240)))) {
            return null;
        }

        $token = config('services.vk_author_stats.access_token');
        if (! filled($token)) {
            return 'Добавьте VK_AUTHOR_STATS_ACCESS_TOKEN в .env и перезапустите приложение.';
        }

        $lock = cache()->lock('vk-author-stats-refresh-'.$date->toDateString(), 180);
        if (! $lock->get()) {
            return null;
        }

        try {
            $latestCapture = VkAuthorVideoDailySnapshot::query()
                ->whereDate('snapshot_date', $date->toDateString())
                ->max('captured_at');
            if ($latestCapture && CarbonImmutable::parse($latestCapture)->gt(now()->subMinutes(config('services.vk_author_stats.refresh_interval_minutes', 240)))) {
                return null;
            }

            $this->capture($date);

            return null;
        } catch (\Throwable $exception) {
            return 'Не удалось обновить данные VK: '.$exception->getMessage();
        } finally {
            $lock->release();
        }
    }

    private function capture(CarbonImmutable $date): void
    {
        $ownerId = (int) config('services.vk_author_stats.owner_id');
        $offset = 0;
        $count = 200;
        $items = [];
        $expectedCount = null;

        do {
            $response = Http::timeout(25)->get('https://api.vk.com/method/video.get', [
                'owner_id' => $ownerId,
                'count' => $count,
                'offset' => $offset,
                'extended' => 1,
                'access_token' => config('services.vk_author_stats.access_token'),
                'v' => config('services.vk_author_stats.api_version', '5.199'),
            ]);

            if (! $response->successful()) {
                throw new RuntimeException('VK API вернул HTTP '.$response->status().'.');
            }

            $payload = $response->json();
            if (isset($payload['error'])) {
                throw new RuntimeException($payload['error']['error_msg'] ?? 'ошибка API.');
            }

            $result = $payload['response'] ?? [];
            $pageItems = $result['items'] ?? [];
            $expectedCount ??= (int) ($result['count'] ?? count($pageItems));
            $items = array_merge($items, $pageItems);
            $offset += count($pageItems);
        } while ($offset < $expectedCount && count($pageItems) > 0);

        $capturedAt = now();
        foreach ($items as $item) {
            if (! isset($item['id'], $item['owner_id'])) {
                continue;
            }

            $videoId = (string) $item['id'];
            $itemOwnerId = (string) $item['owner_id'];
            $mediaType = ($item['type'] ?? null) === 'short_video' ? 'clip' : 'video';
            $videoUrl = $mediaType === 'clip'
                ? 'https://vk.com/clip'.$itemOwnerId.'_'.$videoId
                : 'https://vkvideo.ru/video'.$itemOwnerId.'_'.$videoId;
            $thumbnail = $this->thumbnail($item);

            VkAuthorVideoDailySnapshot::query()->updateOrCreate(
                [
                    'snapshot_date' => $date->toDateString(),
                    'media_type' => $mediaType,
                    'owner_id' => $itemOwnerId,
                    'video_id' => $videoId,
                ],
                [
                    'title' => $item['title'] ?? 'Без названия',
                    'views' => max(0, (int) ($item['views'] ?? 0)),
                    'duration' => isset($item['duration']) ? max(0, (int) $item['duration']) : null,
                    'published_at' => isset($item['date']) ? CarbonImmutable::createFromTimestamp((int) $item['date']) : null,
                    'thumbnail_url' => $thumbnail,
                    'video_url' => $videoUrl,
                    'captured_at' => $capturedAt,
                ]
            );
        }
    }

    private function thumbnail(array $item): ?string
    {
        foreach (['image', 'first_frame', 'photo_800', 'photo_640', 'photo_320', 'photo_130'] as $key) {
            if (! empty($item[$key]) && is_string($item[$key])) {
                return $item[$key];
            }
        }

        if (! empty($item['image'][0]['url'])) {
            return $item['image'][0]['url'];
        }

        return null;
    }
}
