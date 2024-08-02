<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicioFlotillaRequest extends FormRequest
{
    
    public function rules()
    {
        return [
            'flotilla_unidad_id' => 'numeric|required|min:0',
            'tipo_servicio' => 'string|required|max:255',
            'descripcion' => 'string|required|max:255',
            'fecha_servicio' => 'date|required',
            'costo' => 'numeric|required|min:0',
            'kilometraje' => 'numeric|required|min:0',
            'ubicacion' => 'string|required|max:255',
        ];
    }
}
