<?php

namespace App\Livewire\Uprav\R01;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class DomainList extends Component
{
    public $domains = [];

    protected $apiUrl = 'https://api.r01.ru/wsdl';  // Замените на правильный URL WSDL для R01 API
    protected $login = 'your-login';               // Логин R01
    protected $password = 'your-password';         // Пароль R01

    public function mount()
    {
        $this->login = env('R01_LOGIN');
        $this->password = env('R01_PASSWORD');
        $this->fetchDomains();
    }

    public function fetchDomains()
    {
        try {
            // Настройка SOAP клиента
            $client = new \SoapClient($this->apiUrl, [
                'login' => $this->login,
                'password' => $this->password,
                'trace' => 1,
            ]);

            // Выполняем запрос к SOAP API R01
            $response = $client->__soapCall('getDomains', [
                'credentials' => [
                    'username' => $this->login,
                    'password' => $this->password,
                ]
            ]);

            // Проверяем ответ и сохраняем список доменов
            if (!empty($response->domains)) {
                $this->domains = $response->domains;
            } else {
                $this->domains = ['error' => 'Не удалось получить список доменов'];
            }
        } catch (\Exception $e) {
            $this->domains = ['error' => 'Ошибка SOAP: ' . $e->getMessage()];
        }
    }

    public function render()
    {
        return view('livewire.uprav.r01.domain-list');
    }
}
