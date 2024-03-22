<?php

namespace App\Livewire\Broadcast;

use App\Models\Broadcast;
use App\Models\Recipient;
use Livewire\Component;

class Create extends Component
{
    public $name;

    public $schedule_at;

    public $schedule_time;

    public $interval;

    public $fake_count;

    public function mount()
    {
        $this->fake_count = 10;
        $this->interval = "10,30";
        $this->name = "Buat fake data ke table customer";
        $this->schedule_time = [9,10,11,12,13];
    }
    public function render()
    {
        return view('livewire.broadcast.create');
    }

    public function save()
    {
        $data = $this->validate([
          'name' =>'required',
          'schedule_at' =>'required',
          'schedule_time' =>'required',
          'interval' =>'required',
          'fake_count' =>'required'
        ]);

        $data['interval'] = preg_split ("/\,/", $this->interval);

        $broadcast = Broadcast::create($data);
        
        for ($i = 0; $i < $this->fake_count; $i++) {
            $broadcast->recipients()->create([
                'name' => fake()->name,
                'email' => fake()->email,
            ]);
        }
        
        return redirect('/');
    }
}
