<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('refacciones')->group(function () {

    Route::get('/', function(){
        return view('livewire.refaccion.catalogo-refacciones.index');
    });

    // Route::middleware(['permission:reporte-comisiones'])
    // ->get('/reporte-comisiones', function(){
    //     return view('livewire.refaccion.reporte-comisiones.index');
    // });


});
