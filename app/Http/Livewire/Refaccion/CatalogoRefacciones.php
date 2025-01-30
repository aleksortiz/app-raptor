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

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.refaccion.catalogo-refacciones.view', $this->getRenderData());
    }

    private function getRenderData(){
        $refacciones = Refaccion2::orderBy('id', 'desc')
        ->where('descripcion', 'like', "%$this->search%");
        return [
            'refacciones' => $refacciones->paginate(50),
        ];
    }
}
