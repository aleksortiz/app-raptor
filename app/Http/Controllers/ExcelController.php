<?php

namespace App\Http\Controllers;

use App\Exports\PresupuestoExport;
use App\Exports\VehiculosPisoExport;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{

  public function presupuesto(Request $request){
      $id = $request->id;
      $pago_danos = $request->pago_danos;
      $presupuesto = Presupuesto::find($id);
      $id = $presupuesto->id_paddy;
      return Excel::download(new PresupuestoExport($presupuesto, $pago_danos), "presupuesto_{$id}.xlsx");
  }

  public function vehiculosPiso(){
      $date = date('Y-m-d');
      return Excel::download(new VehiculosPisoExport(), "vehiculos_piso_{$date}.xlsx");
  }
}
