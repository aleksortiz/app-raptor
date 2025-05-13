<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'entrada_id',
        'user_id',
        'fecha_revision',
        'firma'
    ];

    protected $casts = [
        'fecha_revision' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entrada()
    {
        return $this->belongsTo(Entrada::class);
    }
}
