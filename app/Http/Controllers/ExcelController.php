<?php

namespace App\Http\Controllers;

use App\Exports\PresupuestoExport;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{

  public function presupuesto(Request $request){
      $id = $request->id;
      $presupuesto = Presupuesto::find($id);
      $id = $presupuesto->id_paddy;
      return Excel::download(new PresupuestoExport($presupuesto), "presupuesto_{$id}.xlsx");
  }
}
