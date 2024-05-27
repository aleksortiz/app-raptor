<?php

namespace App\Models;

use App\Models\shared\CancelableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presupuesto extends CancelableModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cliente_id',
        'especialidad_id',
        'folio',
        'titulo',
        'prestaciones',
        'supervision',
        'indirectos',
        'porcentaje_descuento',
        'descuento',
        'tasa_iva',
        'moneda',
        'tipo_cambio',
        'fecha_promesa',
        'atentamente',
        'margin',
        'notas',
        'canceled_at',
        'canceled_by',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->generarFolio();
            $model->margin = 25;
        });
    }

    protected $attributes = [
        'interno' => false,
        'concluido' => false,
        'mostrar_unitarios' => false,
        'notas' => 'A) ANTICIPO 30%, RESTO AL TERMINAR
B) PRECIOS SUJETOS A CAMBIO DEL SALARIO MINIMO, Y/O COSTO DE MATERIALES
C) TIEMPO DE ENTREGA
D) NO INCUYE VICIOS OCULTOS, CUALQUIER TRABAJO ADICIONAL SE COTIZARA POR SEPARADO
E) CRÉDITO A 30 DÍAS
F) PRECIOS VALIDOS POR 30 DIAS',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function contactos(){
        return $this->hasMany(ContactoPresupuesto::class)->orderBy('orden');
    }

    public function categorias(){
        return $this->hasMany(PresupuestoCategoria::class)->orderBy('orden');
    }

    public function conceptos(){
        return $this->hasMany(PresupuestoConcepto::class);
    }

    public function materiales(){
        return $this->hasMany(PresupuestoMaterial::class);
    }

    public function especialidad(){
        return $this->belongsTo(PresupuestoEspecialidad::class, 'especialidad_id');
    }

    public function comentarios(){
        return $this->morphMany(Comentario::class, 'model');
    }

    public function envios_correo(){
        return $this->morphMany(EnvioCorreo::class, 'model');
    }

    public function proyecto(){
        return $this->hasOne(Proyecto::class);
    }

    public function getTituloShortAttribute(){
        $title = $this->attributes['titulo'];
        if(strlen($title) > 30){
            return substr($title, 0, 30) . "...";
        }
        return $title;
    }

    public function getPrestacionesAttribute(){
        if($this->attributes['prestaciones']){
            return $this->attributes['prestaciones'];
        }
        return 0;
    }

    public function getSupervisionAttribute(){
        if($this->attributes['supervision']){
            return $this->attributes['supervision'];
        }
        return 0;
    }

    public function getIndirectosAttribute(){
        if($this->attributes['indirectos']){
            return $this->attributes['indirectos'];
        }
        return 0;
    }

    public function getDescuentoCantidadAttribute(){
        if($this->descuento){
            return $this->descuento;
        }
        else if($this->porcentaje_descuento){
            return $this->subtotal_sin_descuento * ($this->porcentaje_descuento / 100);
        }
        return 0;
    }

    public function getDescuentoAttribute(){
        if($this->attributes['descuento']){
            return $this->attributes['descuento'];
        }
        return 0;
    }

    public function getPorcentajeDescuentoAttribute(){
        if($this->attributes['porcentaje_descuento']){
            return $this->attributes['porcentaje_descuento'];
        }
        return 0;
    }

    public function getDescuentoCurrencyAttribute(){
        if($this->moneda != 'MXN'){
            return $this->descuento_cantidad / $this->tipo_cambio;
        }
        return $this->descuento_cantidad;
    }

    public function generarFolio(){
        if($this->cliente_id && $this->especialidad_id){
            $datePx = Carbon::today()->format('ym');
            $clienteAbrv = strtoupper($this->cliente->abreviacion);
            $espAbrv = strtoupper($this->especialidad->abreviacion);
            $consecutivo = Presupuesto::whereBetween('created_at', [
                Carbon::today()->startOfMonth()->toDateTimeString(), 
                Carbon::today()->endOfMonth()->toDateTimeString()
            ])->count();
            $consecutivo++;
            $consecutivo = str_pad($consecutivo, 3, '0', STR_PAD_LEFT);
            $this->folio = $datePx . $consecutivo . $clienteAbrv . $espAbrv;
        }
    }

    public function getFechaFormatAttribute(){
        $format = 'M-d';
        $dateParsed = Carbon::parse($this->created_at);
        if($dateParsed->year != Carbon::now()->year){
            $format = 'M-d Y';
        }
        return $dateParsed->format($format);
    }

    public function getSubtotalSinDescuentoAttribute(){
        if($this->conceptos){
            return round($this->conceptos->sum('total'), 2);
        }
        return 0;
    }

    public function getSubtotalAttribute(){
        if($this->conceptos){
            $desc = $this->descuento_cantidad;
            return round($this->conceptos->sum('total'), 2) - round($desc, 2);
        }
        return 0;
    }

    public function getSubtotalCurrencyAttribute(){
        if($this->conceptos){
            $desc = $this->descuento_currency ?? 0;
            return round($this->conceptos->sum('total_currency'),2) - round($desc, 2);
        }
        return 0;
    }

    public function getTotalAttribute(){
        return round($this->subtotal, 2) + round($this->iva, 2);
    }

    public function getTotalCurrencyAttribute(){
        return round($this->subtotal_currency, 2) + round($this->iva_currency, 2);

    }

    public function getFactorIvaAttribute(){
        return $this->tasa_iva / 100;
    }

    public function getIvaAttribute(){
        return $this->subtotal * ($this->factor_iva);
    }

    public function getIvaCurrencyAttribute(){
        if($this->moneda != 'MXN'){
            return $this->subtotal_currency * ($this->factor_iva);
        }
        return $this->iva;
    }

    public function getMontoOriginalAttribute(){
        if($this->conceptos)
            return $this->conceptos->sum('importe_bruto');
        return 0;
    }

    public function getTotalPrestacionesAttribute(){
        if($this->conceptos)
            return $this->conceptos->sum('importe_prestaciones');
        return 0;
    }

    public function getTotalSupervisionAttribute(){
        if($this->conceptos)
            return $this->conceptos->sum('importe_supervision');
        return 0;
    }

    public function getTotalIndirectosAttribute(){
        if($this->conceptos)
            return $this->conceptos->sum('importe_indirectos');
        return 0;
    }

    public function total_indirectos(){
        if($this->conceptos)
            return $this->conceptos->sum('importe_indirectos');
        return 0;
    }

    public function getEstatusAttribute(){
        if($this->canceled_at){
            return 'CANCELADO';
        }
        if($this->proyecto){
            if($this->proyecto->concluido){
                return 'PROYECTO_CONCLUIDO';
            }
            else{
                return 'PROYECTO';
            }
        }
        if($this->interno){
            return 'INTERNO';
        }
        if($this->envios_correo->count() > 0){
            return 'ENVIADO';
        }
        if($this->concluido){
            return 'CONCLUIDO';
        }
        if(Carbon::now() > Carbon::parse($this->fecha_promesa)){
            return 'EXCEDIDO';
        }

        if($this->prestaciones > 0 || $this->supervision > 0 || $this->indirectos > 0){
            return 'FACTORES';
        }

        return 'NUEVO';
    }

    public function getColorAttribute(){
        $status = $this->estatus;

        switch ($status) {
            case 'CONCLUIDO':
                return ['#F0E68C', 'black'];
                break;

            case 'NUEVO':
                return ['', ''];
                break;

            case 'EXCEDIDO':
                return ['#CD5C5C', 'white'];
                break;

            case 'FACTORES':
                return ['#AFEEEE', 'black'];
                break;

            case 'ENVIADO':
                return ['#3CB371', 'white'];
                break;

            case 'CANCELADO':
                return ['#DCDCDC', 'black'];
                break;

            case 'INTERNO':
                return ['#4682B4', 'white'];
                break;

            case 'PROYECTO':
                return ['#FF4500', 'white'];
                break;

            case 'PROYECTO_CONCLUIDO':
                return ['#FFA500', 'black'];
                break;
        }
    }

    public function getMontoOriginalCurrencyAttribute(){
        if($this->moneda != 'MXN'){
            return $this->monto_original / $this->tipo_cambio;
        }
        return $this->monto_original;
    }

    // public function getDescuentoCantidadCurrencyAttribute(){
    //     if($this->moneda != 'MXN'){
    //         return $this->descuento_cantidad / $this->tipo_cambio;
    //     }
    //     return $this->descuento_cantidad;
    // }

    public function getTotalPrestacionesCurrencyAttribute(){
        if($this->moneda != 'MXN'){
            return $this->total_prestaciones / $this->tipo_cambio;
        }
        return $this->total_prestaciones;
    }

    public function getTotalSupervisionCurrencyAttribute(){
        if($this->moneda != 'MXN'){
            return $this->total_supervision / $this->tipo_cambio;
        }
        return $this->total_supervision;
    }

    public function getTotalIndirectosCurrencyAttribute(){
        if($this->moneda != 'MXN'){
            return $this->total_indirectos / $this->tipo_cambio;
        }
        return $this->total_indirectos;
    }

}
