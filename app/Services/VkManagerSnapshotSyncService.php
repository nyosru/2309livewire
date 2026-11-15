<?php

namespace App\Services;

use App\Models\User;
use App\Models\VkManagerAccount;
use App\Models\VkManagerSyncItem;
use App\Models\VkManagerSyncPage;
use App\Models\VkManagerSyncRun;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class VkManagerSnapshotSyncService
{
    private const PAGE_SIZE = 400;

    private const COMMIT_CHUNK_SIZE = 100;

    private const LISTS = ['friends', 'followers', 'requests'];

    private const PROFILE_FIELDS = [
        'first_name_nom', 'first_name_gen', 'first_name_dat', 'first_name_acc', 'first_name_ins', 'first_name_abl',
        'last_name_nom', 'last_name_gen', 'last_name_dat', 'last_name_acc', 'last_name_ins', 'last_name_abl',
        'nickname', 'screen_name', 'domain', 'maiden_name', 'verified', 'is_verified', 'photo_id', 'has_photo',
        'photo', 'photo_rec', 'photo_50', 'photo_100', 'photo_200_orig', 'photo_200', 'photo_400', 'photo_400_orig',
        'photo_big', 'photo_medium', 'photo_medium_rec', 'photo_max', 'photo_max_orig', 'photo_max_size', 'crop_photo',
        'sex', 'bdate', 'bdate_visibility', 'city', 'country', 'home_town', 'timezone', 'language',
        'education', 'universities', 'schools', 'career', 'military', 'work',
        'contacts', 'has_mobile', 'site', 'connections', 'exports',
    ];

    private float $lastRequestAt = 0;

    public function __construct(private readonly VkManagerHistoryService $history) {}

    public function latestRun(User $owner): ?VkManagerSyncRun
    {
        $accountId = VkManagerAccount::query()->where('user_id', $owner->getKey())->value('id');
        if (! $accountId) {
            return null;
        }

        return VkManagerSyncRun::query()
            ->where('account_id', $accountId)
            ->whereIn('status', [
                VkManagerSyncRun::STATUS_COUNTING,
                VkManagerSyncRun::STATUS_RUNNING,
                VkManagerSyncRun::STATUS_FAILED,
                VkManagerSyncRun::STATUS_FINALIZING,
                VkManagerSyncRun::STATUS_READY,
            ])
            ->latest('id')
            ->first();
    }

    public function startRun(User $owner): VkManagerSyncRun
    {
        $this->assertOwnerCanSync($owner);
        $account = $this->history->ensureAccount($owner);
        $existing = VkManagerSyncRun::query()
            ->where('account_id', $account->getKey())
            ->whereIn('status', [
                VkManagerSyncRun::STATUS_COUNTING,
                VkManagerSyncRun::STATUS_RUNNING,
                VkManagerSyncRun::STATUS_FAILED,
                VkManagerSyncRun::STATUS_FINALIZING,
                VkManagerSyncRun::STATUS_READY,
            ])
            ->latest('id')
            ->first();
        if ($existing) {
            return $existing;
        }

        $progress = [];
        foreach (self::LISTS as $list) {
            $progress[$list] = ['count' => null, 'pages' => null, 'completed_pages' => 0, 'done' => false];
        }

        return VkManagerSyncRun::query()->create([
            'account_id' => $account->getKey(),
            'status' => VkManagerSyncRun::STATUS_COUNTING,
            'current_list' => self::LISTS[0],
            'progress' => $progress,
            'started_at' => now(),
        ]);
    }

    public function retryRun(User $owner): ?VkManagerSyncRun
    {
        $run = $this->latestRun($owner);
        if (! $run || $run->status !== VkManagerSyncRun::STATUS_FAILED || $run->error_page > 0) {
            return $run;
        }

        $run->forceFill([
            'status' => $run->error_list === 'finalizing'
                ? VkManagerSyncRun::STATUS_FINALIZING
                : VkManagerSyncRun::STATUS_COUNTING,
            'error_message' => null,
            'error_list' => null,
            'error_page' => null,
            'next_request_at' => null,
        ])->save();

        return $run->fresh();
    }

    public function resumeAfterAuthorization(User $owner): void
    {
        $run = $this->latestRun($owner);
        if (! $run || $run->status !== VkManagerSyncRun::STATUS_FAILED || $run->error_list !== 'authorization') {
            return;
        }

        if ($run->error_page > 0) {
            $run->pages()
                ->where('list_name', $run->current_list)
                ->where('page_number', $run->error_page)
                ->where('status', VkManagerSyncPage::STATUS_ERROR)
                ->update([
                    'status' => VkManagerSyncPage::STATUS_NEW,
                    'error_message' => null,
                    'started_at' => null,
                    'updated_at' => now(),
                ]);
        }

        $run->forceFill([
            'status' => $run->error_page ? VkManagerSyncRun::STATUS_RUNNING : VkManagerSyncRun::STATUS_COUNTING,
            'error_message' => null,
            'error_list' => null,
            'error_page' => null,
            'next_request_at' => null,
        ])->save();
    }

    public function retryPage(User $owner, string $list, int $pageNumber): ?VkManagerSyncRun
    {
        $run = $this->latestRun($owner);
        if (! $run || $run->status !== VkManagerSyncRun::STATUS_FAILED || ! in_array($list, self::LISTS, true) || $pageNumber < 1) {
            return $run;
        }

        $page = $run->pages()->where('list_name', $list)->where('page_number', $pageNumber)->first();
        if (! $page || $page->status !== VkManagerSyncPage::STATUS_ERROR) {
            return $run;
        }

        $page->forceFill([
            'status' => VkManagerSyncPage::STATUS_NEW,
            'error_message' => null,
            'started_at' => null,
        ])->save();
        $run->forceFill([
            'status' => VkManagerSyncRun::STATUS_RUNNING,
            'current_list' => $list,
            'current_page' => $pageNumber,
            'error_message' => null,
            'error_list' => null,
            'error_page' => null,
            'next_request_at' => null,
        ])->save();

        return $run->fresh();
    }

    public function commitSnapshot(User $owner): ?VkManagerSyncRun
    {
        $this->assertOwnerCanSync($owner);
        $run = $this->latestRun($owner);
        if (! $run || $run->status !== VkManagerSyncRun::STATUS_READY) {
            return $run;
        }

        foreach (self::LISTS as $list) {
            $state = $run->progress[$list] ?? [];
            if (! is_numeric($state['count'] ?? null) || (int) $run->pages()->where('list_name', $list)->where('status', VkManagerSyncPage::STATUS_LOADED)->count() !== (int) ($state['pages'] ?? -1)) {
                throw new RuntimeException('Нельзя отправить данные: не все страницы загружены успешно.');
            }
        }

        $progress = $run->progress ?? [];
        $progress['commit_completed'] = 0;
        $progress['commit_total'] = (int) $run->items()->distinct('vk_id')->count('vk_id');
        $run->forceFill(['status' => VkManagerSyncRun::STATUS_FINALIZING, 'progress' => $progress, 'next_request_at' => null])->save();

        return $run->fresh();
    }

    public function advanceRun(User $owner): ?VkManagerSyncRun
    {
        $run = $this->latestRun($owner);
        if (! $run || ! in_array($run->status, [VkManagerSyncRun::STATUS_COUNTING, VkManagerSyncRun::STATUS_RUNNING, VkManagerSyncRun::STATUS_FINALIZING], true)) {
            return $run;
        }

        if ($run->next_request_at && $run->next_request_at->isFuture()) {
            return $run;
        }

        $now = now();
        $leaseSeconds = $run->status === VkManagerSyncRun::STATUS_FINALIZING ? 120 : 30;
        $claimed = VkManagerSyncRun::query()
            ->whereKey($run->getKey())
            ->where('account_id', $run->account_id)
            ->whereIn('status', [VkManagerSyncRun::STATUS_COUNTING, VkManagerSyncRun::STATUS_RUNNING, VkManagerSyncRun::STATUS_FINALIZING])
            ->where(function ($query) use ($now): void {
                $query->whereNull('next_request_at')->orWhere('next_request_at', '<=', $now);
            })
            ->update(['next_request_at' => $now->copy()->addSeconds($leaseSeconds), 'updated_at' => $now]);
        if (! $claimed) {
            return $run->fresh();
        }
        $run = $run->fresh();

        try {
            $this->assertOwnerCanSync($owner);
            if ($run->status === VkManagerSyncRun::STATUS_COUNTING) {
                $this->countNextList($owner, $run);
            } elseif ($run->status === VkManagerSyncRun::STATUS_RUNNING) {
                $stalledPage = $run->pages()
                    ->where('list_name', $run->current_list)
                    ->where('page_number', $run->current_page)
                    ->where('status', VkManagerSyncPage::STATUS_LOADING)
                    ->first();
                if ($stalledPage) {
                    $stalledPage->forceFill([
                        'status' => VkManagerSyncPage::STATUS_NEW,
                        'error_message' => null,
                        'started_at' => null,
                    ])->save();
                }
                $this->fetchNextPage($owner, $run);
            } else {
                $this->finalizeRun($owner, $run);
            }
        } catch (Throwable $exception) {
            $isAuthorizationError = str_starts_with($exception->getMessage(), 'VK_AUTHORIZATION_ERROR:');
            $errorPage = $run->status === VkManagerSyncRun::STATUS_RUNNING
                ? (int) $run->current_page
                : 0;
            $errorMessage = $isAuthorizationError
                ? substr($exception->getMessage(), strlen('VK_AUTHORIZATION_ERROR: '))
                : $exception->getMessage();

            if ($errorPage > 0) {
                $run->pages()
                    ->where('list_name', $run->current_list)
                    ->where('page_number', $errorPage)
                    ->update([
                        'status' => VkManagerSyncPage::STATUS_ERROR,
                        'error_message' => $errorMessage,
                        'updated_at' => now(),
                    ]);
            }

            $run->forceFill([
                'status' => VkManagerSyncRun::STATUS_FAILED,
                'error_message' => $errorMessage,
                'error_list' => $isAuthorizationError
                    ? 'authorization'
                    : ($run->status === VkManagerSyncRun::STATUS_FINALIZING ? 'finalizing' : $run->current_list),
                'error_page' => $errorPage,
            ])->save();
        }

        return $run->fresh();
    }

    private function countNextList(User $owner, VkManagerSyncRun $run): void
    {
        $list = $run->current_list;
        if (! in_array($list, self::LISTS, true)) {
            $list = self::LISTS[0];
        }

        $response = $this->requestList($owner, $list, 1, 0, false);
        $count = data_get($response, 'count');
        if (! is_numeric($count)) {
            throw new RuntimeException('VK не вернул общее количество для списка «'.$this->listLabel($list).'».');
        }

        $progress = $run->progress;
        $progress[$list]['count'] = (int) $count;
        $progress[$list]['pages'] = (int) ceil((int) $count / self::PAGE_SIZE);
        $progress[$list]['done'] = (int) $count === 0;
        $nextCountList = $this->nextList($list, $progress, 'count');
        $nextList = $nextCountList;
        if ($nextCountList === null) {
            DB::transaction(function () use ($run, $progress): void {
                foreach (self::LISTS as $pageList) {
                    for ($pageNumber = 1; $pageNumber <= (int) $progress[$pageList]['pages']; $pageNumber++) {
                        $run->pages()->firstOrCreate(
                            ['list_name' => $pageList, 'page_number' => $pageNumber],
                            ['status' => VkManagerSyncPage::STATUS_NEW],
                        );
                    }
                }
            });
            $nextPage = $this->nextPendingPage($run);
            $nextList = $nextPage?->list_name;
        }
        $run->forceFill([
            'progress' => $progress,
            'current_list' => $nextList,
            'current_page' => isset($nextPage) ? (int) $nextPage->page_number : 0,
            'status' => $nextCountList !== null
                ? VkManagerSyncRun::STATUS_COUNTING
                : ($nextList === null ? VkManagerSyncRun::STATUS_READY : VkManagerSyncRun::STATUS_RUNNING),
            'next_request_at' => now()->addSecond(),
        ])->save();
    }

    private function fetchNextPage(User $owner, VkManagerSyncRun $run): void
    {
        $list = $run->current_list;
        $progress = $run->progress;
        $state = $progress[$list] ?? null;
        if (! is_array($state)) {
            throw new RuntimeException('Не найдено состояние списка для продолжения загрузки.');
        }

        $page = $run->pages()->where('list_name', $list)->where('page_number', $run->current_page)->first();
        if (! $page || $page->status !== VkManagerSyncPage::STATUS_NEW) {
            throw new RuntimeException('Страница не готова к загрузке. Обновите список страниц.');
        }

        $pageNumber = (int) $page->page_number;
        $offset = ($pageNumber - 1) * self::PAGE_SIZE;
        $expected = min(self::PAGE_SIZE, max(0, (int) $state['count'] - $offset));
        $page->forceFill(['status' => VkManagerSyncPage::STATUS_LOADING, 'error_message' => null, 'started_at' => now()])->save();
        $response = $this->requestList($owner, $list, self::PAGE_SIZE, $offset, true);
        if ((int) data_get($response, 'count', -1) !== (int) $state['count']) {
            throw new RuntimeException('Количество записей списка изменилось во время загрузки. Запустите обновление заново.');
        }

        $items = data_get($response, 'items');
        if (! is_array($items) || count($items) !== $expected) {
            throw new RuntimeException('VK вернул неполную страницу '.$pageNumber.' списка «'.$this->listLabel($list).'».');
        }

        $rows = [];
        foreach ($items as $item) {
            $vkId = data_get($item, 'id', data_get($item, 'user_id'));
            if (! is_numeric($vkId) || (int) $vkId < 1) {
                throw new RuntimeException('VK вернул запись без корректного ID на странице '.$pageNumber.'.');
            }
            $rows[] = [
                'run_id' => $run->getKey(),
                'list_name' => $list,
                'vk_id' => (string) $vkId,
                'payload' => json_encode($item, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::transaction(function () use ($run, $rows, $progress, $list, $page): void {
            if ($rows !== []) {
                VkManagerSyncItem::query()->upsert($rows, ['run_id', 'list_name', 'vk_id'], ['payload', 'updated_at']);
            }
            $page->forceFill([
                'status' => VkManagerSyncPage::STATUS_LOADED,
                'error_message' => null,
                'completed_at' => now(),
            ])->save();
            $progress[$list]['completed_pages']++;
            $progress[$list]['done'] = $progress[$list]['completed_pages'] >= $progress[$list]['pages'];
            $nextPage = $this->nextPendingPage($run);
            $run->forceFill([
                'progress' => $progress,
                'current_list' => $nextPage?->list_name,
                'current_page' => $nextPage?->page_number ?? 0,
                'status' => $nextPage === null ? VkManagerSyncRun::STATUS_READY : VkManagerSyncRun::STATUS_RUNNING,
                'next_request_at' => now()->addSecond(),
            ])->save();
        });
    }

    private function finalizeRun(User $owner, VkManagerSyncRun $run): void
    {
        $priority = ['requests' => 1, 'followers' => 2, 'friends' => 3];
        $items = $run->items();
        $total = (int) (clone $items)->distinct('vk_id')->count('vk_id');
        $progress = $run->progress ?? [];
        $offset = max(0, (int) ($progress['commit_completed'] ?? 0));
        $progress['commit_total'] = $total;

        if ($offset < $total) {
            $chunkIds = (clone $items)->select('vk_id')->groupBy('vk_id')->orderByRaw('MIN(id)')
                ->offset($offset)->limit(self::COMMIT_CHUNK_SIZE)->pluck('vk_id')->map(fn ($id) => (string) $id)->all();
            $observations = [];
            foreach ((clone $items)->whereIn('vk_id', $chunkIds)->get(['list_name', 'vk_id', 'payload']) as $item) {
                $list = $item->list_name;
                $vkId = (string) $item->vk_id;
                if (! isset($observations[$vkId]) || $priority[$list] > $priority[$observations[$vkId]['list']]) {
                    $observations[$vkId] = ['list' => $list, 'payload' => $item->payload ?? []];
                }
            }
            $lists = ['friends' => [], 'followers' => [], 'requests' => []];
            foreach ($chunkIds as $vkId) {
                if (! isset($observations[$vkId])) {
                    continue;
                }
                $payload = $observations[$vkId]['payload'];
                $payload['id'] = (int) $vkId;
                $lists[$observations[$vkId]['list']][] = $payload;
            }
            $this->history->observeLists($owner, $lists['friends'], $lists['followers'], 'manual_full_sync', $lists['requests']);
            $progress['commit_completed'] = $offset + count($chunkIds);
            $run->forceFill(['progress' => $progress, 'next_request_at' => now()->addSecond()])->save();

            return;
        }

        $observedVkIds = (clone $items)->distinct()->orderBy('vk_id')->pluck('vk_id')->map(fn ($id) => (string) $id)->all();
        $this->history->completeSnapshot($owner, $observedVkIds);
        $run->items()->delete();
        $run->forceFill([
            'status' => VkManagerSyncRun::STATUS_COMPLETED,
            'current_list' => null,
            'completed_at' => now(),
            'next_request_at' => null,
        ])->save();
    }

    private function requestList(User $owner, string $list, int $count, int $offset, bool $withFields): array
    {
        $parameters = match ($list) {
            'friends' => ['user_id' => $owner->vk_id, 'order' => 'hints'],
            'followers' => ['user_id' => $owner->vk_id],
            'requests' => ['out' => 1, 'extended' => 1],
        };
        if ($withFields) {
            $parameters['fields'] = implode(',', self::PROFILE_FIELDS);
        }

        $this->waitBetweenRequests();
        $response = Http::asForm()->acceptJson()->timeout(20)->post('https://api.vk.com/method/'.$this->methodForList($list), array_merge($parameters, [
            'count' => $count,
            'offset' => $offset,
            'access_token' => $owner->vk_token,
            'v' => config('services.vk.api_version', '5.199'),
        ]));

        if (! $response->successful()) {
            throw new RuntimeException("VK вернул HTTP {$response->status()} при загрузке списка «".$this->listLabel($list).'».');
        }
        $payload = $response->json();
        if (isset($payload['error'])) {
            $code = (int) data_get($payload, 'error.error_code', 0);
            if (in_array($code, [5, 7, 15, 27, 28], true)) {
                throw new RuntimeException('VK_AUTHORIZATION_ERROR: Токен VK не даёт нужный доступ или срок его действия истёк. Переподключите VK.');
            }

            throw new RuntimeException('VK API '.$code.': '.data_get($payload, 'error.error_msg', 'ошибка VK API'));
        }

        return data_get($payload, 'response', []);
    }

    private function methodForList(string $list): string
    {
        return match ($list) {
            'friends' => 'friends.get',
            'followers' => 'users.getFollowers',
            'requests' => 'friends.getRequests',
        };
    }

    private function listLabel(string $list): string
    {
        return ['friends' => 'Друзья', 'followers' => 'Подписчики', 'requests' => 'Исходящие заявки'][$list] ?? $list;
    }

    private function nextList(string $current, array $progress, string $completedKey): ?string
    {
        $index = array_search($current, self::LISTS, true);
        for ($i = $index === false ? 0 : $index + 1; $i < count(self::LISTS); $i++) {
            $candidate = self::LISTS[$i];
            if ($completedKey === 'count' && $progress[$candidate]['count'] === null) {
                return $candidate;
            }
            if ($completedKey === 'pages' && ! $progress[$candidate]['done']) {
                return $candidate;
            }
        }

        return null;
    }

    private function nextPendingPage(VkManagerSyncRun $run): ?VkManagerSyncPage
    {
        foreach (self::LISTS as $list) {
            $page = $run->pages()
                ->where('list_name', $list)
                ->where('status', VkManagerSyncPage::STATUS_NEW)
                ->orderBy('page_number')
                ->first();
            if ($page) {
                return $page;
            }
        }

        return null;
    }

    private function assertOwnerCanSync(User $owner): void
    {
        if (! filled($owner->vk_id) || ! filled($owner->vk_token)) {
            throw new RuntimeException('У аккаунта не найден действующий токен VK. Переподключите VK.');
        }
    }

    /** @return array{account_id: int, observed: int, changed: int, staled: int, complete_snapshot: bool, friends: int, followers: int} */
    public function sync(User $owner, string $source = 'full_snapshot'): array
    {
        if (! filled($owner->vk_id) || ! filled($owner->vk_token)) {
            throw new RuntimeException('У аккаунта не найден действующий токен VK. Переподключите VK.');
        }

        $friends = $this->fetchCompleteList($owner, 'friends.get', [
            'user_id' => $owner->vk_id,
            'order' => 'hints',
            'fields' => implode(',', self::PROFILE_FIELDS),
        ]);
        $followers = $this->fetchCompleteList($owner, 'users.getFollowers', [
            'user_id' => $owner->vk_id,
            'fields' => implode(',', self::PROFILE_FIELDS),
        ]);
        $outgoingRequests = $this->fetchCompleteList($owner, 'friends.getRequests', [
            'out' => 1,
            'extended' => 1,
            'fields' => implode(',', self::PROFILE_FIELDS),
        ]);

        $result = $this->history->reconcileSnapshot($owner, $friends, $followers, $source, $outgoingRequests);

        return $result + [
            'friends' => count($friends),
            'followers' => count($followers),
            'outgoing_requests' => count($outgoingRequests),
        ];
    }

    private function fetchCompleteList(User $owner, string $method, array $parameters): array
    {
        $all = [];
        $offset = 0;
        $total = null;
        $pageSize = 1000;

        do {
            $this->waitBetweenRequests();
            $response = Http::asForm()
                ->acceptJson()
                ->timeout(20)
                ->post("https://api.vk.com/method/{$method}", array_merge($parameters, [
                    'count' => $pageSize,
                    'offset' => $offset,
                    'access_token' => $owner->vk_token,
                    'v' => config('services.vk.api_version', '5.199'),
                ]));

            if (! $response->successful()) {
                throw new RuntimeException("VK вернул HTTP {$response->status()} при загрузке списка.");
            }

            $payload = $response->json();
            if (isset($payload['error'])) {
                $code = data_get($payload, 'error.error_code', 'unknown');
                $message = data_get($payload, 'error.error_msg', 'ошибка VK API');
                throw new RuntimeException("VK API {$code}: {$message}");
            }

            $items = data_get($payload, 'response.items');
            $pageTotal = data_get($payload, 'response.count');
            if (! is_array($items) || ! is_numeric($pageTotal)) {
                throw new RuntimeException('VK вернул неполный список. История не обновлена.');
            }
            $total ??= (int) $pageTotal;

            if ($items === [] && $offset < $total) {
                throw new RuntimeException('VK вернул неполную страницу списка. История не обновлена.');
            }

            $all = array_merge($all, $items);
            $offset += count($items);
        } while ($offset < $total);

        if (count($all) !== $total) {
            throw new RuntimeException('VK вернул неполный список. История не обновлена.');
        }

        return $all;
    }

    private function waitBetweenRequests(): void
    {
        if ($this->lastRequestAt > 0) {
            $waitMicroseconds = max(0, 1_000_000 - (int) ((microtime(true) - $this->lastRequestAt) * 1_000_000));
            if ($waitMicroseconds > 0) {
                usleep($waitMicroseconds);
            }
        }

        $this->lastRequestAt = microtime(true);
    }
}
