<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NumeroTelefono extends Model
{
    use HasFactory;

    protected $table = 'numero_telefonos';
    protected $connection = "mysql";

    protected $fillable = [
        'model_id',
        'model_type',
        'tipo',
        'numero',
        'extension',
    ];

    protected $attributes = [
        'tipo' => 'CELULAR'
    ];

    public function model(){
        return $this->morphTo();
    }

    public function getExtFormatAttribute(){
        if($this->extension){
            return $this->extension;
        }
        return "N/A";
    }
}
