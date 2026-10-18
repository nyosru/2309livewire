<?php

namespace App\Livewire\Raal;

use App\Models\RaalProject;
use Illuminate\View\View;
use Livewire\Component;

class Projects extends Component
{
    public function render(): View
    {
        return view('livewire.raal.projects', [
            'projects' => RaalProject::active()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
