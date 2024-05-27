<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoEspecialidad extends Model
{
    protected $table = "presupuesto_especialidades";
    
    use HasFactory;

    public function presupuestos(){
        return $this->hasMany(Presupuesto::class, 'especialidad_id');
    }
}
