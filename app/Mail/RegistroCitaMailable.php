<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroCitaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $registroQR;
    

    public function __construct($registroQR)
    {
        $this->registroQR = $registroQR;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registro de Cita')
        ->view('emails.registro-cita', ['registroQR' => $this->registroQR]);
    }
}
