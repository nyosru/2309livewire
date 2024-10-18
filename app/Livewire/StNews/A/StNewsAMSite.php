<?php

namespace App\Livewire\StNews\A;

use App\Models\StNewsParsingSite;
use Livewire\Component;

class StNewsAMSite extends Component
{
    public $sites = [];

    public function mount()
    {
        $this->loadSites();
    }

    // Метод для загрузки сайтов
    public function loadSites()
    {
        $this->sites = StNewsParsingSite::all();
    }

    public function render()
    {
        return view('livewire.st-news.a.st-news-a-m-site');
    }
}
