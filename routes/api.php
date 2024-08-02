<?php

use App\Http\Controllers\ServicioFlotillaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/flotilla/{flotilla}/unidades', [ServicioFlotillaController::class, 'getUnidadesByFlotilla']);
Route::get('/vehiculos-by-cliente/{cliente}', [ServicioFlotillaController::class, 'getUnidadesByCliente']);
Route::get('/{cliente}/flotillas', [ServicioFlotillaController::class, 'getFlotillasByCliente']);

Route::post('/flotillas', [ServicioFlotillaController::class, 'createFlotilla']);
Route::post('/flotillas-unidad', [ServicioFlotillaController::class, 'createFlotillaUnidad']);
Route::post('/flotillas-servicio', [ServicioFlotillaController::class, 'createFlotillaServicio']);

