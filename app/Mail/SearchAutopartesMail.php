<?php

namespace App\Mail;

use App\Http\Controllers\PdfController;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SearchAutopartesMail extends Mailable
{
    use Queueable, SerializesModels;


    public $textMessage;

    public function __construct($textMessage)
    {
        $this->textMessage = $textMessage;
        $this->subject = "AutopartesWillys: Busqueda de Autopartes";
    }

    public function build()
    {
        $email = $this->view('emails.search-autopartes-mail');
        return $email;

    }
}
