<?php
namespace App\Livewire\Ar;

use App\Models\ArObject;
use Livewire\Component;

class ObjectAddForm extends Component
{
    public $nomer;
    public $adres;
    public $adres_list;
    public $opis;
    public $showForm = false; // Добавляем переменную состояния

    protected $rules = [
        'nomer' => 'required|string|max:255',
        'adres' => 'nullable|string|max:255',
        'opis' => 'nullable|string',
    ];

    public function toggleForm()
    {
        $this->showForm = !$this->showForm; // Метод для переключения видимости формы
    }

    public function submit()
    {
        $this->validate();

        ArObject::create([
            'nomer' => $this->nomer,
            'adres' => $this->adres_list == 'new' ? $this->adres : $this->adres_list,
            'opis' => $this->opis,
        ]);

        session()->flash('message', 'Объект успешно добавлен.');

        // Сбросить форму после успешного добавления
        $this->reset();
    }

    public function render()
    {
        $uniqueAddresses = ArObject::select('adres')->distinct()->orderBy('adres', 'desc')->get();

        return view('livewire.ar.object-add-form',[
            'uniqueAddresses' => $uniqueAddresses
        ]);
    }
}
