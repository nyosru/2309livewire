<?php

namespace App\Livewire\StNews;

use Livewire\Component;
use App\Models\StNews;

class Show extends Component
{
    public StNews $news;

    public function mount($id)
    {
        $this->news = StNews::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.st-news.show', [
            'news' => $this->news,
        ]);
    }
}
