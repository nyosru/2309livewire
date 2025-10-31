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
    protected $listeners = ['datar-parent-should-refresh' => '$refresh'];

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
