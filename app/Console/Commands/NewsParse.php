<?php

namespace App\Console\Commands;

use App\Http\Controllers\StNews\ParseController;
use Illuminate\Console\Command;

class NewsParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StNews:news-parse';

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
        $this->info('news parse');

        $go = new ParseController();
        $go->go();
        return 0;
    }
}
