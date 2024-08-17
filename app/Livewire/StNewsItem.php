<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StNews;

class StNewsItem extends Component
{
    public $newsItem;
    public $isDeleted = false;

    public function mount(StNews $newsItem)
    {
        $this->newsItem = $newsItem;
    }

    public function deleteNews()
    {
        $this->newsItem->delete();
        $this->isDeleted = true;
    }

    public function render()
    {
        return view('livewire.st-news-item');
    }
}
