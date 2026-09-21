<?php

namespace App\Livewire\NewsStorage;

use App\Models\NewsStorageNews;
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

    public ?string $toastMessage = null;

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

    public function updateStatus($newsId, $status)
    {
        NewsStorageNews::findOrFail($newsId)->update(['status' => $status]);

        $this->toastMessage = 'Статус обновлён';
        $this->dispatch('toast-hide');
    }

    public function updateStatusShow($newsId, $statusShow)
    {
        NewsStorageNews::findOrFail($newsId)->update(['status_show' => $statusShow ?: null]);

        $this->toastMessage = 'Статус показа обновлён';
        $this->dispatch('toast-hide');
    }

    public function render()
    {
        $query = NewsStorageNews::query()->with(['source', 'media']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('summary', 'like', "%{$this->search}%")
                    ->orWhere('url', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->statusShowFilter) {
            $query->where('status_show', $this->statusShowFilter);
        }

        $newsList = $query->latest()->paginate(20);

        return view('livewire.news-storage.index', [
            'newsList' => $newsList,
            'statuses' => self::STATUSES,
            'statusesShow' => self::STATUSES_SHOW,
        ])
            ->layout('livewire.news-storage.layouts.app-component', [
                'title' => 'News Storage',
            ]);
    }
}
