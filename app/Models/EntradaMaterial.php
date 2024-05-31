<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaMaterial extends BaseModel
{
    use HasFactory;

    protected $table = 'entrada_material';

    protected $fillable = [
        'entrada_id',
        'material_id',
        'numero_parte',
        'material',
        'unidad_medida',
        'precio',
        'cantidad',
    ];

    public function entrada(){
        return $this->belongsTo(Entrada::class);
    }

    public function getImporteAttribute(){
        return $this->precio * $this->cantidad;
    }
}
