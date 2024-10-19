<?php

namespace App\Livewire\StNews\A;

use App\Models\StNewsParsingSite;
use Livewire\Component;

class StNewsAMSite extends Component
{

    public $sites = [];
    public $site_name = '';
    public $site_url = '';
    public $category_parsing_url = '';
    public $time_to_auto_publish = 0;
    public $moderation_on_upload = false;
    public $scan_status = true;

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
            'moderation_on_upload' => 'nullable|boolean', // Добавлено поле модерации при загрузке
        ]);

        // Создание новой записи в базе данных
        StNewsParsingSite::create($validatedData);

        // Очистка полей формы после добавления
        $this->reset(['site_name', 'site_url', 'scan_status', 'category_parsing_url', 'time_to_auto_publish', 'moderation_on_upload']);

        // Обновление списка сайтов
        $this->loadSites();

        // Сообщение об успешном добавлении
        session()->flash('message', 'Сайт успешно добавлен!');
    }


    public function render()
    {
        return view('livewire.st-news.a.st-news-a-m-site');
    }
}
