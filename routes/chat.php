<?php

use App\Http\Livewire\Chat;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('chat')->group(function () 
{
    Route::get('/', Chat::class);

});
