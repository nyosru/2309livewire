<?php

namespace App\Livewire\Afisha;

use App\Models\AfishaPoster;
use Livewire\Component;

class PosterDetail extends Component
{
    public $posterId;

    public $poster;

    public function mount($posterId)
    {
        $this->poster = AfishaPoster::with('images')->find($posterId);
    }

    public function render()
    {
        return view('livewire.afisha.poster-detail');
    }
}
