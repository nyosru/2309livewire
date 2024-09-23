<?php
namespace App\Livewire\StNews;

use App\Models\StNews;
use Livewire\Component;

class ModerateNews extends Component
{
    public $newsToModerate;

    public function mount()
    {
        // Получаем новости, которые нуждаются в модерации
        $this->newsToModerate = StNews::where('moderation_required', true)
            ->whereNull('moderation')
            ->get();
    }

    public function render()
    {
        return view('livewire.st-news.moderate-news', [
            'newsToModerate' => $this->newsToModerate,
        ]);
    }

    public function approve($newsId)
    {
        $news = StNews::findOrFail($newsId);
        $news->moderation = true; // Одобрено
        $news->moderation_date = now();
        $news->moderation_who = auth()->id(); // ID пользователя, который одобрил
        $news->save();

        $this->mount(); // Обновляем список новостей после модерации
    }

    public function reject($newsId)
    {
        $news = StNews::findOrFail($newsId);
        $news->moderation = false; // Отклонено
        $news->moderation_date = now();
        $news->moderation_who = auth()->id(); // ID пользователя, который отклонил
        $news->save();

        $this->mount(); // Обновляем список новостей после модерации
    }


}
