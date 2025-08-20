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

    Route::get('/requisicion-facturas', function(){
        return view('livewire.facturacion.crear-requisicion-factura.index');
    })->name('facturacion.requisiciones');

    Route::get('/requisicion-factura/{id}', function($id){
        return view('livewire.facturacion.ver-requisicion-factura.index', ['id' => $id]);
    })->name('facturacion.requisicion.ver');

});

