<?php

namespace App\Livewire\StNews;

use Livewire\Component;
use App\Models\StNews;
use Illuminate\Support\Facades\Auth;

class StNewsModeration extends Component
{
    public $news;

    public function mount()
    {
        // Получение новостей на модерации
        $this->news = StNews::whereModerationRequired(true)
            ->whereNull('moderation')
            ->get();
    }

    public function render()
    {
        return view('livewire.st-news.st-news-moderation');
    }
}
