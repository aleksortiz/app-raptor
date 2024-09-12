<?php

namespace App\Http\Livewire\Personal;

use App\Models\Costo;
use Livewire\Component;
use Livewire\WithPagination;

class AdminOrdenesTrabajo extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render(){
        return view('livewire.personal.admin-ordenes-trabajo.view', $this->getRenderData());
    }

    public function getRenderData(){
        return [
            'data' => Costo::where('concepto', 'MANO DE OBRA')->paginate(50),
        ];
    }

    public function mdlCreate($entrada_id){
        $this->emit('showModal', 'mdl');
    }
}
