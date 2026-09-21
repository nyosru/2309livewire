<?php

namespace App\Livewire\NewsStorage;

use App\Models\NewsStorageNews;
use Livewire\Component;

class Show extends Component
{
    public NewsStorageNews $news;

    public function mount($id)
    {
        $this->news = NewsStorageNews::with(['source', 'media'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.news-storage.show')
            ->layout('livewire.news-storage.layouts.app-component', [
                'title' => $this->news->title.' — News Storage',
            ]);
    }
}
