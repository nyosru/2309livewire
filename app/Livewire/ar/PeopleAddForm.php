<?php

namespace App\Livewire\Ar;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\ArPeople;
use App\Models\ArPrice;
use App\Models\ArObject;

class PeopleAddForm extends Component
{
    public $name;
    public $phone;
    public $phone2;
    public $opis;

    public $ar_object_id;
    public $price;
    public $date_start;
    public $price_opis;
    public $arObjects = [];
    public $now_object = null;
    public $isFormVisible = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required',
        'phone2' => 'nullable',
        'opis' => 'nullable|string',
        'price' => 'required|numeric',
        'date_start' => 'required|date',
        'price_opis' => 'nullable|string',
    ];

    public function mount($now_object = null)
    {
        $this->now_object = $now_object;
        if (!$this->now_object) {
            $this->arObjects = ArObject::all(); // Загрузка всех объектов для выпадающего списка
        }

        // Установка текущей даты по умолчанию
        $this->date_start = Carbon::now()->format('Y-m-d');
    }

    public function submit()
    {
        $this->validate();

        // Создание записи в ArPeople
        $person = ArPeople::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'phone2' => $this->phone2,
            'opis' => $this->opis,
        ]);

        // Создание записи в ArPrice
        ArPrice::create([
            'ar_object_id' => $this->now_object ?? $this->ar_object_id, // Используем $now_object, если он установлен
            'ar_people_id' => $person->id,
            'price' => $this->price,
            'date_start' => $this->date_start,
            'opis' => $this->price_opis,
        ]);

        session()->flash('message', 'Запись успешно добавлена.');

        // Сброс формы после успешного добавления
        $this->reset();
        $this->isFormVisible = false;
    }

    public function toggleForm()
    {
        $this->isFormVisible = !$this->isFormVisible;
    }

    public function render()
    {
        return view('livewire.ar.people-add-form');
    }
}
