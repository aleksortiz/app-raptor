<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\Asignacion;

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
        'rfc',
        'razon_social',
        'domicilio_fiscal',
        'tarea_realizar',
        'proyeccion_entrega',
        'color',
        'year',
        'placas',
        'marca',
    ];

    protected $attributes = [
        'sucursal_id' => 1,
        'aseguradora_id' => 6,
        'origen' => 'ASEGURADORA',
        'servicio_interno' => false,
        'gasolina' => 0,
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->folio = Entrada::generarFolio();
            $model->area_trabajo = '[]';
        });

        self::saving(function ($model) {
            $model->marca = $model->fabricante->nombre;
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

    public function documentos()
    {
        return $this->morphMany(Documento::class, 'model');
    }

    public function refacciones()
    {
        return $this->morphMany(Refaccion::class, 'model');
    }

    public function refacciones_costo()
    {
        return $this->morphMany(Costo::class, 'model')->where('tipo', 'REFACCION');
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

    public function gastos(){
        return $this->hasMany(EntradaGasto::class, 'entrada_id');
    }

    public function fabricante()
    {
        return $this->belongsTo(Fabricante::class, 'fabricante_id');
    }

    public function getVehiculoAttribute()
    {
        $fab = strtoupper($this->marca);
        $modelo = strtoupper($this->modelo);
        $year = strtoupper($this->year);
        $color = strtoupper($this->color);
        return "{$fab} {$modelo} {$year} {$color}";
    }

    public static function generarFolio()
    {

        $week = str_pad(Carbon::today()->weekOfYear, 2, '0', STR_PAD_LEFT);
        $year = Carbon::today()->endOfWeek()->format('y');

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

    public function getNumeroReporteAttribute(){
        return $this->orden;
    }

    public function getFolioButtonAttribute()
    {
        return '<a href="/servicios/'. $this->id .'" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> ' . $this->folio_short . '</a>';
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

    public function getTotalGastosAttribute()
    {
        return $this->gastos->sum('monto');
    }

    public function total_materiales($dateStart, $dateEnd)
    {
        $materiales = $this->materiales()->whereBetween('created_at', [$dateStart, $dateEnd])->get();
        return $materiales->sum('importe');
    }

    public function getTotalRefaccionesAttribute()
    {
        $total1 = $this->refacciones->sum('importe');
        $total2 = $this->refacciones_costo->sum('venta');
        return $total1 + $total2;
    }

    public function getTotalCostosAttribute()
    {
        return $this->costos->sum('venta');
    }

    public function getTotalCostosPagadosAttribute()
    {
        return $this->costos->whereNotNull('pagado')->sum('venta');
    }

    public function getTotalCostosPendientesAttribute()
    {
        return $this->costos->whereNull('pagado')->sum('venta');
    }

    public function getTotalAttribute()
    {
        return $this->total_costos;
            // + $this->total_materiales
            // + $this->total_refacciones;
    }

    public function getTotalCostoRefaccionesAttribute()
    {
        $ref1 = $this->refacciones_costo->sum('costo');
        $ref2 = $this->refacciones->sum('costo_total');
        return $ref1 + $ref2;
    }

    public function getTotalCostoCostosAttribute()
    {
        return $this->costos->sum('costo');
    }

    public function getTotalUtilidadRefaccionesAttribute()
    {
        $utilidad1 = $this->refacciones->sum('utilidad');
        $utilidad2 = $this->refacciones_costo->sum('utilidad');
        return $utilidad1 + $utilidad2;
    }

    public function getTotalSueldosAttribute()
    {
        return $this->pagos_personal->sum('pago');
    }

    public function getTotalDestajosAttribute()
    {
        return $this->ordenes_trabajo->sum('monto');
    }

    public function getTotalUtilidadGlobalAttribute()
    {
        //SERVICIOS
        //UTILIDAD REFACCIONES
        //-MATERIALES
        //-SUELDOS
        //-DESTAJOS
        // $utilidad = $this->total_costos + $this->total_utilidad_refacciones;
        $utilidad = $this->total_costos;
        // $utilidad -= $this->total_costo_refacciones;
        $utilidad -= $this->total_gastos;
        $utilidad -= $this->total_costo_costos;
        $utilidad -= $this->total_materiales;
        $utilidad -= $this->total_sueldos;
        $utilidad -= $this->total_destajos;
        return $utilidad;
    }
    public function getPorcentajeUtilidadGlobalAttribute(){
        if ($this->total > 0) {
            return ($this->total_utilidad_global / $this->total) * 100;
        }
        return 0;
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

    public function getEntregaButtonAttribute()
    {
        if ($this->fecha_entrega) {
            $tooltip = "Vehiculo Entregado: ". $this->fecha_entrega_format;
            return ' <button style="cursor: pointer;" wire:click="editFechaEntrega(' . $this->id . ')" data-toggle="tooltip" data-placement="right" title="'.$tooltip.'" class="py-1 btn btn-xs btn-success"><i class="fa fa-check"></i> Veh. Entregado</button>';
        }
        else{
            return ' <button style="cursor: pointer;" wire:click="" onclick="confirm(\'Entregar vehículo: '.$this->vehiculo.'\', \'entregarVehiculo\', '. $this->id .')" class="py-1 btn btn-xs btn-warning"><i class="fa fa-car"></i> Veh. Pendiente</button>';
        }
    }

    public function getEstatusEntradaAttribute()
    {
        $count = collect($this->costos)->count();
        if($count <= 0){
            return 'N/A';
        }

        $data = "";
        $pending = collect($this->costos)->some(function($costo){
            return $costo->pagado == null;
        });

        if($pending){
            $data = '<button wire:click="mdlPagoServicios('.$this->id.')" class="py-1 btn btn-xs btn-warning"><i class="fa fa-clock"></i> Pendiente</button>';
        }
        else{
            $data = '<button wire:click="mdlPagoServicios('.$this->id.')" class="py-1 btn btn-xs btn-success"><i class="fa fa-check"></i> Pagado</button>';
        }

        return $data;
    }

    public function setMarcaAttribute($value)
    {
        $this->attributes['marca'] = trim(strtoupper($value));
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

    public function setPlacasAttribute($value)
    {
        $this->attributes['placas'] = trim(strtoupper($value));
    }

    public function setNumeroFacturaAttribute($value)
    {
        $this->attributes['numero_factura'] = strtoupper($value);
    }

    public function setRfcAttribute($value)
    {
        $this->attributes['rfc'] = strtoupper($value);
    }

    public function setRazonSocialAttribute($value)
    {
        $this->attributes['razon_social'] = strtoupper($value);
    }

    public function setDomicilioFiscalAttribute($value)
    {
        $this->attributes['domicilio_fiscal'] = strtoupper($value);
    }

    protected function setTareaRealizarAttribute($value)
    {
        $this->attributes['tarea_realizar'] = mb_strtoupper($value);
    }

    public function ordenes_trabajo()
    {
        return $this->hasMany(OrdenTrabajo::class, 'entrada_id');
    }

    public function ordenesTrabajo()
    {
        return $this->ordenes_trabajo();
    }

    public function ordenes_trabajo_pagos()
    {
        return $this->hasManyThrough(OrdenTrabajoPago::class, OrdenTrabajo::class);
    }

    public function getOrigenShortAttribute()
    {
        if($this->origen == 'AGENCIA'){
            return 'AG';
        }
        if ($this->origen == 'ASEGURADORA') {
            return 'AS';
        }
        if ($this->origen == 'PARTICULAR') {
            return 'PT';
        }
        if ($this->origen == 'GARANTIA'){
            return 'GT';
        }
        if ($this->origen == 'INTERNO'){
            return 'IT';
        }

        return 'N/A';
    }

    public function getOrigenColorAttribute()
    {
        if ($this->origen == 'ASEGURADORA') {
            return 'success';
        }
        if ($this->origen == 'PARTICULAR') {
            return 'secondary';
        }
        if ($this->origen == 'AGENCIA') {
            return 'primary';
        }
        if ($this->origen == 'GARANTIA') {
            return 'warning';
        }
        if ($this->origen == 'INTERNO') {
            return 'default';
        }
        return 'info';
    }

    public function getCheckPartsAttribute()
    {
        return $this->refacciones->some(function ($refaccion) {
            return $refaccion->costo == 0;
        });
    }

    public function getHasPartsAttribute()
    {
        return $this->refacciones->count() > 0;
    }

    public function registros_factura(){
        return $this->morphMany(RegistroFactura::class, 'model');
    }

    public function getMainPhotoAttribute()
    {
        if($this->fotos()->count() > 0){
            return $this->fotos()->first()->complete_thumb_url;
        }
        else{
            return asset('images/logo_new.jpg');
        }
    }

    /**
     * Obtiene las asignaciones de trabajo relacionadas con esta entrada
     */
    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public function avance()
    {
        return $this->hasOne(EntradaAvance::class, 'entrada_id');
    }

    public function getEstadoAttribute()
    {
        if($this->fecha_entrega){
            return 'ENTREGADO';
        }
        if ($this->avance) {
            return $this->avance->estado;
        }
        return 'PENDIENTE';
    }

    public function getEstadoButtonAttribute()
    {
        if($this->estado == 'ENTREGADO'){
            // return '<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> '. $this->estado .'</button>';
            $tooltip = "Vehiculo Entregado: ". $this->fecha_entrega_format;
            return ' <button style="cursor: pointer;" wire:click="editFechaEntrega(' . $this->id . ')" data-toggle="tooltip" data-placement="right" title="'.$tooltip.'" class="py-1 btn btn-xs btn-success"><i class="fa fa-check"></i> ENTREGADO</button>';
        }
        if($this->estado == 'TERMINADO'){
            return ' <button style="cursor: pointer;" wire:click="" onclick="confirm(\'Entregar vehículo: '.$this->vehiculo.'\', \'entregarVehiculo\', '. $this->id .')" class="py-1 btn btn-xs btn-primary"><i class="fa fa-check"></i> TERMINADO</button>';
        }
        else{
            return '<a href="/servicios/' . $this->id .'?activeTab=11" class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> '. $this->estado .'</a>';
        }
    }
    
    public function final_checklist(){
        return $this->hasOne(FinalChecklist::class, 'entrada_id');
    }
    
    /**
     * Obtiene las requisiciones de factura asociadas a esta entrada
     */
    public function requisiciones_factura()
    {
        return $this->morphMany(RequisicionFactura::class, 'model');
    }
    
    /**
     * Obtiene las valuaciones asociadas a esta entrada
     */
    public function valuaciones()
    {
        return $this->hasMany(Valuacion::class);
    }
}
