<?php

namespace App\Livewire;

use Livewire\Component;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Http;

class CaddyDomainFetcher extends Component
{
    public $domains = [];
    public $results = [];

    // Метод для получения доменов из контейнера Caddy
    public function fetchCaddyDomains()
    {
        // Выполняем команду для получения содержимого Caddyfile из контейнера Caddy
        $process = new Process(['docker', 'exec', 'caddy', 'cat', '/etc/caddy/Caddyfile']); // путь к Caddyfile внутри контейнера
        $process->run();

        // Проверяем, завершился ли процесс успешно
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Получаем содержимое файла
        $fileContents = $process->getOutput();

        // Парсим домены из файла
        $this->domains = $this->extractDomains($fileContents);
    }

    // Метод для извлечения доменов из содержимого Caddyfile
    private function extractDomains($fileContent)
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

                    // Добавляем домен в массив
                    if (!empty($domain)) {
                        $domains[] = $domain;
                    }
                }
            }
        }

        return $domains;
    }

    // Проверка доменов и получение расширенной информации
    public function checkDomains()
    {
        $this->results = [];
        foreach ($this->domains as $domain) {
            $this->results[$domain] = $this->checkDomain($domain);
        }
    }

    // Метод для проверки одного домена и получения расширенной информации
    private function checkDomain($domain)
    {
        $domainInfo = [
            'reachable' => false,
            'ssl_valid' => false,
            'ssl_expiry' => null,
            'ip_address' => null,
            'log_entries' => [],
            'message' => '',
        ];

        try {
            // Проверка доступности домена
            $response = Http::get('http://' . $domain);
            $domainInfo['reachable'] = $response->successful();

            // Получение IP-адреса домена
            $ipAddress = gethostbyname($domain);
            $domainInfo['ip_address'] = ($ipAddress !== $domain) ? $ipAddress : null;

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
                $domainInfo['ssl_valid'] = ($currentTime >= $validFrom && $currentTime <= $validTo);
                $domainInfo['ssl_expiry'] = date('Y-m-d H:i:s', $validTo);
            }

            // Получение логов для домена из контейнера Caddy
            $logProcess = new Process(['docker', 'logs', '--tail', '10', 'caddy']);
            $logProcess->run();
            if ($logProcess->isSuccessful()) {
                $domainInfo['log_entries'] = explode("\n", trim($logProcess->getOutput()));
            }
        } catch (\Exception $e) {
            $domainInfo['message'] = $e->getMessage();
        }

        return $domainInfo;
    }

    public function render()
    {
        return view('livewire.caddy-domain-fetcher');
    }
}
