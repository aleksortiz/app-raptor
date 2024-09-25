<?php

namespace App\Models\Willys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autoparte extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand',
        'model',
        'year',
        'price',
        'provider',
    ];
}
