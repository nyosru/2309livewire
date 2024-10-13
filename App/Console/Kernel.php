<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Запускаем команду каждые 15 минут
        $schedule->command('StNews:news-download-photo')->everyFifteenMinutes();
//        $schedule->command('StNews:news-download-photo')->everySecond();
//        $schedule->command('app:send-status')->everyFiveSeconds();

        // Запускаем команду каждые 5 секунд с ограничением по времени в 10 секунд
        $schedule->command('app:send-status')
            ->everyFifteenSeconds()
            ->runInBackground()
            ->before(function () {
                set_time_limit(3); // Устанавливаем лимит времени выполнения
            })
        ;

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
