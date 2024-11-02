<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaInventario;
use App\Models\Pedido;
use App\Models\ValeMaterial;
use Barryvdh\DomPDF\Facade as PDF;

class PdfController extends Controller
{
    public static function pedido_pdf(Pedido $pedido){
        $pdf = PDF::loadView('pdf.pedidos.pedido_pdf', compact('pedido'));
        $pdf->setPaper('A4');
        return $pdf->stream('Pedido_' . $pedido->id_paddy . '.pdf');
    }

    public static function entrada_pdf(Entrada $entrada){
      $pdf = PDF::loadView('pdf.entradas.entrada_pdf', compact('entrada'));
      $pdf->setPaper('A4');
      return $pdf->stream('Entrada_' . $entrada->folio_short . '.pdf');
      // return $pdf->download('Entrada_' . $entrada->folio_short . '.pdf');
    }

    public static function vale_material_pdf(ValeMaterial $vale){
        $pdf = PDF::loadView('pdf.materiales.vale_materiales_pdf', compact('vale'));
        $pdf->setPaper('A4');
        return $pdf->stream('Vale_' . $vale->id_paddy . '.pdf');
    }

    public static function inventario_pdf(EntradaInventario $inventario){
        $inv = json_decode($inventario->inventario);
        $testigos = json_decode($inventario->testigos);
        $carroceria = json_decode($inventario->carroceria);
        $mecanica = json_decode($inventario->mecanica);
        $servicios_extras = json_decode($inventario->servicios_extras);
        $pdf = PDF::loadView('pdf.entrada-inventario.inventario_pdf', compact('inventario', 'inv', 'testigos', 'carroceria', 'mecanica', 'servicios_extras'));
        $pdf->setPaper('A4');
        return $pdf->stream('inventario_' . $inventario->id_paddy . '.pdf');
    }
}
