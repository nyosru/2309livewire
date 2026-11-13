<?php

namespace App\Http\Controllers;

use App\Services\VkManagerHistoryService;
use App\Services\VkManagerSnapshotSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class VkManagerHistoryController extends Controller
{
    public function instructions(): View
    {
        $markdown = file_get_contents(base_path('docs/vk-manager-history.md')) ?: '';
        $agentHeading = '## Для агентов, выполняющих действия с друзьями';
        $agentStart = strpos($markdown, $agentHeading);
        $agentEnd = $agentStart === false ? false : strpos($markdown, "\n## ", $agentStart + strlen($agentHeading));

        if ($agentStart === false) {
            $agentGuide = '';
            $otherGuide = $markdown;
        } else {
            $agentEnd = $agentEnd === false ? strlen($markdown) : $agentEnd;
            $agentGuide = substr($markdown, $agentStart, $agentEnd - $agentStart);
            $otherGuide = trim(substr($markdown, 0, $agentStart).substr($markdown, $agentEnd));
        }

        return view('vk_manager.instructions', [
            'agentGuideHtml' => Str::markdown($agentGuide),
            'otherGuideHtml' => Str::markdown($otherGuide),
        ]);
    }

    public function sync(Request $request, VkManagerSnapshotSyncService $snapshotSync, VkManagerHistoryService $history): JsonResponse
    {
        try {
            $result = $snapshotSync->sync($request->user(), 'manual_full_sync');
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'VK не подтвердил полную загрузку списков. История не изменена: '.$exception->getMessage(),
            ], 502);
        }

        return response()->json($result + ['summary' => $history->summary($request->user())]);
    }

    public function store(Request $request, VkManagerHistoryService $history): JsonResponse
    {
        $data = $request->validate([
            'vk_id' => ['required', 'string', 'regex:/^[1-9][0-9]{0,19}$/'],
            'status' => ['required', 'string', 'in:friend,follower,outgoing_request,none'],
            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'domain' => ['nullable', 'string', 'max:100'],
            'photo_url' => ['nullable', 'string', 'max:4000'],
            'profile' => ['sometimes', 'array'],
            'source' => ['nullable', 'string', 'max:50'],
        ]);

        $status = $data['status'] === 'none' ? null : $data['status'];
        $profile = array_merge($data['profile'] ?? [], array_intersect_key($data, array_flip([
            'first_name', 'last_name', 'display_name', 'domain', 'photo_url',
        ])));
        $result = $history->recordChange(
            $request->user(),
            $data['vk_id'],
            $status,
            $profile,
            $data['source'] ?? 'agent_http',
        );

        return response()->json($result);
    }
}
