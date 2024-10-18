<?php

namespace App\Console\Commands;

use App\Services\StNews\NewsPhotoService;
use Illuminate\Console\Command;
use Nyos\Msg;

class NewsDownloadPhoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'StNews:news-download-photo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download photo from news and save local';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $e = new NewsPhotoService();
        $res = $e->downloadAndStorePhotos();
        foreach($res['log'] as $l ){
            $this->info($l);
        }


        $msg = 'downloadAndStorePhotos completed. '.PHP_EOL
//            .serialize($res)
        .
            'all:'.($res['count_morate_all'] ?? 'x').PHP_EOL.
            'moderated:'.($res['count_morated'] ?? 'x').PHP_EOL.
            'size Mb:'.($res['loaded_size'] ? ( round($res['loaded_size']/1024,2) ) : 'x')
        ;
        Msg::sendTelegramm($msg,null,2);
//        Msg::sendTelegramm($msg,null,2);
        $this->info($msg);

    }
}
