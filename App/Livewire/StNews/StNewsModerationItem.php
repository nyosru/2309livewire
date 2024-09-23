<?php

namespace App\Livewire\StNews;

use App\Models\StNews;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StNewsModerationItem extends Component
{
    public $item;

    public function moderation( bool $new_status): void
    {
        $this->item->moderation = $new_status;
        $this->item->moderation_date = now();
        if (!empty(Auth::id())) {
            $this->item->moderation_who = Auth::id();
        }
        $this->item->save();
    }

    public function render()
    {
        return view('livewire.st-news.st-news-moderation-item');
    }

}
