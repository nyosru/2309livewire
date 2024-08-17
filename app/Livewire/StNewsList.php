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
        $news = StNews::latest()->paginate(10);

        return view('livewire.st-news-list', ['news' => $news]);
    }

    public function deleteNews($newsId)
    {
        StNews::findOrFail($newsId)->delete();
        $this->render();
    }
}
