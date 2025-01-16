<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoConcepto extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_conceptos';

    protected $fillable = [
        'presupuesto_id',
        'nomenclatura',
        'cantidad',
        'descripcion',
        'mano_obra',
        'refacciones',
    ];

    public function getPrecioUnitarioAttribute(){
      return $this->mano_obra + $this->refacciones;
    }

    public function getImporteAttribute(){
      return $this->cantidad * $this->precio;
    }
}
