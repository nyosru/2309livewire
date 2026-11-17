<?php

namespace App\Livewire\Cabinet;

use Livewire\Component;
use App\Models\BuAd;

class AdIndex extends Component
{
    public $showForm = true;

    public function mount()
    {
        $this->showForm = true;
    }

    public function toggleForm()
    {
        $this->showForm = ! $this->showForm;
    }

    public function render()
    {
        $ads = auth()->user()
            ->ads()
            ->orderBy('id', 'desc')
            ->get();

        return view('bu.cabinet.ads', [
            'ads' => $ads,
            'showForm' => $this->showForm,
        ]);
    }
}
