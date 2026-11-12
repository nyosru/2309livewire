<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VkManagerAccount;
use App\Models\VkManagerContact;
use App\Models\VkManagerMembership;
use App\Services\VkManagerHistoryService;
use App\Services\VkManagerSnapshotSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class VkManagerAgentController extends Controller
{
    private const STATUSES = [
        'friends' => VkManagerMembership::STATUS_FRIEND,
        'followers' => VkManagerMembership::STATUS_FOLLOWER,
        'outgoing_requests' => VkManagerMembership::STATUS_OUTGOING_REQUEST,
    ];

    public function lists(Request $request): JsonResponse
    {
        $pagination = $request->validate([
            'limit' => ['sometimes', 'integer', 'min:1', 'max:500'],
            'offset' => ['sometimes', 'integer', 'min:0'],
        ]);
        $limit = (int) ($pagination['limit'] ?? 200);
        $offset = (int) ($pagination['offset'] ?? 0);
        $account = VkManagerAccount::query()->where('user_id', $request->user()->getKey())->first();

        if (! $account || ! $account->last_full_sync_at) {
            return response()->json([
                'message' => 'Сначала вызовите POST /api/vk-manager/agent/sync для полной загрузки списков.',
            ], 409);
        }

        $lists = [];
        foreach (self::STATUSES as $listName => $status) {
            $baseQuery = VkManagerMembership::query()
                ->with('person')
                ->where('account_id', $account->getKey())
                ->where('status', $status)
                ->where('is_current', true);

            $total = (clone $baseQuery)->count();
            $memberships = (clone $baseQuery)
                ->orderBy('id')
                ->offset($offset)
                ->limit($limit)
                ->get();
            $vkIds = $memberships->map(fn (VkManagerMembership $membership) => $membership->person?->vk_id)
                ->filter()
                ->values();
            $contacts = $vkIds->isEmpty()
                ? collect()
                : VkManagerContact::query()
                    ->where('user_id', $request->user()->getKey())
                    ->whereIn('vk_friend_id', $vkIds)
                    ->get()
                    ->keyBy('vk_friend_id');

            $lists[$listName] = [
                'total' => $total,
                'offset' => $offset,
                'limit' => $limit,
                'has_more' => $offset + $memberships->count() < $total,
                'items' => $memberships->map(function (VkManagerMembership $membership) use ($contacts): array {
                    $person = $membership->person;
                    $contact = $person ? $contacts->get($person->vk_id) : null;

                    return [
                        'vk_id' => (string) $person?->vk_id,
                        'first_name' => $person?->first_name,
                        'last_name' => $person?->last_name,
                        'display_name' => $person?->display_name,
                        'domain' => $person?->domain,
                        'photo_url' => $person?->photo_url,
                        'status' => $membership->status,
                        'started_at' => $membership->started_at?->toISOString(),
                        'comment' => $contact?->comment,
                        'agent_comment' => $contact?->agent_comment,
                        'is_favorite' => (bool) ($contact?->is_favorite ?? false),
                    ];
                })->values(),
            ];
        }

        return response()->json([
            'account' => [
                'vk_id' => (string) $account->vk_id,
                'name' => $account->name,
                'last_full_sync_at' => $account->last_full_sync_at?->toISOString(),
            ],
            'pagination' => ['limit' => $limit, 'offset' => $offset],
            'lists' => $lists,
        ]);
    }

    public function sync(Request $request, VkManagerSnapshotSyncService $snapshotSync, VkManagerHistoryService $history): JsonResponse
    {
        try {
            $result = $snapshotSync->sync($request->user(), 'agent_full_sync');
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'VK не подтвердил полную загрузку. История не изменена: '.$exception->getMessage(),
            ], 502);
        }

        return response()->json($result + ['summary' => $history->summary($request->user())]);
    }

    public function updateNote(Request $request, string $vkId): JsonResponse
    {
        abort_unless(preg_match('/^[1-9][0-9]{0,19}$/', $vkId) === 1, 404);

        $data = $request->validate([
            'agent_comment' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'is_favorite' => ['sometimes', 'boolean'],
        ]);

        if ($data === []) {
            return response()->json(['message' => 'Передайте agent_comment и/или is_favorite.'], 422);
        }

        $account = VkManagerAccount::query()->where('user_id', $request->user()->getKey())->first();
        $belongsToAccount = $account && VkManagerMembership::query()
            ->where('account_id', $account->getKey())
            ->whereHas('person', fn ($query) => $query->where('vk_id', $vkId))
            ->exists();

        if (! $belongsToAccount) {
            return response()->json(['message' => 'Профиль не найден в истории этого аккаунта.'], 404);
        }

        $contact = VkManagerContact::query()->firstOrNew([
            'user_id' => $request->user()->getKey(),
            'vk_friend_id' => $vkId,
        ]);

        foreach (['agent_comment', 'is_favorite'] as $field) {
            if (array_key_exists($field, $data)) {
                $contact->{$field} = $data[$field];
            }
        }
        $contact->save();

        return response()->json([
            'vk_id' => $vkId,
            'comment' => $contact->comment,
            'agent_comment' => $contact->agent_comment,
            'is_favorite' => (bool) $contact->is_favorite,
        ]);
    }
}
