<?php

namespace App\Http\Livewire\Refaccion;

use App\Models\Proveedor;
use App\Models\Refaccion2;
use Livewire\Component;

class MdlCrearRefaccion extends Component
{
    public $mdlName = 'mdlCrearRefaccion';

    public $numero_reporte;
    public $numero_parte;
    public $proveedor_id;
    public $proveedor_name;
    public $descripcion;
    public $ubicacion;
    public $condicion;
    public $notas;

    protected $listeners = ['setProveedor'];

    protected $rules = [
        'numero_reporte' => 'required|digits:11',
        'numero_parte' => 'string|nullable',
        'proveedor_id' => 'numeric|nullable|exists:proveedores,id',
        'descripcion' => 'string|required|max:255',
        'ubicacion' => 'string|nullable|max:255',
        'condicion' => 'string|required|max:255',
        'notas' => 'string|nullable|max:255',
    ];

    public function render()
    {
        return view('livewire.refaccion.mdl-crear-refaccion');
    }

    public function setProveedor($id){
        if(!$id){
            $this->proveedor_id = null;
            $this->proveedor_name = null;
            return;
        }
        $proveedor = Proveedor::findOrfail($id);
        $this->proveedor_id = $proveedor->id;
        $this->proveedor_name = $proveedor->nombre;
    }

    public function create(){
        $this->validate();

        $refaccion = new Refaccion2([
            'numero_reporte' => $this->numero_reporte,
            'numero_parte' => $this->numero_parte,
            'proveedor_id' => $this->proveedor_id,
            'descripcion' => $this->descripcion,
            'estado' => 'ALMACEN',
            'ubicacion' => $this->ubicacion,
            'condicion' => $this->condicion,
            'notas' => $this->notas,
        ]);

        if($refaccion->save()){
            $this->emit('ok', 'Refacción creada correctamente');
            $this->emit('closeModal', "#{$this->mdlName}");
            $this->emit('reloadRefacciones');
            $this->reset();
        }
    }
}
