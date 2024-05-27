<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evaluacion extends BaseModel
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'sucursal_id',
        'user_id',
        'no_reporte',
        'fabricante',
        'modelo',
        'notas',
        'entrada_id',
        'approved_at',
        'approved_by'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->user_id = auth()->user()->id;
        });
    }

    // protected $appends = ['sucursal', 'usuario'];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function setNoReporteAttribute($value){
        $this->attributes['no_reporte'] = strtoupper($value);
    }

    public function getNombreSucursalAttribute(){
        return $this->sucursal->nombre;
    }

    public function fotos(){
        return $this->morphMany(Foto::class, 'model');
    }

    public function documentos(){
        return $this->morphMany(Documento::class, 'model');
    }

    public function refacciones(){
        return $this->morphMany(Refaccion::class, 'model');
    }

    public function setFabricanteAttribute($value){
        $this->attributes['fabricante'] = strtoupper($value);
    }

    public function setModeloAttribute($value){
        $this->attributes['modelo'] = strtoupper($value);
    }

    public function getVehiculoAttribute(){
        return "{$this->fabricante} {$this->modelo}";
    }
}
