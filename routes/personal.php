<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Personal\PersonalController;

// Public API route for destajos
Route::get('/api/destajos', [PersonalController::class, 'getDestajos']);
Route::get('/api/generate-token', [PersonalController::class, 'generateToken']);

// View for destajos
Route::get('/api/destajos/view', function () {
    return view('personal.destajos');
});

Route::middleware(['auth'])->prefix('personal')->group(function () 
{
    Route::get('/', function(){
        return view('livewire.personal.catalogo-personal.index');
    });

    Route::get('/diagrama-nomina', function(){
        return view('livewire.personal.diagrama-nomina.index');
    });

    Route::get('/ordenes-trabajo', function(){
        return view('livewire.personal.admin-ordenes-trabajo.index');
    });

    Route::get('/prestamos', function(){
        return view('livewire.personal.catalogo-prestamos.index');
    });

    Route::get('/destajos', function(){
        return view('livewire.personal.catalogo-destajos.index');
    });

});

// Routes for destajos
Route::get('/destajos', function () {
    return view('personal.destajos');
});
Route::get('/generate-token', [PersonalController::class, 'generateToken']);
