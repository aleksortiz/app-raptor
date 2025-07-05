<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth'])->group(function () 
{
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/personal/asignaciones', App\Http\Livewire\Personal\CatalogoAsignaciones::class)->name('personal.asignaciones');
    Route::get('/entrada/download-document/{id}', [App\Http\Controllers\EntradaController::class, 'downloadDocument'])->name('entrada.download-document');
    Route::get('/valuacion/download-document/{id}', [App\Http\Controllers\ValuacionController::class, 'downloadDocument'])->name('valuacion.download-document');
});
