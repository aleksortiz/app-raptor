<?php

use App\Http\Controllers\ServicioFlotillaController;
use App\Mail\SearchAutopartesMail;
use App\Models\Entrada;
use App\Models\GastoFijoLog;
use App\Models\PagoPersonal;
use App\Models\Willys\Asociado;
use App\Models\Willys\Autoparte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::post('/afiliados', function(Request $request){
    $asociado = Asociado::create([
      'nombre' => $request->nombre,
      'correo' => $request->correo,
      'telefono' => $request->telefono,
      'empresa' => $request->empresa
    ]);
    return $asociado;
});

Route::post('/autopartes', function(Request $request){

  $provider = Asociado::where('telefono', $request->telefono)->first();

  $parte = Autoparte::create([
    'name' => $request->name,
    'description' => $request->description,
    'brand' => $request->brand,
    'model' => $request->model,
    'year' => $request->year,
    'price' => $request->price,
    'provider' => $provider?->empresa ?? null,
  ]);
  return $parte;
});

Route::get('/autopartes', function(Request $request){
  $searchQuery = $request->query('search');
  $autopartes = Autoparte::orderBy('name', 'asc');
  if($searchQuery){
    $searchQuery = strtolower($searchQuery);
    $searchQuery = str_replace('  ', ' ', $searchQuery);
    $searchQuery = str_replace(',', ' ', $searchQuery);
    $parts = explode(' ', $searchQuery);
    $autopartes = $autopartes->where(function($q) use ($parts){
      foreach($parts as $part){
        $q->orWhere('name', 'like', "%$part%");
        $q->orWhere('description', 'like', "%$part%");
        $q->orWhere('brand', 'like', "%$part%");
        $q->orWhere('model', 'like', "%$part%");
        $q->orWhere('year', 'like', "%$part%");
      }
    });
  }
  $res = $autopartes->get();

  if($res->isEmpty()){
    try{
      $mails = Asociado::all()->pluck('correo')->toArray();
      if(!empty($mails)){
        $mailable = new SearchAutopartesMail($searchQuery);
        Mail::to($mails)->send($mailable);
      }

    }
    catch(Exception $e){
      return $res;
    }
  }

  return $res;
});


