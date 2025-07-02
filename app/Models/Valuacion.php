<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valuacion extends BaseModel
{
    use HasFactory;

    protected $table = 'valuaciones';

    protected $fillable = [
        'cliente_id',
        'user_id',
        'numero_reporte',
        'marca',
        'modelo',
        'year',
        'color',
        'grua',
        'fecha_cita',
        'valuacion_efectuada',
        'notas',
        'entrada_id',
        'pago_danos',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function($valuacion){
            $valuacion->user_id = auth()->id();
        });

        static::created(function($valuacion){
            $valuacion->presupuestos()->create([
                'cliente_id' => $valuacion->cliente_id,
                'user_id' => auth()->id(),
                'model_id' => $valuacion->id,
                'model_type' => Valuacion::class,
                'marca' => $valuacion->marca,
                'modelo' => $valuacion->modelo,
                'year' => $valuacion->year,
                'color' => $valuacion->color,
                'subtotal' => 0,
                'iva' => 0,
                'total' => 0,
                'mecanica' => 0,
                'hojalateria' => 0,
                'pintura' => 0,
                'armado' => 0,
                'tasa_iva' => 0.16,
            ]);
        });
    }

    protected $casts = [
        'fecha_cita' => 'date',
        'valuacion_efectuada' => 'boolean',
        'pago_danos' => 'boolean',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function entrada(){
        return $this->belongsTo(Entrada::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function fotos(){
        return $this->morphMany(Foto::class, 'model');
    }

    public function setMarcaAttribute($value){
        $this->attributes['marca'] = trim(strtoupper($value));
    }

    public function setModeloAttribute($value){
        $this->attributes['modelo'] = trim(strtoupper($value));
    }

    public function setColorAttribute($value){
        $this->attributes['color'] = trim(strtoupper($value));
    }

    public function getVehiculoAttribute(){
        $vehiculo = $this->marca . ' ' . $this->modelo . ' ' . $this->year . ' ' . $this->color;
        return trim($vehiculo);
    }

    public function getEsGruaAttribute(){
        return $this->grua ? 'SI' : 'NO';
    }

    public function getEstadoAttribute(){
        return $this->valuacion_efectuada ? 'VALUADO' : 'PENDIENTE';
    }

    public function getGruaSpanAttribute(){
        return $this->grua ? '<button class="btn btn-xs btn-success"><i class="fa fa-trailer"></i> SI</button>' : '<button class="btn btn-xs btn-default"><i class="fa fa-car"></i> NO</button>';
    }

    public function getEstadoSpanAttribute(){
        return $this->valuacion_efectuada ? '<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> VALUADO</button>' : '<button class="btn btn-xs btn-warning"><i class="fa fa-clock"></i> PENDIENTE</button>';
    }

    public function getFechaCitaSpanAttribute(){
        $fecha_cita = Carbon::parse($this->fecha_cita)->format('M/d/Y h:i A');
        return $this->fecha_cita ? $fecha_cita : 'SIN CITA';
    }

    public function getEntradaSpanAttribute(){
        return $this->entrada ? '<a href="/servicios/' . $this->entrada->id . '" class="btn btn-xs btn-primary"><i class="fa fa-car"></i> ' . $this->entrada->folio_short . '</a>' : "SIN ENTRADA";
    }

    public function presupuestos(){
        return $this->morphMany(Presupuesto::class, 'model');
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

    public function getPagoDanosSpanAttribute()
    {
        return $this->pago_danos ? 
            '<button class="btn btn-xs btn-success"><i class="fa fa-check"></i> PAGADO</button>' : 
            '<button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> PENDIENTE</button>';
    }
}
