<?php

namespace App\Http\Livewire\Refaccion;

use App\Models\Refaccion2;
use Livewire\Component;
use App\Http\Traits\PhotoTrait;

class VerRefaccion extends Component
{
    use PhotoTrait;

    public Refaccion2 $refaccion;
    public $showPhotos = true;
    public $showEditModal = false;

    protected $listeners = [
        'ok' => '$refresh'
    ];

    public function mount($refaccion_id)
    {
        $this->refaccion = Refaccion2::findOrFail($refaccion_id);
        $this->refaccion->load(['proveedor', 'fotos']);
    }

    public function render()
    {
        return view('livewire.refaccion.ver-refaccion.view');
    }

    public function togglePhotos()
    {
        $this->showPhotos = !$this->showPhotos;
    }

    public function showEdit()
    {
        $this->showEditModal = true;
        $this->emit('showModal', '#mdlEditarRefaccion');
    }
} 