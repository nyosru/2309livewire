<?php

namespace App\Livewire\StNews;

use App\Models\NewsStorageNews;
use Livewire\Component;

class Show extends Component
{
    public NewsStorageNews $news;

    public function mount($id)
    {
        $this->news = NewsStorageNews::resolveLegacyOrCurrent($id);
        abort_unless($this->news->status === 'published' || $this->news->published_at, 404);
        $this->news->load(['site', 'photos', 'media']);
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
