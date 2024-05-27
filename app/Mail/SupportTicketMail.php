<?php

namespace App\Mail;

use App\Models\aoscore\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
        $this->subject("Ticket de Soporte[AOSystems]");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.support-ticket-mail');
    }
}
