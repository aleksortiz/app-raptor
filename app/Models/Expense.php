<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'vsc_expenses';

    protected $fillable = [
        'vehicle_id',
        'type',
        'amount',
        'date',
        'description',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}