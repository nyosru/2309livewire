<?php

namespace App\Livewire\Ar;

use App\Models\ArPay;
use Livewire\Component;

class PayAddForm extends Component
{
    public $date = '';
    public $amount = 0;
    public $object_id = '';
    public $people_id = '';
    public $opis = '';
    public $show = false;
    public $show_ar = [];
    public $message = '';

    public function mount()
    {
        $this->date = date('Y-m-d');
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }

    public function toggleShowAr($nomer = 1)
    {
        $this->show_ar[$nomer] = isset($this->show_ar[$nomer]) ? !$this->show_ar[$nomer] : true;
    }

    public function addPay()
    {
        ArPay::insert([
            'ar_object_id' => $this->object_id,
            'ar_people_id' => $this->people_id,
            'amount' => $this->amount,
            'date' => $this->date,
            'opis' => $this->opis,
        ]);

        session()->flash('message', 'Добавлено! '.$this->amount.' '.$this->date."         <script>
            document.addEventListener('DOMContentLoaded', function() {
                let dateInput = document.getElementById('date-input');
                if (dateInput) {
                    dateInput.focus();
                }
            });
        </script>
" );
    }

    public function render()
    {
        return view('livewire.ar.pay-add-form');
    }
}
