<?php

namespace App\Livewire\Cups;

use App\Models\Krugi\Cup;
use Livewire\Component;

class Index extends Component
{
    public $cups;

    public function mount()
    {
        $this->cups = Cup::with('photos')->get();
    }

    public function render()
    {
        return view('livewire.cups.index')
            ->layout('livewire.cups.app.body');
    }
}
