<?php

namespace App\Models\aoscore;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketLog extends Model
{
    use HasFactory;

    protected $connection = 'aoscore';

    protected $fillable = [
        'ticket_id',
        'status',
    ];

    public function getFechaCreacionAttribute(){
        $date = Carbon::parse($this->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function getStatusColorAttribute(){
        $color = 'default';
        switch ($this->status) {
            case 'ABIERTO':
                $color = 'primary';
                break;

            case 'EN CURSO':
                $color = 'info';
                break;

            case 'EN ESPERA':
                $color = 'warning';
                break;

            case 'ESPERANDO VALIDACION':
                $color = 'warning';
                break;

            case 'CERRADO':
                $color = 'success';
                break;
        }

        return $color;
    }
}
