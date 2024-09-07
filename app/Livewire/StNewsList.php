<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StNews;
class StNewsList extends Component
{
    use WithPagination;

    public $newsId;

    protected $listeners = ['deleteNews' => 'deleteNews'];

    public function mount($newsId = null)
    {
        $this->newsId = $newsId;
    }

    public function render()
    {
//        [moderation] =>
//            [moderation_date] =>
//            [moderation_who] =>
//            [source] => https://tyumen-news.net/society/2024/08/18/402993.html
//            [moderation_required] => 1
//            [told_at] =>
//        $news = StNews::whereModeration(True)->whereModeration_required(true)->latest()->paginate(10);
        $news = StNews::whereModeration_required(true)
        ->whereModeration(true)
            ->where('content', '!=', '')
            ->latest()->paginate(10);

        return view('livewire.st-news-list', ['news' => $news]);
    }

    public function deleteNews($newsId)
    {
        StNews::findOrFail($newsId)->delete();
        $this->render();
    }
}
