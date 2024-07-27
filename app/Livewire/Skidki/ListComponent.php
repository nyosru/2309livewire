<?php

namespace App\Livewire\Skidki;

use App\Models\SkidkiItem as Skidki;
use Carbon\Carbon;
use Livewire\Component;

class ListComponent extends Component
{
    public $list_type = [
        'lenta_dr' => [
            'name' => 'Лента - День рожденья по номеру телефона',
            'mag' => 'Лента',
            'profit' => '15% на товары без скидки',
            'opis' => 'на кассе говорите - "карта по номеру телефона" или на кассе самообслуживания вводите карту по номеру телефона
            <br/>скидка 15% (несколько дней около дня рожденья) на товары на которые нет скидки'
            ,
            'day_start' => -2,
            'day_finish' => 5,
        ]
    ];
    public $type_list = '';
    public $type = '';

    public $phone = '';
    public $author = '';
    public $dater = '';
    public $skidki_all = [];
    public $pass = '';

    public function render()
    {
////        $this->skidki_all = Skidki::all();
//
////        $now_date = Carbon::now()->toDateString();
//
//// Предположим, $source_date - это исходная дата, откуда берутся день и месяц.
//        $source_date = Carbon::parse($this->dater);
//        $current_year = Carbon::now()->year;
//// Создаем новую дату с текущим годом и днем и месяцем из исходной даты.
//        $now_date = Carbon::createFromDate($current_year, $source_date->month, $source_date->day);
//
//        $this->skidki_all = Skidki::whereDate('date_start', '<=', $now_date)
//            ->whereDate('date_finish', '>=', $now_date)
//            ->get();


//// Исходные даты
//        $source_start_date = Carbon::parse($this->dater_start);
//        $source_end_date = Carbon::parse($this->dater_end);
//
//// Текущий год
//        $current_year = Carbon::now()->year;
//
//// Создаем новые даты с текущим годом
//        $start_date = Carbon::createFromDate($current_year, $source_start_date->month, $source_start_date->day);
//        $end_date = Carbon::createFromDate($current_year, $source_end_date->month, $source_end_date->day);
//
//        $this->skidki_all = Model::whereBetween('date', [$start_date, $end_date])->get();

        $currentDate = Carbon::now();
        $currentMonth = $currentDate->month;
        $currentDay = $currentDate->day;

        $this->skidki_all = Skidki::whereRaw('(MONTH(date_start) < ? OR (MONTH(date_start) = ? AND DAY(date_start) <= ?))', [$currentMonth, $currentMonth, $currentDay])
            ->whereRaw('(MONTH(date_finish) > ? OR (MONTH(date_finish) = ? AND DAY(date_finish) >= ?))', [$currentMonth, $currentMonth, $currentDay])
            ->get();

        return view('livewire.skidki.list-component');
    }


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
            'type' => !empty($this->type_list) ? $this->type_list : ($this->type ?? ''),
            'phone' => $this->phone,
            'author' => $this->author,
        ];

        if (!empty($this->list_type[$in['type']]['day_start'])) {
            $in['date_start'] = Carbon::parse($this->dater)->adddays($this->list_type[$in['type']]['day_start']);
        }

        if (!empty($this->list_type[$in['type']]['day_finish'])) {
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

}
