<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Valuacion;
use Livewire\Component;

class VerValuacion extends Component
{
    public $lastUrl;
    public $valuacion;
    public $activeTab = 1;

    public function mount($id){
      $this->lastUrl = url()->previous();
      $this->valuacion = Valuacion::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.valuacion.ver-valuacion.view');
    }

    public function back(){
        return redirect()->to($this->lastUrl);
    }
}
