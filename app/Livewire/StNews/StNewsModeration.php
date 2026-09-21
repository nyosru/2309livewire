<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use App\Services\StNews\AutoModerationNewsServices;
use Livewire\Component;

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

    public function m()
    {
        $e = new AutoModerationNewsServices;
        $ee = $e->autoModerateNews();

        return response()->json([1 => 2,
            'res' => $ee,
        ]);
    }
}
