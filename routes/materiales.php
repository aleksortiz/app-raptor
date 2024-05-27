<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('materiales')->group(function () 
{
    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/', function(){
        return view('livewire.material.crud-material.index');
    })->name('materiales');

    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/bitacora', function(){
        return view('livewire.material.bitacora-materiales.index');
    });
    
    // Route::get('/{id}/', [App\Http\Controllers\HomeController::class, 'index'])->name('clientes.edit');
});
