<?php

namespace App\Http\Livewire\Flotilla;

use App\Http\Livewire\Classes\LivewireBaseCrudController;
use App\Models\Cliente;

class CatalogoClientesFlotillas extends LivewireBaseCrudController
{
    protected $model_name = "Cliente";
    protected $model_name_plural = "Clientes";
    
    protected $rules = [
        'model.nombre' => 'string|required|min:3|max:255',
        'model.rfc' => 'string|nullable|min:10|max:13',
        'model.razon_social' => 'string|nullable|min:5|max:255',
        'model.calle' => 'string|nullable|min:5|max:255',
        'model.numero' => 'string|nullable|min:1|max:10',
        'model.colonia' => 'string|nullable|min:2|max:255',
        'model.codigo_postal' => 'string|nullable|min:4|max:12',
        'model.ciudad' => 'string|nullable|min:2|max:255',
        'model.estado' => 'string|nullable|min:2|max:255',        
    ];

    public function resetInput(){
        $this->resetValidation();
        $this->model = new Cliente();
    }

    public function render()
    {
        $keyWord = '%'.$this->keyWord .'%';
        $data = $this->model::orderBy('nombre', 'ASC')
        ->orWhere('nombre', 'LIKE', $keyWord)
        ->orWhere('rfc', 'LIKE', $keyWord)
        ->orWhere('razon_social', 'LIKE', $keyWord)
        ->paginate(50);
        return view('livewire.flotilla.catalogo-clientes-flotillas.view', compact('data'));
    }
    
    public function verFlotilla($id){
        $cliente = Cliente::findOrFail($id);
        $cliente->createIdentifier();
        return redirect()->to('/servicio-flotillas/'.$cliente->identificador);
    }
}
