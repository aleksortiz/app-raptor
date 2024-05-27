<?php

namespace App\Http\Livewire\Aoscore;

use App\Mail\SupportTicketMail;
use App\Models\aoscore\SupportTicket;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SupportTicketsCatalogue extends Component
{
    public $ticket;

    protected $rules = [
        'ticket.type' => 'string|required',
        'ticket.description' => 'string|required|max:3000',
    ];

    public function render()
    {
        $data = SupportTicket::orderBy('id', 'desc')
        ->where('app_name', strtoupper($_ENV['APP_NAME']))
        ->paginate(50);
        return view('livewire.aoscore.support-tickets-catalogue.view', compact('data'));
    }

    public function mdlCreate(){
        $this->ticket = new SupportTicket();
        $this->emit('showModal', '#mdl');
    }

    public function save(){
        $this->validate();

        $desc = $this->ticket->description;
        $this->ticket->description = "";

        $ticket = SupportTicket::create([
            'type' => $this->ticket->type,
            'description' => $desc,
            'status' => 'ABIERTO'
        ]);

        $mail = new SupportTicketMail($ticket);
        Mail::mailer('aoscore')->to('alejandro.ortiz@aosystems.com.mx')->send($mail);
        

        $this->emit('closeModal', '#mdl');
    }
}
