<?php

use App\Models\Entrada;
use App\Models\EntradaMaterial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('test')->group(function ()
{
    Route::get('/', function(){
        $date = new Carbon();
        $fecha = $date->isoWeekYear(2024)->isoWeek(17)->startOfWeek();
        $end = $date->isoWeekYear(2024)->isoWeek(17)->endOfWeek();
        return $end;

        // $pedido = Pedido::FindOrFail(1);
        // return PedidoController::enviarCorreo($pedido, 'QUE ONDAS', ["alejandro_ortiz426@hotmail.com"]);

    });

    Route::get('/be-user/{id}', function($id){
        return Auth::loginUsingId($id);
    });

});

Route::get('/week/{week}', function($week){
    $year = Carbon::now()->year;
    $dates = Entrada::getDateRange($year, $week, $week);
    return $dates;
});

Route::get('xxx', function(){
    [$start, $end] = Entrada::getDateRange(2024, 1, 50);

    $materiales = EntradaMaterial::orderBy('created_at', 'desc')
    ->select(DB::raw('material_id, entrada_id, material, sum(cantidad) as cantidad, sum(precio * cantidad) as importe'))
    ->whereBetween('created_at', [$start, $end]);

    if(true){
        $materiales->groupBy('material');

    }

    return $materiales->paginate(50);

    // return [
    //     'materiales' => $materiales->paginate(50),
    // ];
});

Route::get('/camara', function(){
    return view('camara');
});
