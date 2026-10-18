<?php

namespace App\Livewire\Ttt;

use App\Models\TttBilliardClub;
use Livewire\Component;

class WhereToPlay extends Component
{
    public function render()
    {
        return view('livewire.ttt.where-to-play', [
            'clubs' => TttBilliardClub::query()->active()->ordered()->get(),
        ]);
    }
}
