<?php

namespace App\Livewire\NewsStorage;

use App\Models\NewsStorageNews;
use App\Models\NewsStorageVideoBlogRead;
use App\Models\NewsTopic;
use App\Models\NewsStorageSource;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    const STATUSES = [
        'new' => 'Новая',
        'published' => 'Опубликовано',
        'archived' => 'В архиве',
    ];

    const STATUSES_SHOW = [
        'надо рассказать' => 'Надо рассказать',
        'рассказал' => 'Рассказал',
    ];

    public string $search = '';

    public string $statusFilter = '';

    public string $statusShowFilter = '';

    public string $videoBlogReadDateFilter = '';

    public string $dateSortDirection = 'desc';

    public ?string $toastMessage = null;

    public bool $showCreateForm = false;

    public string $createTitle = '';

    public string $createSummary = '';

    public string $createContent = '';

    public string $createSourceUrl = '';

    public string $createNewsDate = '';

    public string $createStatus = 'new';

    public array $createTopicIds = [];

    public function createNews(): void
    {
        Gate::authorize('manage-stn-news');

        $validated = $this->validate([
            'createTitle' => ['required', 'string', 'max:255'],
            'createSummary' => ['nullable', 'string', 'max:10000'],
            'createContent' => ['required', 'string', 'max:100000'],
            'createSourceUrl' => ['nullable', 'url', 'max:2048'],
            'createNewsDate' => ['nullable', 'date'],
            'createStatus' => ['required', 'in:new,published,archived'],
            'createTopicIds' => ['array'],
            'createTopicIds.*' => ['integer', 'exists:news_topics,id'],
        ], [], [
            'createTitle' => 'заголовок',
            'createSummary' => 'краткое описание',
            'createContent' => 'текст новости',
            'createSourceUrl' => 'ссылка на источник',
            'createNewsDate' => 'дата новости',
            'createStatus' => 'статус',
        ]);

        $editorialSource = NewsStorageSource::firstOrCreate(
            ['url' => 'https://news.local'],
            ['name' => 'Редакция']
        );
        $sourceUrl = $validated['createSourceUrl'] ?: $editorialSource->url;
        $news = NewsStorageNews::create([
            'source_id' => $editorialSource->id,
            'url' => $sourceUrl,
            'source' => $sourceUrl,
            'title' => $validated['createTitle'],
            'summary' => $validated['createSummary'] ?: null,
            'content' => $validated['createContent'],
            'news_date' => $validated['createNewsDate'] ?: now()->toDateString(),
            'status' => $validated['createStatus'],
            'published_at' => $validated['createStatus'] === 'published' ? now() : null,
            'is_stn' => true,
        ]);

        $news->topics()->sync($validated['createTopicIds'] ?? []);
        $this->reset(['createTitle', 'createSummary', 'createContent', 'createSourceUrl', 'createNewsDate', 'createTopicIds']);
        $this->createStatus = 'new';
        $this->showCreateForm = false;
        $this->toastMessage = 'Новость добавлена';
        $this->dispatch('toast-hide');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusShowFilter()
    {
        $this->resetPage();
    }

    public function updatingVideoBlogReadDateFilter(): void
    {
        $this->resetPage();
    }

    public function updateStatus($newsId, $status)
    {
        Gate::authorize('manage-stn-news');

        NewsStorageNews::findOrFail($newsId)->changeStatus($status);

        $this->toastMessage = 'Статус обновлён';
        $this->dispatch('toast-hide');
    }

    public function updateStatusShow($newsId, $statusShow)
    {
        Gate::authorize('manage-stn-news');

        NewsStorageNews::findOrFail($newsId)->update(['status_show' => $statusShow ?: null]);

        $this->toastMessage = 'Статус показа обновлён';
        $this->dispatch('toast-hide');
    }

    public function sortByDate(): void
    {
        $this->dateSortDirection = $this->dateSortDirection === 'desc' ? 'asc' : 'desc';
        $this->resetPage();
    }

    public function updateVideoBlogRead($newsId, $date, $number): void
    {
        Gate::authorize('manage-stn-news');

        $date = $date ?: null;
        $number = $number ?: null;

        $validated = validator(
            ['date' => $date, 'number' => $number],
            ['date' => ['nullable', 'date'], 'number' => ['nullable', 'integer', 'min:1', 'max:9999']],
        )->validate();

        $news = NewsStorageNews::findOrFail($newsId);
        if (blank($validated['date']) && blank($validated['number'])) {
            $news->videoBlogRead()->delete();
        } else {
            $news->videoBlogRead()->updateOrCreate([], [
                'read_at' => $validated['date'] ?: null,
                'number' => $validated['number'] ?: null,
            ]);
        }

        $this->toastMessage = 'Данные видеоблога сохранены';
        $this->dispatch('toast-hide');
    }

    public function toggleTopic(int $newsId, int $topicId, bool $selected): void
    {
        Gate::authorize('manage-stn-news');

        $news = NewsStorageNews::findOrFail($newsId);
        if ($selected) {
            NewsTopic::active()->findOrFail($topicId);
            $news->topics()->syncWithoutDetaching([$topicId]);
        } else {
            $news->topics()->detach($topicId);
        }

        $this->toastMessage = 'Темы новости обновлены';
        $this->dispatch('toast-hide');
    }

    public function render()
    {
        $query = NewsStorageNews::query()->with([
            'storageSource', 'storageMedia', 'media', 'videoBlogRead', 'topics',
        ]);

        if ($this->search) {
            $applySearch = function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('summary', 'like', "%{$this->search}%");
            };
            $query->where(function ($q) use ($applySearch) {
                $applySearch($q);
                $q->orWhere('url', 'like', "%{$this->search}%")
                    ->orWhere('source', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->statusShowFilter) {
            $query->where('status_show', $this->statusShowFilter);
        }

        if ($this->videoBlogReadDateFilter) {
            $query->whereHas('videoBlogRead', function ($readQuery) {
                $readQuery->whereDate('read_at', $this->videoBlogReadDateFilter);
            });
        }

        if ($this->videoBlogReadDateFilter) {
            $newsList = $query
                ->orderBy(NewsStorageVideoBlogRead::query()
                    ->select('number')
                    ->whereColumn('newsstorage_news_id', 'newsstorage_news.id'))
                ->orderByRaw('COALESCE(news_date, created_at) '.$this->dateSortDirection)
                ->paginate(20);
        } else {
            $newsList = $query
                ->orderByRaw('COALESCE(news_date, created_at) '.$this->dateSortDirection)
                ->orderBy('id', $this->dateSortDirection)
                ->paginate(20);
        }

        return view('livewire.news-storage.index', [
            'newsList' => $newsList,
            'statuses' => self::STATUSES,
            'statusesShow' => self::STATUSES_SHOW,
            'topics' => NewsTopic::orderBy('name_ru')->get(),
        ])
            ->layout('livewire.news-storage.layouts.app-component', [
                'title' => 'News Storage',
            ]);
    }
}
