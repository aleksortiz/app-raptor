<?php


namespace App\Http\Traits;

use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

trait VentaTrait {

    public $ventaTrait;

    public function viewRegistros($id){
        $this->ventaTrait = Venta::findOrFail($id);
        $this->emit('showModal', '#mdlSaleDetails');
    }
}