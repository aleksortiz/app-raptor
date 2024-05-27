<?php

namespace App\Http\Controllers;

use App\Mail\PresupuestoMail;
use App\Models\Contacto;
use App\Models\ContactoEnvioCorreo;
use App\Models\EnvioCorreo;
use App\Models\Presupuesto;
use App\Models\ErrorLog;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\Mail;

class PresupuestoController extends Controller
{
    
    public static function presupuesto_pdf(Presupuesto $presupuesto){
        $ppto = $presupuesto;
        // return view('pdf.presupuesto.presupuesto_pdf', compact('ppto'));
        $pdf = PDF::loadView('pdf.presupuesto.presupuesto_pdf', compact('ppto'));
        $pdf->setPaper('A4');
        return $pdf->stream("{$ppto->titulo}.pdf");
    }

    public static function enviarCorreo(Presupuesto $ppto, $contactos_ids, EnvioCorreo $envio){
        try{
            $contactos = Contacto::whereIn('id', $contactos_ids)->get();

            $mail = new PresupuestoMail($ppto, $envio);

            if(Mail::to($contactos->pluck('correo'))->send($mail) !== false){
                if($envio->save()){
                    foreach ($contactos as $con) {
                        $envio->push(ContactoEnvioCorreo::create([
                            'contacto_id' => $con->id,
                            'envio_correo_id' => $envio->id,
                        ]));
                    }
                }
                return true;
            }

            return false;
        }
        catch(Exception $e){
            ErrorLog::create(['titulo' => 'EnvioPresupuesto', 'error' => $e->getMessage()]);
            return false;
        }
    }
}
