<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Livewire\Component;

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
        return view('livewire.st-news.st-news-item');
    }
}
