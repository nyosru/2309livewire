<?php

namespace App\Livewire;

use App\Models\LarawireNews;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => LarawireNews::paginate(2),
        ]);
    }
}
