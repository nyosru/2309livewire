<?php

namespace App\Livewire\ar;

use App\Livewire\Phpcat\Url;
use App\Models\ArObject;
use App\Models\VkFileHistory;
use Livewire\Component;
use Livewire\WithPagination;

class table extends Component
{

    use WithPagination;

    protected $listeners = ['payAdded' => '$refresh'];

    public $oo = [];

    public $count = 0;
    public $results = [];
    #[Url]
    public $filterBig = 0;
    #[Url(history: true)]
    public $searchTxt = '';

    public function onoff($nn)
    {
        $this->oo[$nn] = empty($this->oo[$nn]) ? true : false;
    }

    public function render()
    {
        $objects = ArObject::with(
            [
                'prices' => function ($query) {
                    $query->orderBy('date_start', 'asc');
                },
                'prices.man' => function ($query) {
                    $query->with([
                        'payes' => function ($query) {
                            $query->orderBy('date', 'desc'); // Сортировка payes по полю date
                        }
                    ]);
                },
            ]
        )->orderBy('adres', 'desc')
            ->orderBy('nomer', 'asc')
            ->get();

//        dd($objects);

        return view(
            'livewire.ar.table',
            [
                'objects' => $objects
            ]
        );
    }
}
