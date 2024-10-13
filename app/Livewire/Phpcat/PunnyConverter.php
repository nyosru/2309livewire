<?php

namespace App\Livewire\Phpcat;

use Livewire\Component;

class PunnyConverter extends Component
{
    public $domain = ''; // Обычный домен
    public $encodedDomain = ''; // Закодированный домен

    // Метод для обновления домена
    public function updatedDomain($value)
    {
        // Удаляем "http://", "https://" и "/"
        $cleanedValue = $this->cleanDomain($value);
        $this->domain = $cleanedValue;
        $this->encodedDomain = idn_to_ascii($cleanedValue); // Кодируем домен в Punycode
    }

    // Метод для обновления закодированного домена
    public function updatedEncodedDomain($value)
    {
        // Удаляем "http://", "https://" и "/"
        $cleanedValue = $this->cleanDomain($value);
        $this->encodedDomain = $cleanedValue;
        $this->domain = idn_to_utf8($cleanedValue); // Расшифровываем Punycode в обычный домен
    }

    // Функция для удаления "https://", "http://" и "/"
    private function cleanDomain($value)
    {
        $value = str_replace(['https://', 'http://'], '', $value); // Удаляем протоколы
        return rtrim($value, '/'); // Удаляем конечные "/"
    }

    public function render()
    {
        return view('livewire.phpcat.punny-converter');
    }
}
