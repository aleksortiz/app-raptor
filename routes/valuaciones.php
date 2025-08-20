<?php

use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('valuaciones')->group(function () {

  Route::get('/', function () {
    return view('livewire.valuacion.catalogo-valuaciones.index');
  });

  Route::get('/calendario-valuaciones', function () {
    return view('livewire.valuacion.calendario-valuaciones.index');
  });

  Route::get('/{id}', function($id){
      return view('livewire.valuacion.ver-valuacion.index', compact('id'));
  });

});

Route::middleware(['auth'])->prefix('presupuestos')->group(function () {

  Route::get('/{id}/excel', [ExcelController::class, 'presupuesto']);
  Route::get('/{id}/pdf', [ExcelController::class, 'presupuestoPdf']);
  Route::get('/{id}/pdf-view', [ExcelController::class, 'presupuestoPdfView']);

});
