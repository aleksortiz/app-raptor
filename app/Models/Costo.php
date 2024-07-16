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

    public function getFechaPagoFormatAttribute()
    {
        if ($this->pagado) {
            return Carbon::parse($this->pagado)->format('M/d/y h:i A');
        }
        return "N/A";
    }
}
