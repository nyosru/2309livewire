<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class CaddyfileDomainChecker extends Component
{
    public $domains = [];
    public $results = [];

    // Метод для парсинга файла Caddyfile и получения списка доменов
    public function parseCaddyfile()
    {
//        $caddyfilePath = base_path('Caddyfile'); // путь к файлу Caddyfile
        $caddyfilePath = storage_path('app/caddy/prod.Caddyfile'); // путь к файлу Caddyfile
//        dd($caddyfilePath);
        //$caddyfilePath = storage_path('app/caddy/dev.Caddyfile'); // путь к файлу Caddyfile
        if (file_exists($caddyfilePath)) {
            $fileContents = file_get_contents($caddyfilePath);
//            dd($fileContents);

            $this->domains = $this->extractDomains($fileContents);
        } else {
            session()->flash('error', 'Файл Caddyfile не найден.');
        }
    }

    // Метод для извлечения доменов из содержимого Caddyfile
    function extractDomains($fileContent)
    {
        // Разбиваем содержимое файла на строки
        $lines = explode("\n", $fileContent);

        $domains = [];

        foreach ($lines as $line) {
            // Удаляем пробелы в начале и конце строки
            $line = trim($line);

            // Пропускаем комментарии и пустые строки
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }

            // Проверяем, что строка заканчивается символом {
            if (substr($line, -1) === '{') {
                // Убираем символ { в конце
                $line = rtrim($line, '{');

                // Убираем пробелы вокруг доменов
                $line = trim($line);

                // Разбиваем строку по запятой, чтобы учесть несколько доменов
                $domainList = explode(',', $line);

                foreach ($domainList as $domain) {
                    // Убираем пробелы вокруг домена
                    $domain = trim($domain);

                    if (!$this->checkDomainString($domain)) {
                        continue;
                    }

                    // Добавляем домен в массив
                    if (!empty($domain)) {
                        $domains[] = $domain;
                    }
                }
            }
        }

        return $domains;
    }


    // Метод для проверки доступности доменов и SSL
    public function checkDomains()
    {
        $this->results = [];
        foreach ($this->domains as $domain) {
            $this->results[$domain] = $this->checkDomain($domain);
        }
    }

    function checkDomainString($domain)
    {
        // Убираем пробелы вокруг домена
        $domain = trim($domain);

        // Определяем регулярное выражение для валидации домена
        $pattern = '/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/';

        // Дополнительное регулярное выражение для проверки Punycode доменов
        $punycodePattern = '/^xn--[a-zA-Z0-9-.]+$/';

        // Проверка домена на соответствие основному шаблону или Punycode шаблону
        if (strpos($domain,'.рф')) {
            return true;
        }

        if (preg_match($pattern, $domain)) {
            return true;
        }

        if (preg_match($punycodePattern, $domain)) {
            return true;
        }

        // Домен не прошёл проверку
        return false;
    }

    // Метод для проверки одного домена
    private function checkDomain($domain)
    {
        $domainStatus = [
            'reachable' => false,
            'ssl_valid' => false,
            'message' => '',
        ];

//
//        if (!$this->checkDomainString($domain)) {
//            return $domainStatus;
//        }

        try {
            // Проверка доступности домена
            $response = Http::get($domain);
            $domainStatus['reachable'] = $response->successful();

            // Проверка SSL сертификата
            $streamContext = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
            $resource = @stream_socket_client(
                "ssl://{$domain}:443",
                $errno,
                $errstr,
                30,
                STREAM_CLIENT_CONNECT,
                $streamContext
            );
            if ($resource) {
                $params = stream_context_get_params($resource);
                $cert = openssl_x509_parse($params["options"]["ssl"]["peer_certificate"]);
                $validFrom = $cert['validFrom_time_t'];
                $validTo = $cert['validTo_time_t'];

                $currentTime = time();
                $domainStatus['ssl_valid'] = ($currentTime >= $validFrom && $currentTime <= $validTo);
            }
        } catch (\Exception $e) {
            $domainStatus['message'] = $e->getMessage();
        }

        return $domainStatus;
    }

    public function render()
    {
        return view('livewire.caddyfile-domain-checker');
    }
}
