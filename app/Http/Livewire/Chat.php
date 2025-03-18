<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Chat extends Component
{
    public $inputMessage;
    public $messages = [];

    public function render()
    {
        return view('livewire.chat.view')->layout('layouts.app2');
    }

    public function sendMessage()
    {
        $this->validate([
            'inputMessage' => 'required'
        ]);

        
        $message = trim($this->inputMessage);
        $this->inputMessage = '';

        $this->messages[] = [
            'message' => $message,
            'user' => 'You',
            'time' => now()->format('H:i')
        ];

        $response = Http::post('http://127.0.0.1:5000/chatbot', [
            'mensaje' => $message
        ]);

        $data = $response->json();
        $aiMessage = $data['respuesta'];
        
        $this->messages[] = [
            'message' => $aiMessage,
            'user' => 'AutoServicio-Raptor',
            'time' => now()->format('H:i')
        ];
    }
}
