<?php

use App\Models\aoscore\SupportTicket;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('clientes')->group(function () 
{
    Route::get('/', function(){
        return view('livewire.cliente.catalogo-clientes.index');
    });

});
