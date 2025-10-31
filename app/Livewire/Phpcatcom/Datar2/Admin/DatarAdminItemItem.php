<?php

namespace App\Livewire\Phpcatcom\Datar2\Admin;

use App\Models\Datar2;
use App\Models\DatarParent;
use Livewire\Component;

class DatarAdminItemItem extends Component
{
    public $parent;
    public $child;

    public function confirmDelete(string $type, int $id)
    {

        $deleted = Datar2::where('id', $id)->delete();

        if ($deleted) {
            session()->flash('parent_success', 'Запись удалена');
        } else {
            session()->flash('error', 'Запись не найдена или не удалена');
        }
        $this->dispatch('datar-children-should-refresh');
//        $this->child = Datar2::find($id);
    }

    public function toggleStatusChild($id)
    {
        $child = Datar2::find($id);

        if ($child) {
            $child->update(['is_active' => !$child->is_active]);
            $this->child = Datar2::find($id);
//            $this->dispatch('item-updated');
//            $this->dispatch('datar-children-should-refresh');
        }

    }

    public function render()
    {
        return view('livewire.phpcatcom.datar2.admin.datar-admin-item-item');
    }
}
