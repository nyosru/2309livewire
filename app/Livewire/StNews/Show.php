<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Livewire\Component;

class Show extends Component
{
    public StNews $news;

    public function mount($id)
    {
        $this->news = StNews::with('site')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.st-news.show', [
            'news' => $this->news,
        ]);
    }
}
