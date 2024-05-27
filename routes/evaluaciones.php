<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Evaluaciones\Evaluaciones;
use App\Models\Evaluacion;

Route::middleware(['auth'])->prefix('evaluaciones')->group(function () {
  
  Route::get('/', function () {
    return view('livewire.evaluacion.catalogo-evaluaciones.index');
  });

  Route::get('/{evaluacion}', function (Evaluacion $evaluacion) {
    return view('livewire.evaluacion.ver-evaluacion.index', compact('evaluacion'));
  });

  Route::get('/adjuntar_fotos/{evaluacion}', function (Evaluacion $evaluacion) {
    return view('livewire.evaluacion.subir-fotos.index', compact('evaluacion'));
  });

  Route::get('/{evaluacion}/subir-fotos', function(Evaluacion $evaluacion){
    return view('livewire.evaluacion.subir-fotos.index', compact('evaluacion'));
});


});
