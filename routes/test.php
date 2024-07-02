<?php

use App\Http\Controllers\PdfController;
use App\Http\Controllers\PedidoController;
use App\Models\aoscore\SupportTicket;
use App\Models\Entrada;
use App\Models\Pedido;
use Carbon\Carbon;
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

});

Route::get('/week/{week}', function($week){
    $year = Carbon::now()->year;
    $dates = Entrada::getDateRange($year, $week, $week);
    return $dates;
});
