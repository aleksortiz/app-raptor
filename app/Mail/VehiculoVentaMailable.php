<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VehiculoVentaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $vehiculo;

    public function __construct($vehiculo)
    {
        $this->vehiculo = $vehiculo;
    }

    public function build()
    {
        return $this->subject('🌟 ¡SE VENDE! 🚗 ' . $this->vehiculo->descripcion)
        ->view('emails.vehiculo-venta-mail', ['vehiculo' => $this->vehiculo]);
    }
}
