<?php

use App\Livewire\Broadcast;
use App\Livewire\Broadcast\Listing;
use Illuminate\Support\Facades\Route;

Route::get('/', Broadcast\Listing::class);
Route::get('/create', Broadcast\Create::class);
