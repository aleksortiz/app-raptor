<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use App\Models\EntradaInventario;
use App\Models\Pedido;
use App\Models\ValeMaterial;
use App\Models\Vehiculo;
use App\Models\VehiculoPagare;
use Barryvdh\DomPDF\Facade as PDF;
use Luecano\NumeroALetras\NumeroALetras;

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

    public static function contrato_compra_venta_pdf($data){
        $ob = new NumeroALetras();
        $ob->apocope = false;


        $contratoVendedor = strtoupper(trim($data['vendedor']));
        $contratoComprador = strtoupper(trim($data['comprador']));
        $contratoDomicilioComprador = strtoupper(trim($data['domicilioComprador']));
        $contratoFecha = strtoupper(trim($data['fecha']));
        $contratoLugar = strtoupper(trim($data['lugar']));
        $contratoPrecio = strtoupper(trim($data['precio']));
        $contratoPrecioLetra = $ob->toInvoice(floatval($data['precio']), 2, 'MXN');
        $contratoPlazos = strtoupper(trim($data['plazos']));
        $contratoAnticipo = strtoupper(trim($data['anticipo']));
        $contratoAnticipoLetra = $ob->toInvoice(floatval($data['anticipo']), 2, 'MXN');
        $contratoKilometraje = strtoupper(trim($data['kilometraje']));
        $contratoIdentificacion = strtoupper(trim($data['identificacion']));
        $contratoIdentificacionNumero = strtoupper(trim($data['noIdentificacion']));

        $vehiculo = Vehiculo::findOrFail($data['idVehiculo']);
        if(!$vehiculo){
            abort(404);
        }

        $contratoMarca = $vehiculo->marca;
        $contratoModelo = $vehiculo->modelo;
        $contratoYear = $vehiculo->year;
        $contratoNumeroSerie = $vehiculo->serie;
        $contratoColor = $vehiculo->color;
        $contratoPlacas = $vehiculo->placas;

        $pdf = PDF::loadView('pdf.vehiculo.contrato_compra_venta', compact(
            'contratoVendedor',
            'contratoComprador',
            'contratoDomicilioComprador',
            'contratoFecha',
            'contratoLugar',
            'contratoPrecio',
            'contratoPrecioLetra',
            'contratoPlazos',
            'contratoAnticipo',
            'contratoAnticipoLetra',
            'contratoKilometraje',
            'contratoIdentificacion',
            'contratoIdentificacionNumero',
            'contratoMarca',
            'contratoModelo',
            'contratoYear',
            'contratoNumeroSerie',
            'contratoColor',
            'contratoPlacas',
        ));

        $pdf->setPaper('A4');
        return $pdf->stream('contrato_compra_venta.pdf');
    }

    public static function vehiculo_pagare_pdf(VehiculoPagare $pagare){
        $ob = new NumeroALetras();
        $ob->apocope = false;
        $montoLetra = $ob->toInvoice(floatval($pagare->monto), 2, 'MXN');
        $vehiculo = $pagare->vehiculo;
        $venta = $vehiculo->venta;
        $pdf = PDF::loadView('pdf.vehiculo.pagare', compact(
            'vehiculo',
            'venta',
            'pagare',
            'montoLetra',
        ));

        $pdf->setPaper('A4');
        return $pdf->stream('pagare_'. $pagare->id_paddy .'.pdf');
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
