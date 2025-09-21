<?php

namespace App\Livewire\Phpcatcom\Datar2;

use Livewire\Component;

class DatarListHeadItem extends Component
{

    public $parent;

    public function selectParent()
    {
        $this->dispatch('select-parent', ['parentId' => $this->parent->id]);
    }

    public function render()
    {
        return view('livewire.phpcatcom.datar2.datar-list-head-item');
    }
}
