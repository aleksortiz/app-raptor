<?php

namespace App\Mail;

use App\Models\AOSTicketSoporte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AOSTicketSoporteMailable extends Mailable
{
    use Queueable, SerializesModels;

    
    public $subject = "[AOSystems]: Ticket de Soporte";
    public AOSTicketSoporte $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AOSTicketSoporte $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.AOSTicketCreated');
    }
}
