<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Nyos\Msg;

class SendStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        $e = new Msg();
//        $e->sendTelegramm('111',null,2);
//        return 0;

        file_get_contents(
            'https://api.php-cat.com/telegram.php?' . http_build_query([
                's' => md5('2309livewire.schedule'),
                'id' => 360209578,
                'token' => null,
                'msg' => 111,
                'domain' => '2309livewire.schedule'
            ])
        );

    }
}
