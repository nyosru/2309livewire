<?php

namespace App\Livewire;

use App\Models\LarawireNews;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPostsSearch extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.show-posts-search', [
            'posts' => LarawireNews::where('title', 'like', '%'.$this->query.'%')->paginate(3),
        ]);
    }
}
