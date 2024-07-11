<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('servicio-flotillas')->group(function () {

    Route::get('/', function(){
        return view('livewire.flotilla.catalogo-clientes-flotillas.index');
    });

    Route::get('/{identificador}', function($identificador){
        return view('livewire.flotilla.catalogo-flotillas.index', compact('identificador'));
    });
});
