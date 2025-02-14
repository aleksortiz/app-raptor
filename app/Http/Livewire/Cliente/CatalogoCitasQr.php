<?php

namespace App\Http\Livewire\Cliente;

use App\Models\RegistroQr;
use Livewire\Component;

class CatalogoCitasQr extends Component
{
    public $orderBy = 'fecha_cita';
    public $search = '';

    protected $listeners = ['reloadCatalogoCitas' => '$refresh'];

    protected $queryString = [
        'orderBy' => ['except' => 'fecha_cita'],
        'search' => ['except' => ''],
    ];

    public function render()
    {
        return view('livewire.cliente.catalogo-citas-qr.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        $citas = RegistroQr::where('active', true)
        ->where('cliente_nombre', 'like', "%{$this->search}%")
        ->orderBy($this->orderBy, 'desc')->get();

        return [
            'citas' => $citas,
        ];
    }

    public function verCita($id)
    {
        $this->emit('initMdlVerRegistroQr', $id);
    }
}
