<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


//use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class DomainService extends Controller {
    public static function checkDomains($domains) {

//        // Массив с доменами для проверки
//        $domains = [
//            'example.com',
//            'google.com',
//            'facebook.com',
//            'stackoverflow.com',
//            'github.com',
//            'yahoo.com',
//            'bing.com',
//            'amazon.com',
//            'microsoft.com',
//            'twitter.com',
//        ];

        $results = [];

//$nn = 0;

        // Проходимся по каждому домену
        foreach($domains as $domain) {

//            if( strpos($domain,'.local') )
//                continue;

            $httpResult = self::checkDomainProtocol($domain, 'http');
            $httpsResult = self::checkDomainProtocol($domain, 'https');

            $results[$domain] = [
                'http' => $httpResult === true ? 'ok' : 'no',
                'https' => $httpsResult === true ? 'ok' : 'no',
            ];

//            $nn++;
//            if( $nn > 5 )
//                break;

        }

        return $results;
//        return response()->json($results);
    }

    private static function checkDomainProtocol($domain, $protocol) {
        $client = new Client();

        try {
            $response = $client->request('GET', $protocol . '://' . $domain, [
                'timeout' => 5, // Установка таймаута в 1 секунду
            ]);
            $statusCode = $response->getStatusCode();
            return $statusCode >= 200 && $statusCode < 400;
        } catch(GuzzleException $e) {
            return false;
        }
    }

    public static function getWhoisData($domain) {
        // Формируем команду для выполнения whois запроса
        $command = "whois $domain";

        // Выполняем команду и сохраняем вывод в переменную
        $whois_output = shell_exec($command);

        // Возвращаем результат
        return $whois_output;
    }

}
