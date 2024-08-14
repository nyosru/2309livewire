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

        // Отправка события для обновления списка объектов
//        $this->emit('objectAdded');
//        $this->emitSelf('objectAdded');

        // Сбросить форму после успешного добавления
        $this->reset();


//        // Отправить событие в браузер
//        $this->dispatchBrowserEvent('object-added');

        // Обновление родительского компонента (если `Table` является родителем)
//        $this->emitTo('ar.table', 'refreshTable');
    }

    public function render()
    {
        $uniqueAddresses = ArObject::select('adres')->distinct()->orderBy('adres', 'desc')->get();

        return view('livewire.ar.object-add-form',[
            'uniqueAddresses' => $uniqueAddresses
        ]);
    }
}
