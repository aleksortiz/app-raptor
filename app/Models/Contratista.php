<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contratista extends CancelableModel
{
    use HasFactory;
  
    protected $table = 'contratistas';
  
    protected $fillable = [
      'nombre',
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
    
  }
