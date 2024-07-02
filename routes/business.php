<?php


use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){

    Route::middleware('permission:reporte-finanzas')
    ->get('/reporte-finanzas', function(){
        return view('livewire.business.finance-dashboard.index');
    });

});

