<?php

use App\Http\Controllers\ServicioFlotillaController;
use App\Models\Entrada;
use App\Models\GastoFijoLog;
use App\Models\PagoPersonal;
use Carbon\Carbon;
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


Route::get('/utilidad-neta/{week}', function(Request $request){
    $year = Carbon::now()->year;
    $week = $request->week;
    $dates = Entrada::getDateRange($year, $week, $week);
    $entradas = Entrada::whereBetween('fecha_entrega', $dates)->get();
    $utilidad_bruta = collect($entradas)->sum('total_utilidad_global');

    $pagos = PagoPersonal::whereBetween('fecha', $dates)->whereHas('personal', function($q){
        $q->where('administrativo', true);
    })->sum('pago');

    $gastos = GastoFijoLog::whereBetween('fecha', $dates)->sum('monto');

    return $utilidad_bruta - $pagos - $gastos;


    
});

