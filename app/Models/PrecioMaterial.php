<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrecioMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'precio_materiales';
    
    protected $fillable = [
        'material_id',
        'proveedor_id',
        'precio',
        'cantidad_paquete',
        'tiempo_entrega',
        'dias_habiles',
    ];

    protected $attributes = [
        'dias_habiles' => false,
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function material(){
        return $this->belongsTo(Material::class);
    }

    public function getEntregaAttribute(){
        $entrega = $this->tiempo_entrega;
        $entrega .= ' Día';
        $entrega .= $this->tiempo_entrega > 1 ? 's' : '';
        $entrega .= $this->dias_habiles ? ' Hábil' : ' Natural';
        $entrega .= $this->tiempo_entrega > 1 ? 'es' : '';
        return $entrega;
    }
}
