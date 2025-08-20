<?php

namespace App\Http\Controllers;

use App\Exports\PresupuestoExport;
use App\Exports\VehiculosPisoExport;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Barryvdh\DomPDF\Facade as PDF;

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

  public function presupuestoPdf(Request $request){
      $id = $request->id;
      $pago_danos = $request->pago_danos;
      $presupuesto = Presupuesto::find($id);
      $id = $presupuesto->id_paddy ?? $presupuesto->id;
      $pdf = PDF::loadView('pdf.valuacion.presupuesto_pdf', [
          'presupuesto' => $presupuesto,
          'pago_danos' => filter_var($pago_danos, FILTER_VALIDATE_BOOLEAN),
      ]);
      $pdf->setPaper('A4', 'portrait');
      return $pdf->download("presupuesto_{$id}.pdf");
  }
  
  /**
   * Muestra el PDF del presupuesto en el navegador sin descargarlo
   */
  public function presupuestoPdfView(Request $request){
      $id = $request->id;
      $pago_danos = $request->pago_danos;
      $presupuesto = Presupuesto::find($id);
      $id = $presupuesto->id_paddy ?? $presupuesto->id;
      $pdf = PDF::loadView('pdf.valuacion.presupuesto_pdf', [
          'presupuesto' => $presupuesto,
          'pago_danos' => filter_var($pago_danos, FILTER_VALIDATE_BOOLEAN),
      ]);
      $pdf->setPaper('A4', 'portrait');
      return $pdf->stream("presupuesto_{$id}.pdf");
  }
}
