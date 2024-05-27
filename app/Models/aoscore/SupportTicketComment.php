<?php

namespace App\Models\aoscore;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SupportTicketComment extends Model
{
    use HasFactory;
    
    protected $connection = 'aoscore';

    protected $fillable = [
        'ticket_id',
        'comment',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $user = Auth::user();
            $model->user_id = $user->id;
            $model->user_name = $user->name;
        });
    }

    public function getFechaCreacionAttribute(){
        $date = Carbon::parse($this->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year == Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }
}
