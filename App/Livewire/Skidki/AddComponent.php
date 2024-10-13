<?php

namespace App\Livewire\Skidki;

use App\Models\SkidkiItem as Skidki;
use Carbon\Carbon;
use Livewire\Component;

class AddComponent extends Component
{

    public $list_type = [
        'lenta_dr' => [
            'name' => 'Лента - День рожденья по номеру телефона',
            'opis' => 'на кассе говорите - "карта по номеру телефона" или на кассе самообслуживания вводите карту по номеру телефона
            <br/>скидка 15% (несколько дней около дня рожденья) на товары на которые нет скидки'
            ,'day_start' => -2,
            'day_finish' => 5,
        ]
    ];
    public $type_list = '';
    public $type = '';

    public $phone = '';
    public $author = '';
    public $dater = '';
    public $skidki_all = [];

//    public function render()
//    {
//        $this->skidki_all = Skidki::all();
//        return view('livewire.skidki.list-component');
//    }


    public function addSkidka()
    {
        $this->validate([
            'dater' => 'required|date',
//            'type' => 'required|string',
            'phone' => 'required|string',
            'author' => 'required|string',
        ]);

        $in = [
            'date' => Carbon::parse($this->dater),
            'type' => !empty($this->type_list) ? $this->type_list : ( $this->type ?? '' ),
            'phone' => $this->phone,
            'author' => $this->author,
        ];

        if( !empty($this->list_type[$in['type']]['day_start']) ){
            $in['date_start'] = Carbon::parse($this->dater)->adddays($this->list_type[$in['type']]['day_start']);
        }

        if( !empty($this->list_type[$in['type']]['day_finish']) ){
            $in['date_finish'] = Carbon::parse($this->dater)->adddays($this->list_type[$in['type']]['day_finish']);
        }

//        ,'day_start' => -2,
//            'day_finish' => 5,

        Skidki::create($in);

        $this->reset(['dater', 'type', 'author']);
    }

    public function deleteSkidka($id)
    {
        Skidki::find($id)->delete();
    }


    public function render()
    {
        return view('livewire.skidki.add-component');
    }
}
