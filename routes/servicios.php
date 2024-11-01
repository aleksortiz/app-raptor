<?php

use App\Http\Controllers\PdfController;
use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function ()
{
    Route::get('/servicios', function(){
        return view('livewire.entrada.catalogo-entradas.index');
    });

    Route::get('/servicios/busqueda', function(Request $request){
        $folio = trim($request->input('folio'));
        $parts = explode('-', $folio);
        $year = date('y');

        if(count($parts) == 2){
            $folio = strlen($folio) == 5 ? ($folio . "-{$year}") : $folio;
        }

        $entrada = Entrada::where('folio', $folio)->first();
        if($entrada){
            return redirect()->to("/servicios/{$entrada->id}");
        }
        else{
            return redirect()->to("/servicios?keyWord={$folio}");
        }
    });

    Route::get('/servicios/{entrada}', function(Entrada $entrada){
        return view('livewire.entrada.ver-entrada.index', compact('entrada'));
    });

    Route::get('/servicios/{entrada}/editar', function(Entrada $entrada){
        return view('livewire.entrada.editar-entrada.index', compact('entrada'));
    });

    // Route::get('/servicios/{entrada}/inventario', function(Entrada $entrada){
    //     return view('livewire.entrada.capturar-entrada-inventario.index', compact('entrada'));
    // });

    Route::get('/registro-inventario', function(){
      return view('livewire.entrada.capturar-entrada-inventario.index');
    });

    Route::get('/servicios/{entrada}/subir-fotos', function(Entrada $entrada){
        return view('livewire.entrada.subir-fotos.index', compact('entrada'));
    });

    Route::get('/servicios/{entrada}/area-trabajo', function(Entrada $entrada){
        return view('livewire.entrada.edit-area-trabajo.index', compact('entrada'));
    });

    Route::get('/crear-entrada', function(){
        return view('livewire.entrada.crear-entrada.index');
    });

    Route::get('/vehiculos-entregados', function(){
        return view('livewire.entrada.vehiculos-entregados.index');
    });

    Route::get('/gastos-fijos', function(){
        return view('livewire.gastos-fijos.capturar-gastos-fijos.index');
    });

    Route::get('/servicios/{entrada}/pdf', [PdfController::class, 'entrada_pdf']);






});
