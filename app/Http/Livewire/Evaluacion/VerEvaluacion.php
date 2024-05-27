<?php

namespace App\Http\Livewire\Evaluacion;

use App\Models\Documento;
use App\Models\Entrada;
use App\Models\Evaluacion;
use App\Models\Fabricante;
use App\Models\Refaccion;
use App\Models\Sucursal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class VerEvaluacion extends Component
{
    use WithFileUploads;

    public $evaluacion;
    public $activeTab = 1;
    public $refaccion;
    
    public $documento;
    public $tipoDocumento;
    public $requiredDocs = [
        'ORDEN ADMISION',
        'NOTIFICACION',
    ];

    protected $listeners = [
        'eliminarDocumento',
        'destroyRefaccion',
    ];

    public function getRequiredDocsProperty()
    {
        $docs = $this->evaluacion->documentos->pluck('tipo')->toArray();
        return array_diff($this->requiredDocs, $docs);
    }

    protected $rules = [
        'evaluacion.no_reporte' => 'string|required|max:80',
        'evaluacion.sucursal_id' => 'numeric|required|min:1',
        'evaluacion.fabricante' => 'string|required|max:80',
        'evaluacion.modelo' => 'string|required|max:80',
        'evaluacion.notas' => 'string|nullable',
        
        'refaccion.descripcion' => 'string|required|max:255',
        'refaccion.numero_parte' => 'string|nullable|max:255',
        'refaccion.cantidad' => 'numeric|required|min:0',
        'refaccion.costo' => 'numeric|required|min:0',
        'refaccion.precio' => 'numeric|required|min:0',
    ];

    public function mount($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    public function render()
    {
        return view('livewire.evaluacion.ver-evaluacion.view', $this->getRenderData());
    }

    public function getRenderData()
    {
        return [
            'sucursales' => Sucursal::where('canceled_at', null)->get(),
            'fabricantes' => Fabricante::Catalog(),
            'modelos' => Entrada::CatalogoModelos(),
        ];
    }

    public function save()
    {
        $this->validate([
            'evaluacion.no_reporte' => 'string|required|max:80',
            'evaluacion.sucursal_id' => 'numeric|required|min:1',
            'evaluacion.fabricante' => 'string|required|max:80',
            'evaluacion.modelo' => 'string|required|max:80',
            'evaluacion.notas' => 'string|nullable',
        ]);
        $this->evaluacion->save();
        $this->evaluacion->load('sucursal');
        $this->emit('ok',"Se ha guardado evaluación");
        $this->emit('closeModal', '#mdl');
    }

    public function createRefaccion(){
        $this->validate([
            'refaccion.descripcion' => 'string|required|max:255',
            'refaccion.numero_parte' => 'string|nullable|max:255',
            'refaccion.cantidad' => 'numeric|required|min:0',
            'refaccion.costo' => 'numeric|required|min:0',
            'refaccion.precio' => 'numeric|required|min:0',
        ]);
        $this->refaccion->model_id = $this->evaluacion->id;
        $this->refaccion->model_type = Evaluacion::class;
        $this->refaccion->usuario_id = Auth::user()->id;
        if($this->refaccion->save()){
            $this->emit('ok', "Se ha registrado refacción: {$this->refaccion->descripcion}");
            $this->emit('closeModal', '#mdlCreateRefaccion');
            $this->evaluacion->load('refacciones');
            $this->refaccion = null;
        }
    }

    public function subirDocumento()
    {
        $this->validate([
            'tipoDocumento' => 'string|required|max:80',
            'documento' => 'required|max:2048',
        ]);
        // $url = $this->documento->store('evaluaciones/documentos');

        $url = Storage::disk('s3')->put('evaluaciones/documentos', $this->documento);

        $this->evaluacion->documentos()->create([
            'url' => $url,
            'tipo' => trim(strtoupper($this->tipoDocumento)),
            'name' => $this->documento->getClientOriginalName(),
        ]);
        $this->evaluacion->load('documentos');
        $this->documento = null;
        $this->tipoDocumento = null;
        $this->emit('closeModal', '#mdlUploadDocument');
    }

    public function eliminarDocumento($id){

        $documento = Documento::findOrFail($id);
        if(Storage::disk('s3')->exists($documento->url))
        {
            Storage::disk('s3')->delete($documento->url);
            $this->emit('ok', 'Se ha eliminado documento');
        }

        $documento->delete();
        $this->evaluacion->load('documentos');
    }

    public function descargarDocumento($id){
        $documento = Documento::findOrFail($id);
        return Storage::disk('s3')->download($documento->url, $documento->name);
    }

    public function showMdlRefacciones(){
        $this->resetValidation();
        $this->refaccion = new Refaccion();
        $this->emit('showModal', '#mdlCreateRefaccion');
    }

    public function destroyRefaccion($id){
        $elem = Refaccion::findOrFail($id);
        if($elem->delete()){
            $this->emit('ok', "Se ha eliminado refacción");
            $this->evaluacion->load('refacciones');
        }
    }
}
