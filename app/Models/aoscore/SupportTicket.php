<?php

namespace App\Models\aoscore;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SupportTicket extends Model
{
    use HasFactory;

    protected $connection = 'aoscore';

    protected $fillable = [
        // 'app_name',
        // 'user_id',
        // 'user_name',
        'type',
        'description',
        'status',
        'cost',
        'promise_date',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->app_name = strtoupper($_ENV['APP_NAME']);
            $model->user_id = $user->id;
            $model->user_name = $user->name;
        });

        self::created(function($model){
            SupportTicketLog::create([
                'ticket_id' => $model->id,
                'status' => $model->status,
            ]);
        });
    }

    public function getIdPaddyAttribute(){
        return str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function getFechaFormatAttribute(){
        return Carbon::parse($this->created_at)->format('m-d-Y');
    }

    public function getFechaCreacionAttribute(){
        $date = Carbon::parse($this->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function comments(){
        return $this->hasMany(SupportTicketComment::class, 'ticket_id');
    }

    public function logs(){
        return $this->hasMany(SupportTicketLog::class, 'ticket_id');
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
