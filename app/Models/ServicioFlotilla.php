<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicioFlotilla extends BaseModel
{
    use HasFactory;

    protected $table = 'servicio_flotillas';

    protected $fillable = [
        'flotilla_unidad_id',
        'tipo_servicio',
        'descripcion',
        'fecha_servicio',
        'costo',
        'kilometraje',
        'ubicacion',
        'estatus_servicio',
        'fecha_concluido',
        'tecnico_asignado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_servicio' => 'datetime',
        'costo' => 'float',
        'kilometraje' => 'integer',
    ];

    public function fotos(){
        return $this->morphMany(Foto::class, 'model');
    }

    public function flotillaUnidad()
    {
        return $this->belongsTo(FlotillaUnidad::class, 'flotilla_unidad_id');
    }

    public function getFechaServicioFormatAttribute(){
        return Carbon::parse($this->fecha_servicio)->format('m-d-Y h:i A');
    }

    public function getEstatusServicioBtnAttribute(){
        $btn = 'btn btn-xs btn-';
        switch ($this->estatus_servicio) {
            case 'PENDIENTE':
                $btn .= 'warning';
                break;
            case 'ESPERANDO REFACCIONES':
                $btn .= 'info';
                break;
            case 'CANCELADO':
                $btn .= 'default';
                break;
            case 'FINALIZADO':
                $btn .= 'success';
                break;

            case 'NO SE PUEDO REALIZAR':
                $btn .= 'success';
                break;
            default:
                $btn .= 'secondary';
                break;
        }
        return $btn;
    }
}
