<?php

namespace App\Models\shared;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function getIdPaddyAttribute(){
        return str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getFechaFormatAttribute(){
        return Carbon::parse($this->created_at)->format('m-d-Y');
    }

    public function getFechaCreacionAttribute(){
        $date = Carbon::parse($this->created_at);
        $format = 'M/d/Y h:i A';
        if ($date->year = Carbon::now()->year){
            $format = 'M/d h:i A';
        }
        return $date->format($format);
    }

    public function getFechaModificacionAttribute(){
        return Carbon::parse($this->updated_at)->format('M/d/Y h:i A');
    }

    public function SoftDelete(){
        $this->active = false;
        return $this->save();
    }
}
