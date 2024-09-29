<?php

namespace App\Livewire\StNews\A;

use App\Models\StNewsParsingSite;
use Livewire\Component;

class StNewsAMSite extends Component
{
    public $sites = [];

    // Свойства для формы добавления нового сайта
    public $site_name = '';
    public $site_url = '';
    public $scan_status = false;
    public $category_parsing_url = '';
    public $time_to_auto_publish = null;

    public function mount()
    {
        $this->loadSites();
    }

    // Метод для загрузки сайтов
    public function loadSites()
    {
        $this->sites = StNewsParsingSite::all();
    }

    // Метод для добавления нового сайта
    public function addSite()
    {
        // Валидация данных
        $validatedData = $this->validate([
            'site_name' => 'required|string|max:255',
            'site_url' => 'required|url|max:255',
            'scan_status' => 'nullable|boolean',
            'category_parsing_url' => 'nullable|url|max:255',
            'time_to_auto_publish' => 'nullable|integer|min:0',
        ]);

        // Создание новой записи
        StNewsParsingSite::create($validatedData);

        // Очистка полей формы
        $this->reset(['site_name', 'site_url', 'scan_status', 'category_parsing_url', 'time_to_auto_publish']);

        // Обновление списка сайтов
        $this->loadSites();

        // Сообщение об успехе
        session()->flash('message', 'Сайт успешно добавлен!');
    }

    // Метод для переключения статуса сканирования (true/false)
    public function toggleScanStatus($siteId)
    {
        $site = StNewsParsingSite::find($siteId);
        if ($site) {
            // Переключаем статус между true и false
            $site->scan_status = !$site->scan_status;
            $site->save();

            // Обновляем список сайтов после изменения статуса
            $this->loadSites();
        }
    }

    public function render()
    {
        return view('livewire.st-news.a.st-news-a-m-site');
    }
}
