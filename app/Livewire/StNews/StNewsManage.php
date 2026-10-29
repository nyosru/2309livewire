<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Админка новостей: все новости (опубликованные + черновики),
 * поиск по заголовку/тексту, фильтр, пагинация, публикация/снятие.
 */
class StNewsManage extends Component
{
    use WithPagination;

    public $search = '';

    // all | published | draft
    public $filter = 'all';

    public $perPage = 15;

    protected $queryString = ['search', 'filter'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = StNews::query()
            ->with(['media', 'coverPhoto'])
            ->orderByDesc('published_at')
            ->orderByDesc('id');

        if ($this->search !== '') {
            $like = '%'.$this->search.'%';
            $query->where(function ($q) use ($like) {
                $q->where('title', 'like', $like)
                    ->orWhere('content', 'like', $like);
            });
        }

        if ($this->filter === 'published') {
            $query->whereNotNull('published_at');
        } elseif ($this->filter === 'draft') {
            $query->whereNull('published_at');
        }

        $news = $query->paginate($this->perPage);

        return view('livewire.st-news.st-news-manage', ['news' => $news]);
    }

    /**
     * Ручная публикация/снятие с публикации из админ-панели (в любой момент).
     */
    public function togglePublish($id): void
    {
        $news = StNews::findOrFail($id);
        $news->update([
            'published_at' => $news->published_at ? null : now(),
        ]);
    }

    public function deleteNews($id): void
    {
        StNews::findOrFail($id)->delete();
    }
}
