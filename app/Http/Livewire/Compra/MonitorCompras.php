<?php

namespace App\Http\Livewire\Compra;

use Livewire\Component;

class MonitorCompras extends Component
{
    public $activeTab = 1;
    
    public function render()
    {
        return view('livewire.compra.monitor-compras.view');
    }
}
