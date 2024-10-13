<?php

namespace App\Livewire\Phpcat;

use App\Models\PhpcatDevelop;

//use App\Models\PhpcatServices;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\With\Url;

class Develop extends Component
{
    use WithPagination;

    public $show_id = null;
    public $item = null;

    #[Url(history: true)]
    public function setShowIdNull()
    {
        $this->show_id = null;
        $this->item = null;
    }

    #[Url(history: true)]
    public function setShowId(int $id)
    {
        $this->show_id = $id;
        $this->item = PhpcatDevelop::find($id);
        $this->js("document.querySelector('#develop-head').scrollIntoView({ behavior: 'smooth' }); ");
    }

    public function render()
    {
        return view('livewire.phpcat.develop', [
//            'items' => PhpcatServices::paginate(5)
//            'items' => PhpcatServices::all()
            'items' => PhpcatDevelop::all()
        ]);

    }
}
