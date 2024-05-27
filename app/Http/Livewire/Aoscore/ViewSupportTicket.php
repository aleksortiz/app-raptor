<?php

namespace App\Http\Livewire\Aoscore;

use App\Models\aoscore\SupportTicket;
use App\Models\aoscore\SupportTicketComment;
use App\Models\aoscore\SupportTicketLog;
use Livewire\Component;

class ViewSupportTicket extends Component
{
    public SupportTicket $ticket;
    public SupportTicketComment $comment;

    protected $listeners = [
        'validar'
    ];

    protected $rules = [
        'comment.comment' => 'string|required|max:255',
    ];

    public function mount(SupportTicket $ticket){
        $this->ticket = $ticket;
    }

    public function render()
    {
        return view('livewire.aoscore.view-support-ticket.view');
    }

    public function mdlCreateComment(){
        $this->comment = new SupportTicketComment();
        $this->emit('showModal','#mdlCreateComment');
    }

    public function createComment(){
        $this->validate();

        $text = $this->comment->comment;
        $this->comment->comment = "";

        $comment = SupportTicketComment::create([
            'ticket_id' => $this->ticket->id,
            'comment' => $text,
        ]);


        if($comment->id > 0){
            $this->emit('ok', "Se ha agregado comentario");
            $this->emit('closeModal','#mdlCreateComment');
            $this->ticket->load('comments');
        }
    }

    public function validar(){
        $this->ticket->status = 'CERRADO';
        if($this->ticket->save()){
            SupportTicketLog::create([
                'ticket_id' => $this->ticket->id,
                'status' => $this->ticket->status,
            ]);
            $this->emit('ok', 'Se ha cerrado ticket');
            $this->ticket->load('logs');
        }
    }
}
