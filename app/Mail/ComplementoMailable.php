<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use App\Models\Complemento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ComplementoMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Complemento $complemento)
    {
        $this->subject = $_ENV['APP_FULL_NAME'] . $this->subject;
        $this->complemento = $complemento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = PdfController::factura_pdf($this->factura); //DEUDA
        $fileNamePDF = 'Factura_' . $this->factura->id . '.pdf';
        $fileNameXML = 'Factura_' . $this->factura->id . '.xml';
        $email = $this->view('emails.FacturaMail');
        $email->attachData($file, $fileNamePDF);
        $email->attachData($this->complemento->xml, $fileNameXML,[
            'mime' => 'text/xml'
        ]);

        return $email;
    }
}
