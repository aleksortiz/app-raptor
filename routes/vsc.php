<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('vsc')->group(function () {

    Route::get('/venta-vehiculos', function(){
        return view('livewire.vsc.catalogo-vehiculos.index');
    });
    
});
