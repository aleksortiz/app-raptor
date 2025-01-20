<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presupuesto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'user_id',
        'model_id',
        'model_type',
        'marca',
        'modelo',
        'year',
        'color',
        'subtotal',
        'iva',
        'total',
        'mecanica',
        'hojalateria',
        'pintura',
        'armado',
    ];

    protected static function boot(){
      parent::boot();
      static::saving(function($presupuesto){
        // $presupuesto->iva = $presupuesto->iva;
        // $presupuesto->total = $presupuesto->total;
      });
    }

    public function model(){
      return $this->morphTo();
    }

    public function cliente(){
      return $this->belongsTo(Cliente::class);
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function conceptos(){
      return $this->hasMany(PresupuestoConcepto::class);
    }

    public function getTotalManoObraAttribute(){
      return $this->conceptos->sum('mano_obra');
    }

    public function getTotalRefaccionesAttribute(){
      return $this->conceptos->sum('refacciones');
    }

    public function getVehiculoAttribute(){
      $vehiculo = $this->marca . ' ' . $this->modelo . ' ' . $this->year . ' ' . $this->color;
      return trim($vehiculo);
    }
}
