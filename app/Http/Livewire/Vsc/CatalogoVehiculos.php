<?php

namespace App\Http\Livewire\Vsc;

use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogoVehiculos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $model;
    public $iptVendido;

    protected $rules = [
        'model.brand' => 'required',
        'model.model' => 'required',
        'model.year' => 'required',
        'model.serial' => 'nullable',
        'model.location' => 'required',
        'model.status' => 'required',
        'model.legal_status' => 'required',
        'model.purchase_date' => 'date',
        'model.purchase_price' => 'required',
        'model.sale_date' => 'date|nullable',
        'model.sale_price' => 'numeric|nullable',
        'model.notes' => 'nullable',
    ];

    public function render(){
        return view('livewire.vsc.catalogo-vehiculos.view', $this->getRenderData());
    }

    public function getRenderData(){
        return [
            'vehiculos' => Vehicle::paginate(10)
        ];
    }

    public function mdl($id){
        $this->resetValidation();
        if($id != 0){
            $this->model = Vehicle::findOrFail($id);
        }
        else{
            $this->model = new Vehicle();
        }
        $this->iptVendido = $this->model->sale_date != null;
        $this->emit('showModal', '#mdl');
    }

    public function save(){
        $rules = $this->rules;
        if($this->iptVendido){
            $rules['model.sale_date'] = 'required';
            $rules['model.sale_price'] = 'required';
        }
        else{
            $this->model->sale_date = null;
            $this->model->sale_price = null;
        }

        $this->validate($rules);
        $this->model->save();
        $this->emit('ok', 'Registro guardado');
        $this->emit('closeModal', '#mdl');
    }
}
