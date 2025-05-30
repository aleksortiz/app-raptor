<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use Livewire\Component;

class GaleriaFotos extends Component
{
    public $entrada;
    public $activePhoto = null;

    public function mount(Entrada $entrada)
    {
        $this->entrada = $entrada;
        if ($this->entrada->fotos->count() > 0) {
            $this->activePhoto = $this->entrada->fotos->first();
        }
    }

    public function setActivePhoto($photoId)
    {
        $this->activePhoto = $this->entrada->fotos->firstWhere('id', $photoId);
    }

    public function render()
    {
        return view('livewire.entrada.galeria-fotos');
    }
} 