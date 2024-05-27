<?php

namespace App\Mail;

use App\Http\Controllers\ComprasController;
use App\Models\EnvioCorreo;
use App\Models\OrdenCompra;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrdenCompraMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public OrdenCompra $po;
    public EnvioCorreo $envio;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrdenCompra $po, EnvioCorreo $envio)
    {
        $this->subject = $envio->titulo;
        $this->po = $po;
        $this->envio = $envio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = ComprasController::orden_compra_pdf($this->po); //DEUDA
        $fileNamePDF = "{$this->po->nombre}.pdf";
        $email = $this->view('emails.envio-correo', [
            'envio' => $this->envio,
        ]);
        $email->attachData($file, $fileNamePDF);

        return $email;
    }
}
