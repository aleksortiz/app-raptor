<?php

namespace App\Http\Livewire\OrdenTrabajo;

use App\Models\Entrada;
use App\Models\OrdenTrabajo;
use App\Models\Personal;
use Livewire\Component;

class MdlCrearOrdenTrabajo extends Component
{
    public $mdlName = 'mdlCrearOrdenTrabajo';

    protected $listeners = [
        'initMdlCrearOrdenTrabajo',
        'setEntrada'
    ];

    public $entrada_id;
    public $entrada;
    public $personal_id;
    public $monto;
    public $notas;
    public $costo_id;

    public $componentes = [
        'COFRE',
        'COSTADO DER',
        'COSTADO IZQ',
        'ESTRIBO',
        'FACIA DEL',
        'FACIA TRA',
        'FENDER DEL DER',
        'FENDER DEL IZQ',
        'FENDER TRA DER',
        'FENDER TRA IZQ',
        'PARRILLA',
        'PISO CAJUELA',
        'PUERTA DER DEL',
        'PUERTA DER TRA',
        'PUERTA IZQ DEL',
        'PUERTA IZQ TRA',
        'QUINTA PUERTA',
        'TAPA CAJUELA',
    ];

    public $acciones = [
        'REPARAR',
        'PINTAR',
        'REEMPLAZAR'
    ];

    public $selecciones = [];

    protected $rules = [
        'entrada_id' => 'required|numeric',
        'personal_id' => 'required|numeric',
        'monto' => 'required|numeric|gt:0',
        'notas' => 'required|string|max:255',
        'costo_id' => 'nullable|numeric'
    ];

    public function mount()
    {
        foreach ($this->componentes as $componente) {
            foreach ($this->acciones as $accion) {
                $this->selecciones[$componente][$accion] = false;
            }
        }
    }

    public function updatedSelecciones()
    {
        $this->generarNotas();
    }

    protected function generarNotas()
    {
        $notas = [];
        foreach ($this->selecciones as $componente => $acciones) {
            $accionesSeleccionadas = array_filter($acciones, function($seleccionada) {
                return $seleccionada;
            });
            
            if (!empty($accionesSeleccionadas)) {
                $accionesArray = array_keys($accionesSeleccionadas);
                if (count($accionesArray) > 2) {
                    $ultimaAccion = array_pop($accionesArray);
                    $accionesStr = implode(', ', $accionesArray) . ' Y ' . $ultimaAccion;
                } else {
                    $accionesStr = implode(' Y ', $accionesArray);
                }
                $notas[] = $componente . ' --> ' . $accionesStr;
            }
        }
        
        $this->notas = implode(' / ', $notas);
    }

    public function resetForm()
    {
        $this->entrada_id = null;
        $this->entrada = null;
        $this->personal_id = null;
        $this->monto = null;
        $this->notas = null;
        $this->costo_id = null;
        $this->mount();
    }

    public function render()
    {
        return view('livewire.orden-trabajo.mdl-crear-orden-trabajo', $this->getRenderData());
    }

    public function getRenderData()
    {
        $personal = Personal::orderBy('nombre', 'ASC')
            ->where('activo', true)
            ->where('destajo', true)
            ->get();

        $destajosCount = $this->entrada ? OrdenTrabajo::where('entrada_id', $this->entrada->id)->count() : 0;

        return [
            'personal' => $personal,
            'verOtrosDestajosUrl' => $this->entrada ? "/servicios/{$this->entrada->id}?activeTab=8" : null,
            'destajosCount' => $destajosCount
        ];
    }

    public function initMdlCrearOrdenTrabajo($entrada_id = null)
    {
        $this->resetForm();
        $this->resetValidation();
        if ($entrada_id) {
            $this->setEntrada($entrada_id);
        }
        $this->emit('showModal', "#{$this->mdlName}");
    }

    public function setEntrada($id)
    {
        if (!$id) {
            $this->entrada_id = null;
            $this->entrada = null;
            return;
        }

        $entrada = Entrada::findOrFail($id);
        $this->entrada_id = $entrada->id;
        $this->entrada = $entrada;
    }

    public function create()
    {
        $this->validate();

        $ordenTrabajo = new OrdenTrabajo([
            'user_id' => auth()->id(),
            'entrada_id' => $this->entrada_id,
            'personal_id' => $this->personal_id,
            'monto' => $this->monto,
            'notas' => $this->notas,
            'porcentaje' => 0,
            'costo_id' => $this->costo_id
        ]);

        if ($ordenTrabajo->save()) {
            $this->emit('ok', 'Orden de trabajo creada correctamente');
            $this->emit('closeModal', "#{$this->mdlName}");
            $this->resetForm();
            $this->emit('reloadOrdenesTrabajo');
        }
    }
} 