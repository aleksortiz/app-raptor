<?php

namespace App\Mail;

use App\Models\RequisicionFactura;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequisicionFacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public RequisicionFactura $requisicionFactura;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RequisicionFactura $requisicionFactura)
    {
        $this->requisicionFactura = $requisicionFactura->load('cliente');
        $clienteNombre = $this->requisicionFactura->cliente?->nombre ?? 'N/A';
        $this->subject = 'Nueva Requisición de Factura #' . $this->requisicionFactura->id . ' - ' . $clienteNombre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.requisicion-factura', [
            'requisicion' => $this->requisicionFactura,
        ]);
    }
}
