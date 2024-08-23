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
        $this->news = StNews::where('moderation', 'pending')->get();
    }

    public function approve($id)
    {
        $newsItem = StNews::findOrFail($id);
        $newsItem->moderation = 'approved';
        $newsItem->moderation_date = now();
        $newsItem->moderation_who = Auth::id();
        $newsItem->save();

        // Обновление списка после изменения
        $this->news = StNews::where('moderation', 'pending')->get();
    }

    public function reject($id)
    {
        $newsItem = StNews::findOrFail($id);
        $newsItem->moderation = 'rejected';
        $newsItem->moderation_date = now();
        $newsItem->moderation_who = Auth::id();
        $newsItem->save();

        // Обновление списка после изменения
        $this->news = StNews::where('moderation', 'pending')->get();
    }

    public function render()
    {
        return view('livewire.st-news.st-news-moderation');
    }
}
