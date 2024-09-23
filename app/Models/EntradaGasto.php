<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaGasto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'entrada_id',
      'concepto',
      'monto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
