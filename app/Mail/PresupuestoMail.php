<?php

namespace App\Mail;

use App\Http\Controllers\PresupuestoController;
use App\Models\EnvioCorreo;
use App\Models\Presupuesto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PresupuestoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public Presupuesto $presupuesto;
    public EnvioCorreo $envio;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Presupuesto $presupuesto, EnvioCorreo $envio)
    {
        $this->subject = $envio->titulo;
        $this->presupuesto = $presupuesto;
        $this->envio = $envio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = PresupuestoController::presupuesto_pdf($this->presupuesto); //DEUDA
        $fileNamePDF = "{$this->presupuesto->folio}.pdf";
        $email = $this->view('emails.presupuesto', [
            'envio' => $this->envio,
        ]);
        $email->attachData($file, $fileNamePDF);

        return $email;
    }
}
