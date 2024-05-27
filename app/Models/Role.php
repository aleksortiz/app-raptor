<?php
namespace App\Models;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Support\Str;

class Role extends SpatieRole
{
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->name = Str::slug(strtolower($model->name));
        });
    }

    public function getNameFormatAttribute(){
        return strtoupper(str_replace('-', ' ', $this->attributes['name']));
    }
}