<?php

namespace App\Livewire\ConceptMebel;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.concept-mebel.index')
            ->layout('livewire.concept-mebel.app.body');
    }
}
