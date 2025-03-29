<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Prestamo extends BaseModel
{
    protected $table = 'prestamos';

    protected $fillable = [
        'personal_id',
        'monto',
        'cuotas',
        'inicia',
        'user_id',
        // 'finaliza',
    ];

    protected static function boot(){
        parent::boot();

        static::creating(function($prestamo){
            $prestamo->finaliza = date('Y-m-d', strtotime($prestamo->inicia . ' + ' . $prestamo->cuotas . ' weeks'));
            $prestamo->user_id = Auth::id();
        });

        static::created(function($prestamo){
            $week = date('W', strtotime($prestamo->inicia));
            $year = date('Y', strtotime($prestamo->inicia));

            $cuota = $prestamo->monto / $prestamo->cuotas;

            for ($i=0; $i < $prestamo->cuotas; $i++) {

                $prestamo->pagos()->create([
                    'week' => $week,
                    'year' => $year,
                    'monto' => $cuota,
                    'fecha' => Carbon::today()->setISODate($year, $week, 6),
                ]);

                $week++;
                if($week > 52){
                    $week = 1;
                    $year++;
                }

            }
        });
    }

    public function personal(){
        return $this->belongsTo(Personal::class);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pagos(){
        return $this->hasMany(PrestamoDescuento::class);
    }

    public function getCuotaSemanalAttribute(){
        return $this->monto / $this->cuotas;
    }

    public function getCuotasPendientesAttribute(){
        return $this->pagos->where('pagado', false)->count();
    }

    public function getCuotasPagadasAttribute(){
        return $this->pagos->where('pagado', true)->count();
    }

    public function getPagadoAttribute(){
        return $this->pagos->where('pagado', true)->sum('monto');
    }

    public function getSaldoPendienteAttribute(){
        return $this->pagos->where('pagado', false)->sum('monto');
    }


}

