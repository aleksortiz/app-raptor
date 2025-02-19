<?php

use App\Http\Controllers\PdfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;

Route::middleware(['auth'])->prefix('vehiculos')->group(function () {

    Route::get('/', function(){
        return view('livewire.vehiculo.catalogo-vehiculos.index');
    });

    // Route::get('/contrato-compra-venta', [PdfController::class, 'contrato_compra_venta_pdf']);

    Route::get('/contrato-compra-venta', function(Request $request){
        $data = $request->all();
        return PdfController::contrato_compra_venta_pdf($data);
    });

    Route::get('/{id}', function($id){
        return view('livewire.vehiculo.ver-vehiculo.index', ['id' => $id]);
    });



});
