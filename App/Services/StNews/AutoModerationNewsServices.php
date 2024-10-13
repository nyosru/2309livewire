<?php

namespace App\Services\StNews;

use Carbon\Carbon;
use App\Models\StNews;
use App\Models\StNewsParsingSite;

class AutoModerationNewsServices
{
    /**
     * Устанавливает moderation = true, если время автопубликации прошло
     */
    public function autoModerateNews():array
    {
        $return = [];

        // Получаем новости, у которых moderation пустое и есть site_id
        $newsToModerate = StNews::whereNotNull('content')->whereNull('moderation')
            ->whereHas('site', function ($query) {
                $query->whereNotNull('time_to_auto_publish'); // Проверяем, что у сайта есть time_to_auto_publish
            })
            ->with('site')
            ->get();

        $count_morated = 0;

        foreach ($newsToModerate as $news) {

            // Получаем привязанный сайт
            $site = $news->site;

            if ($site) {
                // Рассчитываем время, когда новость должна быть автоматически промодерирована
                $newsPublishTime = $news->updated_at;
                $timeToAutoPublish = $site->time_to_auto_publish;

                // Проверяем, прошло ли указанное время с момента публикации
                if ($newsPublishTime && $newsPublishTime->addMinutes($timeToAutoPublish)->isPast()) {
                    // Устанавливаем moderation в true
                    $news->moderation = true;
                    $news->save();
                    $count_morated++;
                }
            }

        }

        return [
            'count_morate_all' => count($newsToModerate),
            'count_morated' => $count_morated,
            'dop' => $return
        ];
    }
}
