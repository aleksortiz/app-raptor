<?php

namespace App\Models;

use App\Http\Traits\Common\CancelableModelTrait;
use App\Models\shared\CancelableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends CancelableModel
{
  use HasFactory, CancelableModelTrait;
  protected $table = 'clientes';

  protected $fillable = [
    'nombre',
    'telefono',
    'abreviacion',
    'rfc',
    'razon_social',
    'calle',
    'numero',
    'colonia',
    'codigo_postal',
    'ciudad',
    'estado'
  ];

  public function setCalleAttribute($value)
  {
    $this->attributes['calle'] = strtoupper($value);
  }

  public function setColoniaAttribute($value)
  {
    $this->attributes['colonia'] = strtoupper($value);
  }

  public function setCiudadAttribute($value)
  {
    $this->attributes['ciudad'] = strtoupper($value);
  }

  public function setEstadoAttribute($value)
  {
    $this->attributes['estado'] = strtoupper($value);
  }

  public function getDireccionAttribute()
  {
    $dir = "";
    if ($this->calle) {
      $dir = $this->calle;
    }
    if ($this->numero) {
      $dir .= ' ' . $this->numero;
    }
    if ($this->colonia) {
      $dir .= ', ' . $this->colonia;
    }

    if (!$dir) {
      $dir = 'SIN DIRECCIÓN';
    }
    return $dir;
  }

  public function getAbreviacionAttribute()
  {
    return strtoupper($this->attributes['abreviacion']);
  }

  public function contactos()
  {
    return $this->morphMany(Contacto::class, 'model')->where('deleted_by', null);
  }

  public function entradas()
  {
    return $this->hasMany(Entrada::class, 'cliente_id');
  }

  public function getNombreShortAttribute()
  {
    $name = $this->attributes['nombre'];
    if (strlen($name) > 20) {
      return substr($name, 0, 20) . "...";
    }
    return $name;
  }

  public function flotillas(){
    return $this->hasMany(Flotilla::class, 'cliente_id');
  }

  public function createIdentifier(){
    $this->identificador = uniqid() . $this->id;
    $this->save();
  }


}
