<?php

namespace App\Http\Controllers\Phpcat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Nyos\Msg;

class MsgSendController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): string
    {
        $msg = '';

        foreach ($_REQUEST as $k => $v) {
            $msg .= $k . ': ' . $v . PHP_EOL;
        }
        Msg::sendTelegramm('шлюз msg:' . PHP_EOL . $msg, null, 1);
        return 'OK';
    }
}
