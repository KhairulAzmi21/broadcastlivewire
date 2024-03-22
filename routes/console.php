<?php

use App\Models\Broadcast;
use App\Models\Recipient;
use App\Models\User;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Scheduler untuk check broadcast status pending dan schedule time ni dah masuk ke belum.
Schedule::call(function () {
    Broadcast::where('status', 'pending')
        ->whereTime('schedule_at', '<=', now())
        ->get()
        ->each(function ($broadcast){
            $broadcast->update([
                'status' => 'in progress',
            ]);
        });

})->everySecond();

Schedule::call(function () {
    Broadcast::where('status','in progress')
        ->get()
        ->each(function ($broadcast) {

            $check_if_any_schedule_at_that_has_not_transferred_at = $broadcast->recipients()
                ->whereNotNull('schedule_at')
                ->whereNull('transferred_at')
                ->doesntExist();

            $check_if_within_schedule_time = in_array(now()->hour, $broadcast->schedule_time);


            if($check_if_any_schedule_at_that_has_not_transferred_at && $check_if_within_schedule_time) {

                    $broadcast->recipients()
                        ->whereNull('schedule_at')
                        ->first()
                        ->update([
                            'schedule_at' => now()->addSecond(rand($broadcast->interval[0],$broadcast->interval[1]))
                        ]);
            }
             
        });
})->everySecond();

// sini pulak kalau ada scheduled dan belum lagi process(transferred_at) . run the process.
Schedule::call(function () {
    Recipient::whereNotNull('schedule_at')
        ->whereNull('transferred_at')
        ->whereTime('schedule_at','<=', now())
        ->get()
        ->each(function ($recipient) {
            User::create([
                'name' => $recipient->name,
                'email' => $recipient->email,
                'password' => bcrypt(fake()->password()),
            ]);

            $recipient->update([
                'transferred_at' => now()
            ]);
        });
        
})->everySecond();


// dan kalau semua broadcast dah transfer . apa lagi . set broadcast as completed.
Schedule::call(function () {

    Broadcast::get()->each(function ($broadcast) {
        if($broadcast->recipients->whereNull('transferred_at')->isEmpty()) {
            $broadcast->update([
                'status' => 'completed',
            ]);
        }
    });

})->everySecond();



// Schedule::call(function () {
//     Broadcast::whereIn('status', ['in progress'])
//         ->whereJsonContains('schedule_time', now()->hour)
//         ->get()
//         ->each(function ($broadcast){
//             $broadcast->update([
//                 'status' => 'on hold',
//             ]);
//         });
// })->everySecond();

// Setiap kali ada broadcast yang in progress , check ada tak recipients yang schedule at dia kosong .
// update schedule dia, untuk dia run