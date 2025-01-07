<?php

namespace App\Http\Resources\Printer\ValeMaterial;

use Illuminate\Http\Resources\Json\JsonResource;

class ValeMaterialResource extends JsonResource
{

    public function toArray($request)
    {
      return [
          'fecha' => $this->fecha_creacion,
          'folio' => $this->id_paddy,
          'autoriza' => $this->user->name,
          'entrega' => $this->personal->nombre,
          'notas' => $this->comentarios,
          'materiales' => ValeMaterialConceptoResource::collection($this->materiales),
        ];
    }
}
