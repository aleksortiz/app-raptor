<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PedidoConcepto extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedido_id',
        'material_id',
        'codigo',
        'descripcion',
        'cantidad',
        'cantidad_recibida',
        'precio',
    ];

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function material(){
        return $this->belongsTo(Material::class);
    }

    public function getImporteAttribute(){
        try{
            return $this->cantidad * $this->precio;
        }
        catch (Exception $e){
            return 0;
        }
    }

    public function getPendienteRecibirAttribute(){
        return $this->cantidad - $this->cantidad_recibida;
    }

    public function recibirProducto($cantidad, $precio){

        $material = $this->material;
        $material->existencia += $cantidad;

        PedidoConcepto::where('id', $this->id)->update([
            'precio' => $precio,
        ]);

        if($material->save()){
            
            $this->cantidad_recibida += $cantidad;
            $this->save();
        }
    }
}
