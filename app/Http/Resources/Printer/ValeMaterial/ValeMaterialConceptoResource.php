<?php

namespace App\Http\Resources\Printer\ValeMaterial;

use Illuminate\Http\Resources\Json\JsonResource;

class ValeMaterialConceptoResource extends JsonResource
{

    public function toArray($request)
    {
      return [
          'numero_parte' => $this->numero_parte,
          'unidad_medida' => $this->unidad_medida,
          'material' => $this->material,
          'cantidad' => $this->cantidad,
          'vehiculo' => $this->entrada->vehiculo,
          'folio' => $this->entrada->folio_short,
        ];
    }
}
