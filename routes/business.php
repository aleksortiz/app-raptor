<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){

    Route::middleware('permission:reporte-finanzas')
    ->get('/reporte-finanzas', function(){
        return view('livewire.business.finance-dashboard.index');
    });

    Route::middleware('permission:reporte-finanzas')
    ->get('/reporte-finanzas-v2', function(){
        return view('livewire.business.finance-dashboard-v2.index');
    });

    Route::get('reporte-facturas', function(){
        return view('livewire.business.reporte-facturas.index');
    });

    Route::get('ingresos', function(){
        return view('livewire.business.capturar-ingresos.index');
    });

    Route::get('egresos', function(){
        return view('livewire.business.capturar-egresos.index');
    });

    Route::get('/facturacion/semanal', function () {
        return view('livewire.facturacion.index');
    })->name('facturacion.semanal');

});

