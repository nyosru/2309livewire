<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ZaglushkaController extends Controller {
    public function show(Request $request) {

        if( strtolower(substr($_SERVER['HTTP_HOST'], 0, 4) ) == 'www.' ){
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            return redirect()->away($protocol . substr($_SERVER['HTTP_HOST'], 4, 500 ) );
        }

        if( Cache::add('domain'.strtolower($_SERVER['HTTP_HOST']), '1', 60*60*24 ) ) {
            $msg = 'заход на пустой домен ' . $_SERVER['HTTP_HOST'];
            \nyos\Msg::sendTelegramm($msg, null, 1);
//            dd($_SERVER['HTTP_HOST']);
        }
        $ra = [
//            1,
            38,
            42, // ртуть
            31,
            26,
            25, // снег
//            16, // вода не работает
        ];
        return view('zaglushka.index',['nn' => $ra[rand(0,sizeof($ra)-1)]]);
    }
}
