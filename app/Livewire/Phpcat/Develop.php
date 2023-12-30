<?php

namespace App\Livewire\Phpcat;

use App\Models\PhpcatDevelop;
//use App\Models\PhpcatServices;
use Livewire\Component;
use Livewire\WithPagination;

class Develop extends Component
{
    use WithPagination;

    public function render()
    {

        return view('livewire.phpcat.develop',[
//            'items' => PhpcatServices::paginate(5)
//            'items' => PhpcatServices::all()
            'items' => PhpcatDevelop::all()
        ]);

    }
}
