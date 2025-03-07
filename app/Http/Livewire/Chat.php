<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Chat extends Component
{
    public function render()
    {
        return view('livewire.chat.view')->layout('layouts.app2');
    }

    public function sendMessage()
    {
        $this->emit('ok', 'que tranza');
    }
}
