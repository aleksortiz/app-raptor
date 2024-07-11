<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('refacciones')->group(function () {

    Route::get('/reporte-comisiones', function(){
        return view('livewire.refaccion.reporte-comisiones.index');
    });
});
