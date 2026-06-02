<?php

namespace App\Livewire\NewsStorage;

use App\Models\NewsStorageNews;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
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

        $newsList = $query->latest()->paginate(20);

        $statuses = NewsStorageNews::query()
            ->select('status')
            ->distinct()
            ->whereNotNull('status')
            ->pluck('status');

        return view('livewire.news-storage.index', [
            'newsList' => $newsList,
            'statuses' => $statuses,
        ])
            ->layout('livewire.news-storage.layouts.app-component', [
                'title' => 'News Storage'
            ]);
    }
}
