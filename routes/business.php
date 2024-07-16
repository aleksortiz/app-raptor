<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){

    Route::middleware('permission:reporte-finanzas')
    ->get('/reporte-finanzas', function(){
        return view('livewire.business.finance-dashboard.index');
    });

    Route::get('reporte-facturas', function(){
        return view('livewire.business.reporte-facturas.index');
    });

});

