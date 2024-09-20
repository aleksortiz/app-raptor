<?php

use App\Http\Controllers\PdfController;
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

    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/pedidos', function(){
        return view('livewire.pedido.catalogo-pedidos.index');
    });

    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/crear-pedido', function(){
        return view('livewire.pedido.crear-pedido.index');
    });

    Route::get('/pedido_pdf/{pedido}', [PdfController::class, 'pedido_pdf']);

    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/vales', function(){
        return view('livewire.material.catalogo-vales.index');
    });

    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/vales/crear-vale', function(){
        return view('livewire.material.crear-vale-material.index');
    });

    Route::middleware('permission:administrar-materiales|ver-materiales')
    ->get('/vales/{vale}/pdf', [PdfController::class, 'vale_material_pdf']);
});
