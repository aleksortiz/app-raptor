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
        'entrada_id',
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

        PedidoConcepto::where('id', $this->id)->update([
            'precio' => $precio,
        ]);        

        $this->cantidad_recibida += $cantidad;
        $this->save();

        $material = $this->material;
        $entrada_id = $this->entrada_id;

        if($material){
            $material->existencia += $cantidad;
            $material->precio = $precio;
            $material->save();
        }

        if($entrada_id){
            EntradaMaterial::create([
                'entrada_id' => $entrada_id,
                'material_id' => $this->material_id,
                'numero_parte' => $this->codigo,
                'material' => $this->descripcion,
                'unidad_medida' => 'N/A',
                'cantidad' => $cantidad,
                'precio' => $precio,
                'pedido_concepto_id' => $this->id,
            ]);
        }

    }
}
