<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\Pedido;
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
  }
}
