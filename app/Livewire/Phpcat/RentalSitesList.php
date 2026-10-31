<?php

namespace App\Livewire\Phpcat;

use App\Models\PhpcatRentalSite;
use Livewire\Component;

class RentalSitesList extends Component
{
    public function render()
    {
        return view('livewire.phpcat.rental-sites-list', [
            'sites' => PhpcatRentalSite::query()
                ->where('is_visible', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }
}
