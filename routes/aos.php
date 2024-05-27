<?php

use App\Models\aoscore\SupportTicket;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('aos')->group(function () 
{    

    Route::middleware(['permission:tickets-soporte'])
    ->get('/tickets-soporte', function(){
        return view('livewire.aoscore.support-tickets-catalogue.index');
    });

    Route::middleware(['permission:tickets-soporte'])
    ->get('/tickets-soporte/{ticket}', function(SupportTicket $ticket){
        return view('livewire.aoscore.view-support-ticket.index', compact('ticket'));
    });
    
});
