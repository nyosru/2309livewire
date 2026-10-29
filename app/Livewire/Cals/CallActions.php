<?php

namespace App\Livewire\Cals;

use App\Models\Cals\Call;
use Livewire\Attributes\On;
use Livewire\Component;

class CallActions extends Component
{
    #[On('cals-set-call-removed')]
    public function setRemoved(int $callId, bool $removed): void
    {
        $call = Call::query()->findOrFail($callId);
        $call->is_deleted = $removed;
        $call->save();

        $this->dispatch('cals-call-status-changed', callId: $call->id, removed: $call->is_deleted);
    }

    public function render()
    {
        return view('livewire.cals.call-actions');
    }
}
