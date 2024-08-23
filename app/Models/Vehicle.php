<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vsc_vehicles';

    protected $fillable = [
        'brand',
        'model',
        'year',
        'serial',
        'purchase_date',
        'purchase_price',
        'sale_date',
        'sale_price',
        'status',
    ];

    public function setBrandAttribute($value){
        $this->attributes['brand'] = strtoupper($value);
    }

    public function setModelAttribute($value){
        $this->attributes['model'] = strtoupper($value);
    }

    public function setSerialAttribute($value){
        $this->attributes['serial'] = strtoupper($value);
    }

    public function getDescriptionAttribute($value){
        $desc = $this->brand . ' ' . $this->model . ' ' . $this->year;
        // return strtoupper($desc);
        return $desc;
    }

    public function getPurchasePriceFormatAttribute(){
        return '$' . number_format($this->purchase_price, 2);
    }

    public function expenses(){
        return $this->hasMany(Expense::class, 'vehicle_id');
    }

    public function getPurchaseDateFormatAttribute()
    {
        if($this->purchase_date == null){
            return "N/A";
        }
        return Carbon::parse($this->purchase_date)->format('M/d/Y h:i A');
    }

    public function getSaleDateFormatAttribute()
    {
        if($this->sale_date == null){
            return "N/A";
        }
        return Carbon::parse($this->sale_date)->format('M/d/Y h:i A');
    }

    public function getCostsAttribute(){
        return $this->expenses->sum('amount');
    }

    public function getUtilityFormatAttribute(){
        if($this->sale_price == null){
            return "N/A";
        }
        // return $this->sale_price - $this->purchase_price - $this->costs;
        return '$' . number_format($this->sale_price - $this->purchase_price - $this->costs, 2);
    }


    public function getUtilityPercentageAttribute(){
        if($this->sale_price == null){
            return "N/A";
        }
        return ($this->utility / $this->purchase_price) * 100;
    }

    public function getSalePriceFormatAttribute(){
        if($this->sale_price == null){
            return "N/A";
        }
        return '$' . number_format($this->sale_price, 2);
    }


}
