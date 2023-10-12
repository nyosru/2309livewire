<?php

namespace App\Observers\Uprav;

use App\Models\uprav\backword;
use nyos\Msg as MsgAlias;

class BackwordObserver
{
    /**
     * Handle the backword "created" event.
     */
    public function created(backword $backword): void
    {
//        sleep(5);
        $str = 'новое сообщение в обратную связь' . PHP_EOL .
            'как зовут :' . ($backword->names ?? 'x') . PHP_EOL .
            'контакт: ' . ($backword->contact ?? 'x') . PHP_EOL .
            'мсдж: ' . ($backword->message ?? 'x');
        MsgAlias::sendTelegramm($str, null, 1);
    }

//    /**
//     * Handle the backword "updated" event.
//     */
//    public function updated(backword $backword): void
//    {
//        //
//    }
//
//    /**
//     * Handle the backword "deleted" event.
//     */
//    public function deleted(backword $backword): void
//    {
//        //
//    }
//
//    /**
//     * Handle the backword "restored" event.
//     */
//    public function restored(backword $backword): void
//    {
//        //
//    }
//
//    /**
//     * Handle the backword "force deleted" event.
//     */
//    public function forceDeleted(backword $backword): void
//    {
//        //
//    }
}
