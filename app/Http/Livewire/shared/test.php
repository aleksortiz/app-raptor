<?php

use App\Http\Controllers\FacturaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('test')->group(function () {
    
    Route::get('/', [FacturaController::class, 'downloadXML']);

});

