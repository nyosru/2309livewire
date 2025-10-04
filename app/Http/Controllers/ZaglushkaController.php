<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Polyfill\Intl\Idn\Idn;

class ZaglushkaController extends Controller
{

    public function checkRedirect($host)
    {

        // Получаем текущий домен
//        $currentDomain = strtolower(request()->getHost());
        $currentDomain = strtolower($host);
//        dump($currentDomain);


        for ($i = 1; $i <= 10; $i++) {

            $host = 'REDIRECT_DOMAIN' . $i;
            $hostRedirect = 'REDIRECT_DOMAIN' . $i . '_TO';

            //            REDIRECT_DOMAIN1="blank.local"
            //REDIRECT_DOMAIN1_TO="blank2.local"

            $hostValue = env($host, '');
            $hostRedirectValue = env($hostRedirect, '');
//            dump($hostRedirect.' - '.$hostRedirectValue);

            $config = config( 'custom' );
//            dump($config[$host] ?? '-');
//            dump($config[$hostRedirect] ?? '-');

            if ( $config[$host] == $currentDomain && !empty($config[$hostRedirect])) {
//                $allowedHosts[] = $hostValue;
                return $config[$hostRedirect];
            }
        }

        // Проверяем, есть ли текущий домен в массиве
//        $isAllowed = in_array($currentDomain, $allowedHosts);

        return false;

    }


    public function show(Request $request)
    {

        if (strtolower(substr($_SERVER['HTTP_HOST'], 0, 4)) == 'www.') {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            return redirect()->away($protocol . substr($_SERVER['HTTP_HOST'], 4, 500));
        }

        if (Cache::add('domain' . strtolower($_SERVER['HTTP_HOST']), '1', 60 * 60 * 24)) {
            $msg = 'заход на пустой домен ' . $_SERVER['HTTP_HOST'];
            \nyos\Msg::sendTelegramm($msg, null, 1);
//            dd($_SERVER['HTTP_HOST']);
        }

        // проверяем, есть ли редирект
        $currentDomain = request()->getHost();
        $domainRedirect = $this->checkRedirect($currentDomain);
        if (!empty($domainRedirect)) {
            return view('zaglushka.redirect', [
                'domain' => $currentDomain,
                'domain_ru' => (function_exists('idn_to_utf8')) ? idn_to_utf8($currentDomain, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46) : $currentDomain,
//                'domainRedirect' => $domainRedirect
                'domainRedirect' =>  (function_exists('idn_to_utf8')) ? idn_to_utf8($domainRedirect, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46) : $domainRedirect,
            ]);
        } // если редиректа нет, то показываем страницу заглушки
        else {

            $ra = [
//            1,
//                38,
//                42, // ртуть
//                31,
//                26,
                25, // снег
//            16, // вода не работает
            ];
            return view('zaglushka.index', ['nn' => $ra[rand(0, sizeof($ra) - 1)]]);
        }
    }
}
