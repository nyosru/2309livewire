<?php

namespace App\Http\Livewire\Skidki;

use Livewire\Component;
use App\Models\SkidkiItem as Skidki;
use Carbon\Carbon;

class SkidkiComponent extends Component
{
    public $date;
    public $type;
    public $phone;
    public $author;
    public $skidkis;
    public $skidki_all = [];

    public function render()
    {
        $this->skidki_all = Skidki::all();
//        dd([111, $this->skidkis]);
//        return view('livewire.skidki.skidki-component',['skidki_all' => $skidki_all]);
        return view('livewire.skidki.skidki-component');
    }

    public function addSkidka()
    {
        $this->validate([
            'date' => 'required|date',
            'type' => 'required|string',
            'phone' => 'required|string',
            'author' => 'required|string',
        ]);

        Skidki::create([
            'date' => Carbon::parse($this->date),
            'type' => $this->type,
            'phone' => $this->phone,
            'author' => $this->author,
        ]);

        $this->reset(['date', 'type', 'phone', 'author']);
    }

    public function deleteSkidka($id)
    {
        Skidki::find($id)->delete();
    }
}
