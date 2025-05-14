<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PdfController;
use App\Models\Entrada;
use App\Models\EntradaInventario;
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

    Route::get('/servicios/{entrada}/subir-fotos', function(Entrada $entrada){
        return view('livewire.entrada.subir-fotos.index', compact('entrada'));
    });

    Route::get('/servicios/{entrada}/area-trabajo', function(Entrada $entrada){
        return view('livewire.entrada.edit-area-trabajo.index', compact('entrada'));
    });

    Route::get('/servicios/{entrada}/final-checklist', function(Entrada $entrada){
        return view('livewire.entrada.final-checklist.index', compact('entrada'));
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
    Route::get('/servicios/{entrada}/final-checklist-pdf', [PdfController::class, 'final_checklist_pdf']);

    Route::get('/inventarios', function(){
      return view('livewire.entrada-inventario.catalogo-inventarios.index');
    });

    Route::get('/registro-inventario', function(){
      return view('livewire.entrada.capturar-entrada-inventario.index');
    });

    Route::get('/inventarios/{inventario}/pdf', [PdfController::class, 'inventario_pdf']);
    Route::get('/inventarios/{inventario}/tomar-fotos', function(EntradaInventario $inventario){
        return view('livewire.entrada-inventario.tomar-fotos-inventario.index', compact('inventario'));
    });

    Route::get('/registrar-cita-reparacion', function(){
        return view('livewire.entrada.crear-cita-reparacion.index');
    });

    Route::get('/citas-reparacion', function(){
        return view('livewire.entrada.catalogo-citas-reparacion.index');
    });

    Route::get('/calendario-citas', function(){
        return view('livewire.calendario-citas.index');
    });

    Route::get('/vehiculos-piso/excel', [ExcelController::class, 'vehiculosPiso']);



});
