<?php

namespace App\Livewire\Phpcatcom\Datar2\Admin;

use App\Models\Datar2;
use App\Models\DatarParent;
use Livewire\Component;

class DatarChildEdit extends Component
{
    public $child;
    public $title;
    public $content;
    public $parent_id;
    public $order;
    public $is_active;
    public $parents = [];

    protected $rules = [
        'title' => 'required|string|min:3|max:255',
        'content' => 'required|string|min:10',
        'parent_id' => 'required|exists:datar_parents,id',
        'order' => 'required|integer|min:0',
        'is_active' => 'boolean'
    ];

    public $layout = '';

    public function mount($id)
    {
        $this->child = Datar2::with('parent')->findOrFail($id);
        $this->title = $this->child->title;
        $this->content = $this->child->content;
        $this->parent_id = $this->child->parent_id;
        $this->order = $this->child->order;
        $this->is_active = $this->child->is_active;

        $this->parents = DatarParent::active()
            ->orderBy('order')
            ->orderBy('title')
            ->get();

        $this->layout = 'livewire.cfa.app.body';
    }

    public function save()
    {

        $this->validate();

        $this->child->update([
            'title' => $this->title,
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'is_active' => $this->is_active
        ]);

        session()->flash('children_success', 'Запись успешно обновлена');
        return redirect()->route('tech.datar2');

    }

    public function cancel()
    {
        return redirect()->route('datar2.admin');
    }

    public function render()
    {
        $view = view('livewire.phpcatcom.datar2.admin.datar-child-edit', [
            'childItem' => $this->child
        ]);
        return $this->layout ? $view->layout($this->layout) : $view;
    }
}
