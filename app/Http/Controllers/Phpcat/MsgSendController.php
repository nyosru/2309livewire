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
    public function __invoke(Request $request): String
    {
        $msg = json_encode($_REQUEST);
        Msg::sendTelegramm('шлюз msg:'.PHP_EOL.$msg, null, 1 );
        return 'OK';
    }
}
