<?php

namespace App\Livewire\AsPhpCatCom;

use App\Http\Controllers\Service\DomainService;
use App\Models\WhoisDomain;
use Livewire\Component;

class Whois extends Component
{

    public $domain = '';
    public $loading = '';
    public $domain_whois = '';
    public $domain_whois0 = '';

    public function getWhois()
    {
        $this->loading = true;

//        $this->domain_whois = $this->domain.'777';


// Информация о домене
// С доменами сложнее, т.к. нужно отправлять TCP запрос на WHIOS-сервер в зависимости от зоны домена. Полный список серверов на https://www.whois365.com/en/listtld/.

        $server = 'whois.tcinet.ru';
//        $host = 'yandex.ru';
        $host = $this->domain;

        $socket = fsockopen($server, 43);
        if ($socket) {
            fputs($socket, $host);

            $this->domain_whois0 = '';
            while (!feof($socket)) {
                $this->domain_whois0 .= fgets($socket, 128);
            }
            fclose($socket);
//            echo $text;
//            $this->domain_whois0 = $text;

            $pattern = "/(.*)free-date: (\d{4}-\d{2}-\d{2})/";

            if( strpos($this->domain_whois0, 'REGISTERED' ) ){
                $this->domain_whois = '<Span class="bg-green-500">Зареген</Span>';
            }
            elseif( strpos($this->domain_whois0, 'No entries found for the selected source' ) ){
                $this->domain_whois = '<span class="bg-yellow-500">Не Зареген</span>';
            }

// Используем функцию preg_match для поиска соответствия регулярному выражению
            if (preg_match($pattern, $this->domain_whois0, $matches)) {
                // $matches[1] содержит найденную дату
                $free_date = $matches[1];
                $this->domain_whois .= "<br/>Дата освобождения: " . $free_date;
            }
//            else {
//                $this->domain_whois = "Домен не занят";
//            }
//            $this->domain_whois = $text;
        }
//        $this->domain_whois = DomainService::getWhoisData($this->domain);

//        history_whois
        WhoisDomain::insert([
            'domain' =>$this->domain,
            'data'=> $this->domain_whois,
            'data_json'=> explode("\n",trim($this->domain_whois0)) ,
        ]);

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.as-php-cat-com.whois');
    }
}
