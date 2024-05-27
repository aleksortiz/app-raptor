<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () 
{
    Route::get('/aseguradoras', function(){
        return view('livewire.aseguradora.catalogo-aseguradoras.index');
    });

    Route::get('/fabricantes', function(){
        return view('livewire.fabricante.catalogo-fabricantes.index');
    });

    Route::get('/marcas', function(){
        return view('livewire.marca.catalogo-marcas.index');
    });

});
