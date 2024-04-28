<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CaddyService extends Controller {

    public static function parseConfigBlock($block): array {
        $b = [];
        $b['domains'] = self::getFromBlockDomains($block[0]);
        return $b;
    }

    public static function getFromBlockDomains($string): array {
        $d = [];
        $d = explode(',', trim(str_replace(['{', ' '], ['', ''], $string)));
        return $d;
    }


    public static function getFromBlockAllParams(array $block, Request $request): array {
        $r = [];

        foreach($block as $k => $str) {
            if($k == 0) {
                $r['domains'] = self::getFromBlockDomains($str);
//                $r['check_domains'] = DomainService::checkDomains( $r['domains'] , $request);
            } else {
                $r['param'][] = self::getFromBlockParam($str);
            }
        }

        $r['raw_data'] = $block;

//        $d = explode(',',trim(str_replace(['{',' '],['',''],$string)));
        return $r;
    }

    public static function getFromBlockParam(string $str = NULL): array {

        if(empty($str))
            return [];

        $ss = explode(' ', trim($str));


        $d = [
            //'raw' => trim($str),
            'type' => $ss[0]
        ];


        if($ss[0] == 'php_fastcgi') {

            $e = explode(':', $ss[1]);
            $d['container'] = $e[0];
            $d['port'] = $e[1] ?? '';

        } else {

            if(!empty($ss[1]))
                $d['value'] = $ss[1];

            if(!empty($ss[2]))
                $d['value2'] = $ss[2];

        }
//        foreach( $block )
//        $d = explode(',',trim(str_replace(['{',' '],['',''],$string)));
        return $d;
    }


    public static function parseConfigFile( Request $request, $path = ''): array {

        $return = [];
        //        $d = file_get_contents();
//        $return =        $files = Storage::files('caddy');
//        $d = explode("\n", Storage::get('caddy/Caddyfile'));
        $d = explode("\n", Storage::get('caddy_prod/Caddyfile'));
        $block = 1;

        foreach($d as $v) {

            // убираем пустые строки и комментарии
            if(empty($v) || substr(trim($v), 0, 1) == '#')
                continue;

            if(substr(trim($v), 0, 1) == '}') {
                $block++;
            } else {
                $return[$block][] = $v;
            }

        }

        $return2 = [];

        foreach($return as $block) {

//            $block['domains'] = self::getFromBlockDomains($block[0]);
            $return2[] = self::getFromBlockAllParams($block, $request);
        }

        return $return2;
    }
}
