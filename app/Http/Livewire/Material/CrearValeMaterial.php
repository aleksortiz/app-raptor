<?php

namespace App\Http\Livewire\Material;

use App\Http\Controllers\PedidoController;
use App\Http\Traits\EmailValidateTrait;
use App\Models\Entrada;
use App\Models\Material;
use App\Models\Pedido;
use App\Models\PedidoConcepto;
use App\Models\Personal;
use App\Models\ValeMaterial;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CrearValeMaterial extends Component
{
    use EmailValidateTrait;

    public $selectedEntrada = null;

    public $personal;
    public $selectedMaterialIndex;
    public $comentarios;
    public $listadoMaterial = [];

    protected $rules = [
      'listadoMaterial.*.cantidad' => 'required|numeric|min:0.1',
      'listadoMaterial.*.entrada_id' => 'required|numeric|min:1',
    ];

    protected $listeners = [
        'setPersonal',
        'setMaterial',
        'destroy',
        'limpiar',
        'setEntrada',
        'crearVale',
    ];

    public function updated($name, $value){

    }

    public function render(){
        return view('livewire.material.crear-vale-material.view');
    }

    public function getCountMaterialesProperty(){
      $count = 0;
      foreach ($this->listadoMaterial as $item) {
          $count += $item['cantidad'] ? $item['cantidad'] : 0;
      }
      return $count;
    }

    public function limpiar(){
        $this->listadoMaterial = [];
        $this->personal = null;
        $this->comentarios = null;
    }

    public function setPersonal($id){
        if ($id == 0) {
            $this->personal = null;
        } else {
            $this->personal = Personal::findOrFail($id);
        }
    }

    public function showMdlMateriales()
    {
        $this->emit('showModal', '#mdlCatalogoMateriales');
    }

    public function setMaterial($id, $qty){
        $material = Material::findOrFail($id);
        $this->listadoMaterial[] = [
          'material_id' => $material->id,
          'numero_parte' => $material->numero_parte,
          'unidad_medida' => $material->unidad_medida,
          'descripcion' => $material->descripcion,
          'cantidad' => $qty,
          'precio' => $material->precio,
          'entrada_id' => $this->selectedEntrada ? $this->selectedEntrada->id : null,
          'folio_entrada' => $this->selectedEntrada ? $this->selectedEntrada->folio_short : null,
        ];
    }

    public function destroy($index)
    {
        unset($this->listadoMaterial[$index]);
    }

    public function mdlSelectEntrada($id){
        $this->selectedMaterialIndex = $id;
        $this->emit('showModal', '#mdlSelectEntrada');
    }

    public function setEntrada($entrada_id){
      $this->selectedEntrada = Entrada::findOrFail($entrada_id);
      $this->listadoMaterial[$this->selectedMaterialIndex]['entrada_id'] = $this->selectedEntrada->id;
      $this->listadoMaterial[$this->selectedMaterialIndex]['folio_entrada'] = $this->selectedEntrada->folio_short;
    }

    public function crearVale(){
      $this->validate();
      $vale = ValeMaterial::create([
        'personal_id' => $this->personal->id,
        'comentarios' => $this->comentarios,
        'user_id' => Auth::id(),
      ]);

      foreach($this->listadoMaterial as $item){
        $vale->materiales()->create([
          'entrada_id' => $item['entrada_id'],
          'material_id' => $item['material_id'],
          'numero_parte' => $item['numero_parte'],
          'material' => $item['descripcion'],
          'unidad_medida' => $item['unidad_medida'],
          'precio' => $item['precio'],
          'cantidad' => $item['cantidad'],
        ]);

        Material::find($item['material_id'])->decrement('existencia', $item['cantidad']);
      }


      //TODO: REFRESH QUANTITY OF MATERIAL MODAL
      $this->limpiar();
      $this->emit('redirect', "/materiales/vales/$vale->id/pdf");
      $this->emit('ok', 'Se ha creado vale de material');
    }
}
