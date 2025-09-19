<?php

namespace App\Livewire\Phpcatcom\Datar2\Admin;

use Livewire\Component;
use App\Models\DatarParent;

class DatarParentEdit extends Component
{
    public DatarParent $datarParent;

    public $title;
    public $content;
    public $order;
    public $is_active;
    public $id;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
        'order' => 'required|integer',
        'is_active' => 'boolean',
    ];

    public $layout = '';

    public function mount($id)
    {
        $this->layout = 'livewire.cfa.app.body';

//        dd($id);

        $this->datarParent = DatarParent::where('id', $id)->first();
//        $this->datarParent = $datarParent;
//dd($datarParent);
        // Инициализация полей формы текущими значениями модели
        $this->title = $this->datarParent->title;
        $this->content = $this->datarParent->content;
        $this->order = $this->datarParent->order;
        $this->is_active = $this->datarParent->is_active;
    }

    public function save()
    {
        $this->validate();

        $this->datarParent->update([
            'title' => $this->title,
            'content' => $this->content,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ]);

        session()->flash('parent_success', 'Группа изменена.');
        return redirect()->route('tech.datar2');

    }

    public function render()
    {
        $view = view('livewire.phpcatcom.datar2.admin.datar-parent-edit');
        return $this->layout ? $view->layout($this->layout) : $view;
    }
}
