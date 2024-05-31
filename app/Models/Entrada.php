<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Entrada extends BaseModel
{

    protected $fillable = [
        'folio',
        'cliente_id',
        'sucursal_id',
        'user_id',
        'origen',
        'aseguradora_id',
        'fabricante_id',
        'modelo',
        'notas',
        'serie',
        'orden',
        'area_trabajo',
        'estatus',
        'estatus_factura',
        'servicio_interno',
        'fecha_pago',
        'fecha_concluido',
        'fecha_entrega',
        'fecha_pago_refacciones',
    ];

    protected $attributes = [
        'sucursal_id' => 1,
        'aseguradora_id' => 6,
        'origen' => 'ASEGURADORA',
        'servicio_interno' => false,
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->folio = Entrada::generarFolio();
            $model->area_trabajo = '[]';
        });
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function fotos()
    {
        return $this->morphMany(Foto::class, 'model');
    }

    public function refacciones()
    {
        return $this->morphMany(Refaccion::class, 'model');
    }

    public function materiales()
    {
        return $this->hasMany(EntradaMaterial::class, 'entrada_id');
    }

    public function pagos_personal()
    {
        return $this->hasMany(PagoPersonal::class);
    }

    public function costos()
    {
        return $this->morphMany(Costo::class, 'model');
    }

    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class, 'fabricante_id');
    }

    public function getVehiculoAttribute()
    {
        $fab = strtoupper($this->fabricante->nombre);
        $modelo = strtoupper($this->modelo);
        return "{$fab} {$modelo}";
    }

    public static function generarFolio()
    {

        $week = str_pad(Carbon::today()->weekOfYear, 2, '0', STR_PAD_LEFT);
        $year = Carbon::today()->format('y');

        $consecutivo = Entrada::whereBetween('created_at', [
            Carbon::today()->startOfWeek()->toDateTimeString(),
            Carbon::today()->endOfWeek()->toDateTimeString()
        ])->count();
        $consecutivo++;
        $consecutivo = str_pad($consecutivo, 2, '0', STR_PAD_LEFT);
        return "{$week}-{$consecutivo}-{$year}";
    }

    public static function getDateRange($year, $weekStart, $weekEnd)
    {
        $date = new Carbon();
        $start = $date->isoWeekYear($year)->isoWeek($weekStart)->startOfWeek();
        $end = $date->isoWeekYear($year)->isoWeek($weekEnd)->endOfWeek();
        return [$start, $end];
    }

    public function getFolioShortAttribute()
    {
        $year = Carbon::today()->format('y');
        if (str_ends_with($this->folio, $year)) {
            return substr($this->folio, 0, 5);
        }
        return $this->folio;
    }

    public function getTotalMaterialesAttribute()
    {
        return $this->materiales->sum('importe');
    }

    public function getTotalRefaccionesAttribute()
    {
        return $this->refacciones->sum('importe');
    }

    public function getTotalCostosAttribute()
    {
        return $this->costos->sum('costo');
    }

    public function getTotalAttribute()
    {
        return $this->total_costos
            // + $this->total_materiales
            + $this->total_refacciones;
    }

    public function getTotalCostoRefaccionesAttribute()
    {
        return $this->refacciones->sum('costo_total');
    }

    public function getTotalUtilidadRefaccionesAttribute()
    {
        return $this->refacciones->sum('utilidad');
    }

    public function getTotalSueldosAttribute()
    {
        return $this->pagos_personal->sum('pago');
    }

    public function getTotalDestajosAttribute()
    {
        return $this->ordenes_trabajo_pagos->sum('monto');
    }

    public function getTotalUtilidadGlobalAttribute()
    {
        //SERVICIOS
        //UTILIDAD REFACCIONES
        //-MATERIALES
        //-SUELDOS
        //-DESTAJOS
        $utilidad = $this->total_costos + $this->total_utilidad_refacciones;
        $utilidad -= $this->total_materiales;
        $utilidad -= $this->total_sueldos;
        $utilidad -= $this->total_destajos;
        return $utilidad;
    }

    public function getFechaEntregaFormatAttribute()
    {
        return Carbon::parse($this->fecha_entrega)->format('M/d/y h:i A');
    }

    public function getFechaPagoFormatAttribute()
    {
        return Carbon::parse($this->fecha_pago)->format('M/d/y h:i A');
    }

    public function getFechaPagoRefaccionesFormatAttribute()
    {
        return Carbon::parse($this->fecha_pago_refacciones)->format('M/d/y h:i A');
    }

    public static function CatalogoModelos()
    {
        $data = Cache::get('modelos', null);
        if ($data == null) {
            $modelos = Entrada::distinct('modelo')->orderBy('modelo')->pluck('modelo');
            $data = array_map(function ($elem) {
                return strtoupper(trim($elem));
            }, $modelos->toArray());
            Cache::set('modelos', $data, 60 * 60 * 4); // 4 Hrs
        }
        return $data;
    }

    public function getEstatusEntradaAttribute()
    {
        $data = "";
        if($this->refacciones()->count() > 0){
            if ($this->fecha_pago_refacciones) {
                $tooltip = "Refacciones Pagadas: ". $this->fecha_pago_refacciones_format;
                $data .= '<span style="cursor: pointer;" wire:click="editFechaPagoRefacciones(' . $this->id . ')" data-toggle="tooltip" data-placement="right" title="'.$tooltip.'" class="py-1 badge badge-success">Ref. Pagadas</span>';
            }
            else {
                $data .= '<span style="cursor: pointer;" wire:click="" onclick="confirm(\'Pagar refacciones: '.$this->vehiculo.'\', \'pagarRefacciones\', '. $this->id .')" class="py-1 badge badge-warning">Ref. Pendientes</span>';
            }
        }
        
        if ($this->fecha_entrega) {
            $tooltip = "Vehiculo Entregado: ". $this->fecha_entrega_format;
            $data .= ' <span style="cursor: pointer;" wire:click="editFechaEntrega(' . $this->id . ')" data-toggle="tooltip" data-placement="right" title="'.$tooltip.'" class="py-1 badge badge-success">Veh. Entregado</span>';
        }
        else{
            $data .= ' <span style="cursor: pointer;" wire:click="" onclick="confirm(\'Entregar vehículo: '.$this->vehiculo.'\', \'entregarVehiculo\', '. $this->id .')" class="py-1 badge badge-warning">Veh. Pendiente</span>';
        }

        if ($this->fecha_pago) {
            $tooltip = "Entrada Pagada: ". $this->fecha_pago_format;
            $data .= ' <span style="cursor: pointer;" wire:click="editFechaPago(' . $this->id . ')" data-toggle="tooltip" data-placement="right" title="'.$tooltip.'" class="py-1 badge badge-success">Pagado</span>';
        }
        else{
            $data .= ' <span style="cursor: pointer;" wire:click="" onclick="confirm(\'Pagar Entrada: '.$this->vehiculo.'\', \'pagarEntrada\', '. $this->id .')" class="py-1 badge badge-warning">Pago Pendiente</span>';
        }
        return $data;
    }

    public function setSerieAttribute($value)
    {
        $this->attributes['serie'] = strtoupper($value);
    }

    public function setModeloAttribute($value)
    {
        $this->attributes['modelo'] = strtoupper($value);
    }

    public function setOrdenAttribute($value)
    {
        $this->attributes['orden'] = strtoupper($value);
    }

    public function setNumeroFacturaAttribute($value)
    {
        $this->attributes['numero_factura'] = strtoupper($value);
    }

    public function ordenes_trabajo()
    {
        return $this->hasMany(OrdenTrabajo::class);
    }

    public function ordenes_trabajo_pagos()
    {
        return $this->hasManyThrough(OrdenTrabajoPago::class, OrdenTrabajo::class);
    }
}
