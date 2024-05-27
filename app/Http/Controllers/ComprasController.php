<?php

namespace App\Http\Controllers;

use App\Mail\OrdenCompraMail;
use App\Mail\PresupuestoMail;
use App\Models\Contacto;
use App\Models\ContactoEnvioCorreo;
use App\Models\EnvioCorreo;
use App\Models\ErrorLog;
use App\Models\OrdenCompra;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\Mail;

class ComprasController extends Controller
{
    
    public static function orden_compra_pdf(OrdenCompra $orden_compra){
        $po = $orden_compra;
        $pdf = PDF::loadView('pdf.compra.orden_compra_pdf', compact('po'));
        $pdf->setPaper('A4');
        return $pdf->stream("{$po->nombre}.pdf");
    }

    public static function enviarCorreo(OrdenCompra $po, $contactos_ids, EnvioCorreo $envio){
        try{
            $contactos = Contacto::whereIn('id', $contactos_ids)->get();

            $mail = new OrdenCompraMail($po, $envio);

            if(Mail::to($contactos->pluck('correo'))->send($mail) !== false){
                if($envio->save()){
                    foreach ($contactos as $con) {
                        $envio->push(ContactoEnvioCorreo::create([
                            'contacto_id' => $con->id,
                            'envio_correo_id' => $envio->id,
                        ]));
                    }

                    if($po->estatus == 'AUTORIZADO'){
                        $po->estatus = 'ENVIADO';
                        $po->save();
                    }
                }
                return true;
            }

            return false;
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnvioOrdenCompra', 'error' => $e->getMessage()]);
            return false;
        }
    }
}
