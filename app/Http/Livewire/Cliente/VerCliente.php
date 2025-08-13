<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use App\Models\Documento;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class VerCliente extends Component
{
    use WithFileUploads;

    public $activeTab = 1;

    public Cliente $cliente;

    public $documento;
    public $tipoDocumento;

    public $requiredDocs = ['INE','CONSTANCIA FISCAL'];

    public $location_url = 'https://raptorv2.s3.amazonaws.com';

    protected $listeners = [
        'eliminarDocumento',
    ];

    protected $queryString = ['activeTab'];

    protected $rules = [
        'cliente.nombre' => 'string|required|min:3|max:255',
        'cliente.telefono' => 'string|required|min:7|max:15',
        'cliente.rfc' => 'string|nullable|min:10|max:13',
        'cliente.razon_social' => 'string|nullable|min:2|max:255',
        'cliente.calle' => 'string|nullable|min:2|max:255',
        'cliente.numero' => 'string|nullable|min:1|max:10',
        'cliente.colonia' => 'string|nullable|min:2|max:255',
        'cliente.codigo_postal' => 'string|nullable|min:4|max:12',
        'cliente.ciudad' => 'string|nullable|min:2|max:255',
        'cliente.estado' => 'string|nullable|min:2|max:255',
    ];

    public function mount($cliente_id)
    {
        $this->cliente = Cliente::with(['documentos'])->findOrFail($cliente_id);
        $this->activeTab = (int) $this->activeTab ?: 1;
    }

    public function render()
    {
        return view('livewire.cliente.ver-cliente.view');
    }

    public function save()
    {
        $this->validate();
        if ($this->cliente->save()) {
            $this->emit('ok', $this->cliente->nombre, 'Se ha guardado Cliente:');
        }
    }

    public function getRequiredDocsProperty()
    {
        $docs = $this->cliente->documentos->pluck('tipo')->toArray();
        return array_diff($this->requiredDocs, $docs);
    }

    public function subirDocumento()
    {
        $this->validate([
            'tipoDocumento' => 'string|required|max:80',
            'documento' => 'required|max:2048',
        ]);

        $url = Storage::disk('s3')->put('clientes/documentos', $this->documento);

        $this->cliente->documentos()->create([
            'url' => $url,
            'tipo' => trim(strtoupper($this->tipoDocumento)),
            'name' => $this->documento->getClientOriginalName(),
        ]);

        $this->cliente->load('documentos');
        $this->documento = null;
        $this->tipoDocumento = null;
        $this->emit('closeModal', '#mdlUploadDocument');
        $this->emit('ok', 'Se ha subido documento');
    }

    public function eliminarDocumento($id)
    {
        $documento = Documento::findOrFail($id);
        if (Storage::disk('s3')->exists($documento->url)) {
            Storage::disk('s3')->delete($documento->url);
            $this->emit('ok', 'Se ha eliminado documento');
        }

        $documento->delete();
        $this->cliente->load('documentos');
    }
}
