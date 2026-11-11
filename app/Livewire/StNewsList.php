<?php

namespace App\Livewire;

use App\Models\NewsStorageNews;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class StNewsList extends Component
{
    use WithPagination;

    public $newsId;

    #[Locked]
    public string $articlePath = '/news';

    protected $listeners = ['deleteNews' => 'deleteNews'];

    public function mount($newsId = null, string $articlePath = '/news'): void
    {
        $this->newsId = $newsId;
        $this->articlePath = $articlePath;
    }

    public function render()
    {
        $news = NewsStorageNews::inPublicFeed()
            ->with(['storageSource', 'media', 'storageMedia', 'photos'])
            ->orderByRaw('COALESCE(news_date, published_at, created_at) DESC')
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.st-news-list', compact('news'));
    }

    public function deleteNews($newsId): void
    {
        Gate::authorize('manage-stn-news');

        NewsStorageNews::findOrFail($newsId)->delete();
    }
}
