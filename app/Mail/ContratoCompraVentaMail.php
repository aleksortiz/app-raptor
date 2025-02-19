<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContratoCompraVentaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $file = PdfController::contrato_compra_venta_pdf($this->data);
        return $this->subject('Contrato de Compra Venta')
        ->view('emails.contrato-compra-venta-mail', ['data' => $this->data])
        ->attachData($file, 'contrato-compra-venta.pdf');

    }
}
