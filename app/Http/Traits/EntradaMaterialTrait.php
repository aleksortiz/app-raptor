<?php


namespace App\Http\Traits;

use App\Models\EntradaMaterial;
use App\Models\Foto;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;

trait EntradaMaterialTrait {

    public function setMaterial($entrada_id, $material_id, $cantidad)
    {
        $material = Material::findOrFail($material_id);
        EntradaMaterial::create([
            'entrada_id' => $entrada_id,
            'material_id' => $material->id,
            'cantidad' => $cantidad,
            'numero_parte' => $material->numero_parte,
            'material' => $material->descripcion,
            'unidad_medida' => $material->unidad_medida,
            'precio' => $material->precio,
        ]);

        Material::where('id', $material->id)->decrement('existencia', $cantidad);
    }
}