<?php

namespace App\Livewire\Broadcast;

use App\Models\Broadcast;
use Livewire\Component;

class Listing extends Component
{
    public $broadcasts;

    public function mount()
    {
        $this->broadcasts = Broadcast::latest()->get();
    }
    public function render()
    {
        return view('livewire.broadcast.listing');
    }

    public function action(Broadcast $broadcast, $action)
    {
       $broadcast->update([
                'status' => $action == 'start' ? 'in progress' : 'pause',
        ]);

       $this->broadcasts = Broadcast::latest()->get();
    }
}
