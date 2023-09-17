<?php

namespace App\Livewire\Phpcat;

use App\Models\PhpcatServices;
use Livewire\Component;
use Livewire\WithPagination;

class Services extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.phpcat.services',[
//            'items' => PhpcatServices::paginate(5)
//            'items' => PhpcatServices::all()
            'items' => PhpcatServices::get()
        ]);
    }
}
