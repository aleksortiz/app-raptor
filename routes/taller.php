<?php

use App\Models\aoscore\SupportTicket;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('taller')->group(function () 
{
    Route::get('/pendientes', function(){
        return view('livewire.taller.catalogo-pendientes.index');
    });

});
