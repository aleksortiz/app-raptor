<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CitaReparacion extends BaseModel
{
    use HasFactory;

    protected $table = 'cita_reparacion';

    protected $fillable = [
      'cliente_id',
      'marca',
      'modelo',
      'no_reporte',
      'cita',
      'inventario_id',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function getVehiculoAttribute()
    {
        $fab = strtoupper($this->marca);
        $modelo = strtoupper($this->modelo);
        return "{$fab} {$modelo}";
    }

    public function getCitaFormatAttribute(){
      $date = Carbon::parse($this->cita);
      $format = 'M/d/Y h:i A';
      if ($date->year = Carbon::now()->year){
          $format = 'M/d h:i A';
      }
      return $date->format($format);
  }
}
