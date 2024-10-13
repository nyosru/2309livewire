<?php

namespace App\Livewire\StNews\A;

use Livewire\Component;

class Index extends Component
{
    // Свойство для отслеживания текущего активного раздела
    public $activeSection = 'sites'; // 'sites' или 'catalog'

    // Метод для переключения активного раздела
    public function setActiveSection($section)
    {
        $this->activeSection = $section;
    }

    public function render()
    {
        return view('livewire.st-news.a.index');
    }
}
