<?php

namespace App\Http\Controllers;

use App\Models\VkAuthorVideoDailySnapshot;
use App\Services\VkAuthorStatsService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class VkAuthorStatsController extends Controller
{
    public function index(Request $request, VkAuthorStatsService $stats)
    {
        $today = CarbonImmutable::today(config('app.timezone'));
        $selectedDate = $request->query('date', $today->toDateString());
        abort_unless(is_string($selectedDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate), 404);
        try {
            $date = CarbonImmutable::createFromFormat('Y-m-d', $selectedDate, config('app.timezone'));
        } catch (\Throwable) {
            abort(404);
        }
        abort_unless(
            $date && $date->format('Y-m-d') === $selectedDate && $selectedDate <= $today->toDateString(),
            404
        );

        $error = null;
        if ($date->isSameDay($today)) {
            $error = $stats->refreshIfDue($today);
        }

        $videos = VkAuthorVideoDailySnapshot::query()
            ->whereDate('snapshot_date', $date->toDateString())
            ->orderBy('media_type')
            ->orderByDesc('views')
            ->get();

        $availableDates = VkAuthorVideoDailySnapshot::query()
            ->select('snapshot_date')
            ->distinct()
            ->orderByDesc('snapshot_date')
            ->pluck('snapshot_date')
            ->map(fn ($day) => CarbonImmutable::parse($day)->toDateString());

        return view('vk_author_stats.index', [
            'videos' => $videos,
            'date' => $date,
            'today' => $today,
            'availableDates' => $availableDates,
            'lastUpdated' => $videos->max('captured_at'),
            'error' => $error,
        ]);
    }
}
