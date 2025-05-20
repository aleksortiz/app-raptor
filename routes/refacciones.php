<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('refacciones')->group(function () {

    Route::get('/', function(){
        return view('livewire.refaccion.catalogo-refacciones.index');
    })->name('refacciones.index');

    Route::get('/ver-refaccion/{refaccion}', function($refaccion){
        return view('livewire.refaccion.ver-refaccion.index', [
            'refaccion_id' => $refaccion
        ]);
    })->name('refacciones.ver');

    // Route::middleware(['permission:reporte-comisiones'])
    // ->get('/reporte-comisiones', function(){
    //     return view('livewire.refaccion.reporte-comisiones.index');
    // });


});
