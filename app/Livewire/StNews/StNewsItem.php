<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class StNewsItem extends Component
{
    public $newsItem;

    public $isDeleted = false;

    #[Locked]
    public string $articlePath = '/news';

    public function mount(StNews $newsItem, string $articlePath = '/news')
    {
        $this->newsItem = $newsItem;
        $this->articlePath = $articlePath;
    }

    public function deleteNews()
    {
        Gate::authorize('manage-stn-news');

        $this->newsItem->delete();
        $this->isDeleted = true;
    }

    public function render()
    {
        return view('livewire.st-news.st-news-item');
    }
}
