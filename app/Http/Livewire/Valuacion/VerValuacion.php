<?php

namespace App\Http\Livewire\Valuacion;

use App\Models\Valuacion;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class VerValuacion extends Component
{
    public $lastUrl;
    public $valuacion;
    public $tab;

    public $tasa_iva = 0.16;
    public $mecanica;
    public $hojalateria;
    public $pintura;
    public $armado;

    public $presupuesto;
    public $presupuestoConceptos = [];

    public $edit_mode = false;
    
    public $cliente_id;

    protected $queryString = [
        'tab' => ['except' => ''],
    ];

    protected $listeners = ['eliminarConcepto'];

    public function updatingEditMode($value)
    {
      if($value){
        $this->presupuestoConceptos = $this->presupuesto->conceptos;
      }
    }

    protected $rules = [
      'presupuestoConceptos.*.nomenclatura' => 'required|string',
      'presupuestoConceptos.*.cantidad' => 'required|numeric|min:1',
      'presupuestoConceptos.*.descripcion' => 'required',
      'presupuestoConceptos.*.mano_obra' => 'required|numeric|min:0',
      'presupuestoConceptos.*.refacciones' => 'required|numeric|min:0',
      
      'mecanica' => 'required|numeric|min:0',
      'hojalateria' => 'required|numeric|min:0',
      'pintura' => 'required|numeric|min:0',
      'armado' => 'required|numeric|min:0',
      'tasa_iva' => 'required|numeric|min:0|max:1',
    ];

    protected $messages = [
      'presupuestoConceptos.*.nomenclatura.required' => 'La nomenclatura es obligatoria.',
      'presupuestoConceptos.*.cantidad.required' => 'La cantidad es obligatoria.',
      'presupuestoConceptos.*.cantidad.numeric' => 'La cantidad debe ser un número.',
      'presupuestoConceptos.*.cantidad.min' => 'La cantidad debe ser al menos 1.',
      'presupuestoConceptos.*.descripcion.required' => 'La descripción es obligatoria.',
      'presupuestoConceptos.*.mano_obra.required' => 'El costo de mano de obra es obligatorio.',
      'presupuestoConceptos.*.mano_obra.numeric' => 'El costo de mano de obra debe ser un número.',
      'presupuestoConceptos.*.mano_obra.min' => 'El costo de mano de obra debe ser al menos 0.',
      'presupuestoConceptos.*.refacciones.required' => 'El costo de refacciones es obligatorio.',
      'presupuestoConceptos.*.refacciones.numeric' => 'El costo de refacciones debe ser un número.',
      'presupuestoConceptos.*.refacciones.min' => 'El costo de refacciones debe ser al menos 0.',

      'mecanica.required' => 'Obligatorio.',
      'mecanica.numeric' => 'Debe ser un número.',
      'mecanica.min' => 'Debe ser al menos 0.',
      'hojalateria.required' => 'Obligatorio.',
      'hojalateria.numeric' => 'Debe ser un número.',
      'hojalateria.min' => 'Debe ser al menos 0.',
      'pintura.required' => 'El costo de pintura es obligatorio.',
      'pintura.numeric' => 'Debe ser un número.',
      'pintura.min' => 'Debe ser al menos 0.',
      'armado.required' => 'El costo de armado es obligatorio.',
      'armado.numeric' => 'Debe ser un número.',
      'armado.min' => 'Debe ser al menos 0.',
      'tasa_iva.required' => 'La tasa de IVA es obligatoria.',
      'tasa_iva.numeric' => 'La tasa de IVA debe ser un número.',
      'tasa_iva.min' => 'La tasa de IVA debe ser al menos 0.',
      'tasa_iva.max' => 'La tasa de IVA debe ser máximo 1.',
    ];

    public function mount($id){
      $this->lastUrl = url()->previous();
      $this->valuacion = cache()->remember("valuacion_{$id}", 60, function () use ($id) {
        return Valuacion::findOrFail($id);
      });
      $this->presupuesto = $this->valuacion->presupuestos[0];

      $this->mecanica = $this->presupuesto?->mecanica ?? 0;
      $this->hojalateria = $this->presupuesto?->hojalateria ?? 0;
      $this->pintura = $this->presupuesto?->pintura ?? 0;
      $this->armado = $this->presupuesto?->armado ?? 0;
      $this->tasa_iva = $this->presupuesto?->tasa_iva ?? 0.16;
    }

    public function render()
    {
        return view('livewire.valuacion.ver-valuacion.view', $this->getRenderData());
    }

    public function getRenderData(){
        $path = base_path('app/Data');
        $marcas = json_decode(File::get("$path/marcas.json"), true);
        $modelos = json_decode(File::get("$path/modelos.json"), true);

        return [
            'marcas' => $marcas,
            'modelos' => $modelos,
        ];
    }

    public function back(){
        return redirect()->to($this->lastUrl);
    }

    public function addConcepto(){
      if(!$this->presupuesto){
        $this->presupuesto = $this->valuacion->presupuestos()->create([
            'cliente_id' => $this->valuacion->cliente_id,
            'user_id' => auth()->id(),
            'model_id' => $this->valuacion->id,
            'model_type' => Valuacion::class,
            'marca' => $this->valuacion->marca,
            'modelo' => $this->valuacion->modelo,
            'year' => $this->valuacion->year,
            'color' => $this->valuacion->color,
            'subtotal' => 0,
            'iva' => 0,
            'total' => 0,
            'mecanica' => $this->mecanica,
            'hojalateria' => $this->hojalateria,
            'pintura' => $this->pintura,
            'armado' => $this->armado,
            'tasa_iva' => $this->tasa_iva,
        ]);
      }

        $newConcepto = $this->presupuesto->conceptos()->create([
            'nomenclatura' => 'I-REPARAR',
            'cantidad' => 1,
            'descripcion' => '[Descripción]',
            'mano_obra' => 0,
            'refacciones' => 0,
        ]);

        $this->presupuestoConceptos[] = $newConcepto;

        $this->presupuesto->load('conceptos');
    }

    public function eliminarConcepto($id){
        $concepto = $this->presupuesto->conceptos()->findOrFail($id);
        $concepto->delete();
        $this->presupuesto->load('conceptos');
    }


    public function savePresupuesto(){
        $this->validate();

        $this->presupuesto->mecanica = $this->mecanica;
        $this->presupuesto->hojalateria = $this->hojalateria;
        $this->presupuesto->pintura = $this->pintura;
        $this->presupuesto->armado = $this->armado;
        $this->presupuesto->tasa_iva = $this->tasa_iva;

        $this->presupuesto->save();

        foreach($this->presupuestoConceptos as $concepto){
            $c = $this->presupuesto->conceptos()->findOrFail($concepto['id']);
            $c->nomenclatura = $concepto->nomenclatura;
            $c->cantidad = $concepto->cantidad;
            $c->descripcion = $concepto->descripcion;
            $c->mano_obra = $concepto->mano_obra;
            $c->refacciones = $concepto->refacciones;
            $c->save();
        }

        $this->presupuesto->load('conceptos');
        cache()->forget("valuacion_{$this->valuacion->id}");

        $this->edit_mode = false;
    }
}
