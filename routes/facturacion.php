<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('control-facturacion')->group(function(){


    Route::get('/', function(){
        return view('livewire.control-facturacion.index');
    });


    Route::get('/facturas-registradas', function(){
        return view('livewire.facturacion.facturas-registradas.index');
    });

    Route::get('/importar-pdf', function(){
        return view('livewire.facturacion.importar-pdf.index');
    });

});

