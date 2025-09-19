<?php

namespace App\Livewire\Phpcatcom\Datar2\Admin;

use App\Models\Datar2;
use App\Models\DatarParent;
use Livewire\Component;
use Livewire\WithPagination;

class DatarAdmin extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $layout = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function mount()
    {
        $this->layout = 'livewire.cfa.app.body';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatusParent($id)
    {
        $parent = DatarParent::find($id);

        if ($parent) {
            $parent->update(['is_active' => !$parent->is_active]);
            $this->dispatch('item-updated');
        }
    }
public function confirmDelete(string $type, int $id)
{
    if ($type === 'parent') {
        $deleted = DatarParent::where('id', $id)->delete();

        if ($deleted) {
            session()->flash('parent_success', 'Группа удалена');
        } else {
            session()->flash('error', 'Группа не найдена или не удалена');
        }

    } elseif ($type === 'children') {
        $deleted = Datar2::where('id', $id)->delete();

        if ($deleted) {
            session()->flash('parent_success', 'Запись удалена');
        } else {
            session()->flash('error', 'Запись не найдена или не удалена');
        }
    }
}


    public function toggleStatusChild($id)
    {
        $child = Datar2::find($id);

        if ($child) {
            $child->update(['is_active' => !$child->is_active]);
            $this->dispatch('item-updated');
        }
    }

    public function render()
    {
        $parents = DatarParent::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->with(['children' => function ($query) {
                $query->orderBy('order')->orderBy('title');
            }])
            ->orderBy('order')
            ->orderBy('title')
            ->paginate($this->perPage);

        $view = view('livewire.phpcatcom.datar2.admin.datar-admin', [
            'parents' => $parents,
        ]);

        return $this->layout ? $view->layout($this->layout) : $view;
    }
}
