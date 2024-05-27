<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManualesController extends Controller
{
    public function manualProcesoCompras(){
        return Storage::response('manuales/proceso-compras.pdf');
    }
}
