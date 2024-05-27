<?php


namespace App\Http\Traits\Common;


trait CancelableModelTrait {
    
    public static function allActive() {
        return Parent::all()->where('canceled_at', null);
    }

}