<?php

namespace App\Livewire\Afisha;

use Livewire\Component;
use App\Models\Poster;

class PosterDetail extends Component
{
    public $posterId;
    public $poster;

    public function mount($posterId)
    {
        $this->posterId = $posterId;
        $this->poster = Poster::with('images')->find($posterId);
    }

    public function render()
    {
        return view('livewire.afisha.poster-detail');
    }
}
