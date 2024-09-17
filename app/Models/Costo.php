<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costo extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'model_type',
        'concepto',
        'costo',
        'venta',
        'pagado',
        'no_factura',
        'tipo',
    ];

    protected $attributes = [
        'costo' => '0',
        'venta' => '0',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function setNoFacturaAttribute($value)
    {
        $this->attributes['no_factura'] = strtoupper($value);
    }

    public function getFechaPagoFormatAttribute()
    {
        if ($this->pagado) {
            return Carbon::parse($this->pagado)->format('M/d/y h:i A');
        }
        return "N/A";
    }

    public function getFolioAttribute(){
        return $this->model->folio_short;
    }

    public function getOrigenAttribute(){
        return $this->model->origen;
    }

    public function getVehiculoAttribute(){
        return $this->model->vehiculo;
    }

    public function getPresupuestoMoAttribute(){
        return $this->venta * ($this->porcentaje_mo / 100);
    }

    public function getPorcentajeMoAttribute(){
        return 30;
    }

    public function getAsignadoAttribute(){
        return $this->model->ordenes_trabajo->sum('monto');
    }

    public function getPorcentajeAsignadoAttribute(){
        if($this->venta == 0){
            return 0;
        }
        $p = $this->asignado / $this->venta * 100;
        return number_format($p, 2);
    }

    public function getIsOverBudgetAttribute(){
        return $this->porcentaje_asignado > $this->porcentaje_mo;
    }

    public function getOrigenColorAttribute(){
        return $this->model->origen_color;
    }

    public function getOrigenShortAttribute(){
        return $this->model->origen_short;
    }

    public function refacciones(){
        return $this->morphMany(Refaccion::class, 'model');
    }
}
