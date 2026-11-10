<?php

namespace App\Livewire\NewsStorage;

use App\Models\NewsStorageNews;
use Livewire\Component;

class Show extends Component
{
    public NewsStorageNews $news;

    public function mount($id)
    {
        $query = NewsStorageNews::with(['source', 'media']);

        if (request()->routeIs('*.feed-storage-show')) {
            $query->published();
        }

        $this->news = $query->findOrFail($id);
    }

    public function render()
    {
        $view = view('livewire.news-storage.show');

        if (request()->routeIs('stn.news.feed-storage-show')) {
            return $view;
        }

        return $view->layout('livewire.news-storage.layouts.app-component', [
            'title' => $this->news->title.' — News Storage',
        ]);
    }
}
