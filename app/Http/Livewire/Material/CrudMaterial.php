<?php

namespace App\Http\Livewire\Material;

use App\Http\Controllers\ReportController;
use App\Http\Livewire\shared\LivewireBaseCrudController;
use App\Models\Entrada;
use App\Http\Traits\EntradaMaterialTrait;
use App\Models\Material;
use App\Models\PrecioMaterial;
use App\Models\Proveedor;

class CrudMaterial extends LivewireBaseCrudController
{
    use EntradaMaterialTrait;

    protected $model_name = "Material";
    protected $model_name_plural = "Materiales";

    public $searchValueProveedor;
    public $proveedor;
    public PrecioMaterial $precioMaterial;

    public $folios = [];
    public $selectedMaterial;
    public $folioSearch;
    public $gotoFolio;

    public $isTaller = false;
    public $cantidadTaller;

    public function updatingSearchValueProveedor()
    {
        $this->resetPage('providersPage');
    }

    public function rules()
    {
        return [
            'model.numero_parte' => "string|nullable|min:3|max:255|unique:materiales,numero_parte,{$this->model->id}",
            'model.categoria' => 'string|required|min:3|max:255',
            'model.descripcion' => 'string|required|min:5|max:255',
            'model.unidad_medida' => 'string|required|min:2|max:10',
            'model.precio' => 'numeric|required|min:0',
            'model.existencia' => 'numeric|required',
            'model.comentarios' => 'string|nullable',

            'folios.*.cantidad' => 'numeric',
        ];
    }

    public function save()
    {
        $this->validate([
            'model.numero_parte' => "string|nullable|min:3|max:255|unique:materiales,numero_parte,{$this->model->id}",
            'model.categoria' => 'string|required|min:3|max:255',
            'model.descripcion' => 'string|required|min:5|max:255',
            'model.unidad_medida' => 'string|required|min:2|max:10',
            'model.precio' => 'numeric|required|min:0',
            'model.existencia' => 'numeric|required',
            'model.comentarios' => 'string|nullable',
        ]);

        $this->model->numero_parte = trim($this->model->numero_parte);
        $this->model->save();
        $this->emit('ok', "Se ha guardado {$this->model_name_lower}: {$this->model->descripcion}", $this->model->codigo);
        $this->emit('closeModal', '#mdl');
    }

    public function resetInput()
    {
        $this->resetValidation();
        $this->model = new Material();
        $this->precioMaterial = new PrecioMaterial();
    }

    public function getData(){
        return $this->model::orderBy('id', 'ASC')
        ->where('active', 1)
        ->where(function ($query) {
            $query->where('numero_parte', 'LIKE', "%{$this->keyWord}%")
            ->orWhere('descripcion', 'LIKE', "%{$this->keyWord}%");
        });
    }

    public function exportToExcel()
    {
        $data = $this->getData()->get();

        $headers = [
            'Numero de Parte',
            'Categoria',
            'Descripcion',
            'Unidad de Medida',
            'Precio',
            'Existencia',
        ];

        $arrayData = $data->map(function ($item) {
            return [
                $item->numero_parte,
                $item->categoria,
                $item->descripcion,
                $item->unidad_medida,
                $item->precio,
                $item->existencia,
            ];
        });
        $reportDate = date('Y-m-d');
        $fileName = "materiales_{$reportDate}_.csv";
        return ReportController::downloadCSV($fileName, $headers, $arrayData);
    }

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $data = $this->getData()->paginate(50);
        $proveedores = $this->getProveedores();

        return view('livewire.material.crud-material.view', compact('data', 'proveedores'));
    }

    public function viewProveedores($id)
    {
        $this->model = $this->model::findOrFail($id);
        $this->emit('showModal', '#mdlPreciosProveedores');
    }

    public function getProveedores()
    {
        $keyWord = '%' . $this->searchValueProveedor . '%';
        return Proveedor::orderBy('id', 'ASC')
            ->orWhere('nombre', 'LIKE', $keyWord)
            ->orWhere('razon_social', 'LIKE', $keyWord)
            ->paginate(30, ['*'], 'providersPage');
    }

    public function setProveedor($id)
    {
        $this->proveedor = Proveedor::findOrFail($id);
        $this->precioMaterial = new PrecioMaterial();
        // $this->resetPage();
        $this->resetValidation();
        $this->emit('closeModal', '#mdlSelectProveedor');
        $this->emit('showModal', '#mdlPrecioProveedor');
    }

    public function savePrecioMaterial()
    {
        $this->validate([
            'precioMaterial.precio' => 'numeric|required|min:0',
            'precioMaterial.cantidad_paquete' => 'numeric|required|min:1',
            'precioMaterial.tiempo_entrega' => 'numeric|required|min:0',
            'precioMaterial.dias_habiles' => 'boolean',
        ]);

        $this->precioMaterial->material_id = $this->model->id;
        $this->precioMaterial->proveedor_id = $this->proveedor->id;
        $this->precioMaterial->save();
        $this->model->load('precios');

        $this->resetValidation();
        $this->precioMaterial = new PrecioMaterial();

        $this->emit('closeModal', '#mdlPrecioProveedor');
        $this->emit('ok', 'Se ha agregado precio');
    }

    public function viewPrecioMaterial($id)
    {
        $this->precioMaterial = PrecioMaterial::findOrFail($id);
        $this->proveedor = $this->precioMaterial->proveedor;
        $this->resetValidation();
        $this->emit('showModal', '#mdlPrecioProveedor');
    }

    public function deletePrecioMaterial($id)
    {
        $this->precioMaterial = PrecioMaterial::findOrFail($id);
        if ($this->precioMaterial->delete()) {
            $this->model->load('precios');
            $this->emit('ok', "Se ha eliminado precio");
        }
    }

    public function searchFolioHandler()
    {
        $this->folioSearch = trim($this->folioSearch);
        if (strlen($this->folioSearch) <= 4) {
            $this->folios = [];
            return;
        }

        $entradas = Entrada::where('folio', 'LIKE', "{$this->folioSearch}%")
        ->orderBy('id', 'DESC')
        ->get();
        $this->folios = $entradas->map(function ($item) {
            $item->cantidad = 0;
            return $item;
        });
    }

    public function mdlAsignarMaterial($id)
    {
        $this->cantidadTaller = null;
        $this->selectedMaterial = Material::findOrFail($id);

        // $this->folios = Entrada::all();
        // $this->folios->map(function ($item) {
        //     $item->cantidad = 0;
        // });

        $this->emit('showModal', '#mdlAsignarMaterial');
    }

    public function asignarMaterial($index)
    {
        if($index==null){
            $entrada_id = null;
            $cantidad = $this->cantidadTaller;
            $material_id = $this->selectedMaterial->id;
        }else{
            $entrada_id = $this->folios[$index]['id'];
            $cantidad = $this->folios[$index]['cantidad'];
            $material_id = $this->selectedMaterial->id;
        }

        if (!$cantidad) {
            $this->emit('info', 'Ingrese cantidad válida');
            return;
        }

        if ($cantidad > $this->selectedMaterial->existencia) {
            $this->emit('info', 'No hay suficiente material en existencia');
            return;
        }

        $this->setMaterial($entrada_id, $material_id, $cantidad);
        $this->isTaller = false;
        $this->cantidadTaller = null;
        $this->emit('closeModal', '#mdlAsignarMaterial');
        $this->emit('ok', "Se han asignado material: <br> {$this->selectedMaterial->descripcion} - Cant: {$cantidad}");
    }

    public function redirectFolio(){
        $folio = trim($this->gotoFolio);
        if (strlen($folio) <= 4) {
            return;
        }
        
        $this->gotoFolio = '';

        $entrada = Entrada::orderBy('id', 'DESC')->where('folio', 'LIKE', "{$folio}%")->first();
        if (!$entrada) {
            $this->emit('info', 'Folio no encontrado');
            return;
        }

        $this->emit('redirect', "servicios/{$entrada->id}?activeTab=6");
    }
}
