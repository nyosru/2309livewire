<?php

namespace App\Console\Commands;

use App\Services\StNews\AutoModerationNewsServices;
use Illuminate\Console\Command;

class NewsAutoModerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StNews:news-auto-moderate';

    // Описание команды
    protected $description = 'Automatically moderates news if the auto publish time has passed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $service = new AutoModerationNewsServices();
       $result = $service->autoModerateNews();

        // Выводим сообщение о завершении работы команды
        $this->info('News auto moderation completed. '.PHP_EOL.
            'all:'.($result['count_morate_all'] ?? 'x').PHP_EOL.
            'moderated:'.($result['count_morated'] ?? 'x')
        );

        return 0;
    }
}
