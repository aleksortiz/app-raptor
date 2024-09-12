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
        'pagado',
        'no_factura',
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
        return $this->costo * ($this->porcentaje_mo / 100);
    }   

    public function getPorcentajeMoAttribute(){
        return $this->origen == 'ASEGURADORA' ? 25 : 20;
    }

    public function getAsignadoAttribute(){ 
        return $this->model->ordenes_trabajo->sum('monto');
    }
}
