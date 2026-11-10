<?php

namespace App\Livewire;

use App\Models\NewsStorageNews;
use App\Models\StNews;
use Illuminate\Support\Facades\DB;
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

    public function mount($newsId = null, string $articlePath = '/news')
    {
        $this->newsId = $newsId;
        $this->articlePath = $articlePath;
    }

    public function render()
    {
        $stn = StNews::inPublicFeed()->selectRaw("id, COALESCE(news_date, DATE(published_at)) as published_at, 'stn' as origin");
        $storage = NewsStorageNews::published()
            ->selectRaw("id, COALESCE(published_at, created_at) as published_at, 'storage' as origin");

        $news = DB::query()->fromSub($stn->toBase()->unionAll($storage->toBase()), 'feed')
            ->orderByDesc('published_at')
            ->orderBy('origin')
            ->orderByDesc('id')
            ->paginate(10);

        $items = $news->getCollection()->groupBy('origin');
        $stnItems = StNews::inPublicFeed()->whereKey($items->get('stn', collect())->pluck('id')->all())
            ->get()->keyBy('id');
        $storageItems = NewsStorageNews::published()->whereKey($items->get('storage', collect())->pluck('id')->all())
            ->with(['source', 'media'])->get()->keyBy('id');

        return view('livewire.st-news-list', compact('news', 'stnItems', 'storageItems'));
    }

    public function deleteNews($newsId)
    {
        Gate::authorize('manage-stn-news');

        StNews::findOrFail($newsId)->delete();
        $this->render();
    }
}
