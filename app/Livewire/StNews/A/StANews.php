<?php

namespace App\Livewire\StNews\A;

use App\Models\StNews;
use Livewire\Component;

class StANews extends Component
{
    public $list_news = [];

    function mount()
    {
        $this->list_news = StNews::with('site','photos')
            ->whereSite_id(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.st-news.a.st-a-news');
    }
}
