<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresupuestoCategoria extends Model
{
    use HasFactory;

    protected $table = 'presupuesto_categorias';

    protected $fillable = [
        'presupuesto_id',
        'nombre',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->orden = PresupuestoCategoria::where('presupuesto_id', $model->presupuesto->id)->count() + 1;
        });
    }

    public function presupuesto(){
        return $this->belongsTo(Presupuesto::class);
    }

    public function conceptos(){
        return $this->hasMany(PresupuestoConcepto::class);
    }

    public function getTotalAttribute(){
        if($this->conceptos)
            return $this->conceptos->sum('total');
        return 0;
    }

    public function getTotalCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return $this->total / $this->presupuesto->tipo_cambio;
        }
        return $this->total;
    }

    public function getTotalBrutoAttribute(){
        if($this->conceptos)
            return $this->conceptos->sum('importe_bruto');
        return 0;
    }

    public function getTotalBrutoCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return $this->total_bruto / $this->presupuesto->tipo_cambio;
        }
        return $this->total_bruto;
    }
}
