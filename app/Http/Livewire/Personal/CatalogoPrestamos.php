<?php

namespace App\Http\Livewire\Personal;

use App\Models\Prestamo;
use Livewire\Component;

class CatalogoPrestamos extends Component
{
    public $prestamo;

    protected $listeners = [
        'reloadPrestamos' => '$refresh',
    ];

    public $mdlName = 'mdlPrestamo';

    public function render()
    {
        return view('livewire.personal.catalogo-prestamos.view', $this->getRenderData());
    }

    public function getRenderData(){

        $prestamos = Prestamo::orderBy('id', 'desc')
        ->whereHas('pagos', function($query){
            $query->where('fecha', '>', now());
        })->get();

        return [
            'prestamos' => $prestamos,
        ];
    }

    public function showPrestamo($id){
        $this->prestamo = Prestamo::with('pagos')->findOrFail($id);
        $this->emit('showModal', "#{$this->mdlName}");
    }

    
}
