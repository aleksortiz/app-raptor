<?php

namespace App\Http\Livewire\Refaccion;

use App\Models\Refaccion2;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoRefacciones extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search'];

    protected $listeners = ['reloadRefacciones' => '$refresh'];

    public $search;
    public $showingRefaccion = false;
    public $selectedRefaccion = null;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function verRefaccion(Refaccion2 $refaccion)
    {
        $this->selectedRefaccion = $refaccion;
        $this->showingRefaccion = true;
    }

    public function closeRefaccion()
    {
        $this->showingRefaccion = false;
        $this->selectedRefaccion = null;
    }

    public function render()
    {
        return view('livewire.refaccion.catalogo-refacciones.view', $this->getRenderData());
    }

    private function getRenderData(){
        $refacciones = Refaccion2::with('proveedor')
            ->orderBy('id', 'desc')
            ->where(function($query) {
                $query->where('descripcion', 'like', "%$this->search%")
                      ->orWhere('numero_parte', 'like', "%$this->search%")
                      ->orWhere('numero_reporte', 'like', "%$this->search%");
            });
            
        return [
            'refacciones' => $refacciones->paginate(50),
        ];
    }
}
