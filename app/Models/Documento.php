<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends BaseModel
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'tipo'];
}
