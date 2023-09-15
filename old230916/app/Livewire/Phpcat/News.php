<?php

namespace App\Livewire\Phpcat;

use App\Models\PhpcatNews;
use Livewire\Component;
use Livewire\WithPagination;

class News extends Component
{

    use WithPagination;
    // public $data = [];


    public function render()
    {
        return view('livewire.phpcat.news',[
            // 'data' => PhpcatNews::all()
            'items' => PhpcatNews::paginate(5)
        ]);
    }
}
