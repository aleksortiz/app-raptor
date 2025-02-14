<?php

use App\Models\aoscore\SupportTicket;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('clientes')->group(function () 
{
    Route::get('/', function(){
        return view('livewire.cliente.catalogo-clientes.index');
    });

    Route::get('/registros-qr', function(){
        return view('livewire.cliente.catalogo-citas-qr.index');
    });

});

Route::get('/clientes/registrar-cita', function(){
    return view('livewire.cliente.crear-registro-qr.index');
});

