<?php

namespace App\Livewire\Phpcatcom\Datar2\Admin;

use App\Models\Datar2;
use App\Models\DatarParent;
use Livewire\Component;

class DatarAdminItem extends Component
{

    public $parent;
    protected $listeners = ['datar-children-should-refresh' => 'refreshUp'];

    public function refreshUp(){
        $this->dispatch('datar-parent-should-refresh');
    }

    public function confirmDelete(int $id)
    {
        $deleted = DatarParent::where('id', $id)->delete();

        if ($deleted) {
            session()->flash('parent_success', 'Группа удалена');
        } else {
            session()->flash('error', 'Группа не найдена или не удалена');
        }
        $this->dispatch('datar-parent-should-refresh');
    }

    public function toggleStatusParent($id)
    {
//        $parent = DatarParent::find($id);

//        if ($parent) {
            $this->parent->update(['is_active' => !$this->parent->is_active]);
//            $this->dispatch('item-updated');
            $this->parent = DatarParent::find($id);
//        }
    }

    public function render()
    {
        return view('livewire.phpcatcom.datar2.admin.datar-admin-item');
    }
}
