<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('personal')->group(function () 
{
    Route::get('/', function(){
        return view('livewire.personal.catalogo-personal.index');
    });

    Route::get('/diagrama-nomina', function(){
        return view('livewire.personal.diagrama-nomina.index');
    });

    Route::get('/ordenes-trabajo', function(){
        return view('livewire.personal.admin-ordenes-trabajo.index');
    });

});
