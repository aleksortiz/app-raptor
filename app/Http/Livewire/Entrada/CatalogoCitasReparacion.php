<?php

namespace App\Http\Livewire\Entrada;

use App\Models\CitaReparacion;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoCitasReparacion extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public function updated(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.entrada.catalogo-citas-reparacion.view', $this->getRenderData());
    }

    private function getRenderData(){
        $citas = CitaReparacion::orderBy('cita', 'asc')->where('inventario_id', null);

        return [
            'citas' => $citas->paginate(50),
        ];
    }
}
