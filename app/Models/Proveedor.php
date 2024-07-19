<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends CancelableModel
{
  use HasFactory;

  protected $table = 'proveedores';

  protected $fillable = [
    'nombre',
    'telefono',
    'correo',
    'rfc',
    'razon_social',
    'calle',
    'numero',
    'colonia',
    'codigo_postal',
    'ciudad',
    'estado'
  ];

  public function contactos(){
    return $this->morphMany(Contacto::class, 'model')->where('canceled_by', null);
  }

  public function setCalleAttribute($value){
    $this->attributes['calle'] = strtoupper($value);
  }

  public function setColoniaAttribute($value){
    $this->attributes['colonia'] = strtoupper($value);
  }

  public function setCiudadAttribute($value){
    $this->attributes['ciudad'] = strtoupper($value);
  }

  public function setEstadoAttribute($value){
    $this->attributes['estado'] = strtoupper($value);
  }

  public function getDireccionAttribute(){
    $dir = "";
    if($this->calle){
      $dir = $this->calle;
    }
    if($this->numero){
      $dir .= ' ' . $this->numero;
    }
    if($this->colonia){
      $dir .= ', ' . $this->colonia;
    }

    if(!$dir){
      $dir = 'SIN DIRECCIÓN';
    }
    return $dir;
  }

  public function getSumPagos($week, $year){
    if(!$week){
      $week = Carbon::now()->weekOfYear;
    }
    if(!$year){
      $year = Carbon::now()->year;
    }
    $dates = Entrada::getDateRange($year, $week, $week);
    // return PagoProveedor::where('proveedor_id', $this->id)
    // ->whereBetween('created_at', $dates)
    // ->sum('monto');

    $data = Pedido::where('proveedor_id', $this->id)
    ->whereBetween('created_at', $dates)->get();

    $total = collect($data)->sum('total');

    return $total;
  }

}
