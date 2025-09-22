<?php

namespace App\Mail;

use App\Models\EntradaInventario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade as PDF;

class InventarioPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inventario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EntradaInventario $inventario)
    {
        $this->inventario = $inventario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('pdf.entrada-inventario.inventario_pdf', ['inventario' => $this->inventario]);
        
        return $this->subject('Inventario de Vehículo - Folio: ' . $this->inventario->entrada->folio_short)
                    ->view('emails.inventario-pdf')
                    ->with(['inventario' => $this->inventario])
                    ->attachData($pdf->output(), 'inventario_' . $this->inventario->id_paddy . '.pdf', [
                        'mime' => 'application/pdf'
                    ]);
    }
}
