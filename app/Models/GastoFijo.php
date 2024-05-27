<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoFijo extends Model
{
    use HasFactory;

    protected $fillable = [
        'concepto',
    ];

    static function registerLog($date, $concept, $amount)
    {
        GastoFijoLog::updateOrCreate(
            [
                'fecha' => $date,
                'concepto' => $concept
            ],
            [
                'monto' => $amount
            ]
        );
    }

    static function getAmount($concept, $year, $week)
    {
        $start = Entrada::getDateRange($year, $week, $week);
        $start = Carbon::parse($start[0]);
        $amount = GastoFijoLog::where('concepto', $concept)
            ->where('fecha', $start)
            ->sum('monto');
        return $amount;
    }
}
