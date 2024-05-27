<?php

use App\Models\Proveedor;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('proveedores')->group(function () 
{    

    Route::middleware(['permission:administrar-proveedores|ver-proveedores'])
    ->get('/', function(){
        return view('livewire.proveedor.catalogo-proveedores.index');
    })->name('proveedores');

    Route::middleware(['permission:administrar-proveedores|ver-proveedores'])
    ->get('/{proveedor}/', function(Proveedor $proveedor){       
        return view('livewire.proveedor.edit-proveedor.index', compact('proveedor'));
    });
    
});
