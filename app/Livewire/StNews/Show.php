<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Livewire\Component;

class Show extends Component
{
    public StNews $news;

    public function mount($id)
    {
        $this->news = StNews::inPublicFeed()->with('site')->findOrFail($id);
    }

    public function render()
    {
        $view = view('livewire.st-news.show', [
            'news' => $this->news,
        ]);

        return request()->routeIs('news-storage*.stn-show')
            ? $view->layout('livewire.news-storage.layouts.app-component', ['title' => $this->news->title])
            : $view;
    }
}
