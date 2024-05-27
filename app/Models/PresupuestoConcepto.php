<?php

namespace App\Models;

use App\Models\shared\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PresupuestoConcepto extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'presupuesto_id',
        'presupuesto_categoria_id',
        'user_id',
        'descripcion',
        'cantidad',
        'mano_de_obra',
        'contratistas',
        'unidad_medida',
    ];

    protected $attributes = [
        'descripcion' => '[DESCRIPCION DE CONCEPTO]',
        'mano_de_obra' => 0,
        'contratistas' => 0,
        'cantidad' => 1,
        'unidad_medida' => 'PZ',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria(){
        return $this->belongsTo(PresupuestoCategoria::class, 'presupuesto_categoria_id');
    }

    public function presupuesto(){
        return $this->belongsTo(Presupuesto::class);
    }

    public function materiales(){
        return $this->hasMany(PresupuestoMaterial::class);
    }

    public function getMaterialesPuAttribute(){
        return $this->materiales->sum('importe');
    }

    public function getImporteManoObraAttribute(){
        return floatval($this->mano_de_obra) * floatval($this->cantidad);
    }

    public function getImporteContratistasAttribute(){
        return floatval($this->contratistas) * floatval($this->cantidad);
    }

    public function getImporteMaterialesAttribute(){
        return floatval($this->materiales_pu) * floatval($this->cantidad);
    }

    public function getPrecioUnitarioBrutoAttribute(){
        return $this->mano_de_obra
        + $this->contratistas
        + $this->materiales_pu;
    }

    public function getImporteBrutoAttribute(){
        return $this->precio_unitario_bruto * floatval($this->cantidad);
    }

    public function getFactorPrestacionesAttribute(){
        return floatval($this->presupuesto->prestaciones / 100);
    }

    public function getFactorSupervisionAttribute(){
        return floatval($this->presupuesto->supervision / 100);
    }

    public function getFactorIndirectosAttribute(){
        return floatval($this->presupuesto->indirectos / 100);
    }

    public function getManoObraPrestAttribute(){
        return floatval($this->mano_de_obra) * (1 + $this->factor_prestaciones);
    }

    public function getSupervisionUnitAttribute(){
        $total = $this->mano_obra_prest;
        $total += $this->materiales_pu;
        $total += $this->contratistas;
        return $total * $this->factor_supervision;
    }
    
    public function getPrestacionesUnitAttribute(){
        $total = $this->mano_de_obra;
        $total += $this->supervision_unit;
        return $total * $this->factor_prestaciones;
    }

    public function getCostoDirectoAttribute(){
        $total = $this->mano_de_obra;
        $total += $this->materiales_pu;
        $total += $this->contratistas;
        $total += $this->supervision_unit;
        $total += $this->prestaciones_unit;
        return $total;
    }

    public function getIndirectosUnitAttribute(){
        return $this->costo_directo * $this->factor_indirectos;
    }

    public function getPrecioUnitarioAttribute(){
        return $this->costo_directo + $this->indirectos_unit;
    }

    public function getPrecioUnitarioCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return $this->precio_unitario / $this->presupuesto->tipo_cambio;
        }
        return $this->precio_unitario;
    }

    public function getImporteSupervisionAttribute(){
        return $this->supervision_unit * floatval($this->cantidad);
    }

    public function getImportePrestacionesAttribute(){
        return $this->prestaciones_unit * floatval($this->cantidad);
    }

    public function getImporteCostoDirectoAttribute(){
        return $this->costo_directo * floatval($this->cantidad);
    }

    public function getImporteIndirectosAttribute(){
        return $this->indirectos_unit * floatval($this->cantidad);
    }

    public function getTotalAttribute(){
        return floatval($this->precio_unitario) * floatval($this->cantidad);
    }

    public function getTotalCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->total / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->total;
    }

    //
    public function getManoDeObraCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->mano_de_obra / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->mano_de_obra;
    }

    public function getContratistasCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->contratistas / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->contratistas;
    }

    public function getMaterialesPuCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->materiales_pu / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->materiales_pu;
    }

    public function getSupervisionUnitCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->supervision_unit / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->supervision_unit;
    }

    public function getPrestacionesUnitCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->prestaciones_unit / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->prestaciones_unit;
    }

    public function getCostoDirectoCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->costo_directo / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->costo_directo;
    }

    public function getIndirectosUnitCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->indirectos_unit / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->indirectos_unit;
    }

    public function getImporteManoObraCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_mano_obra / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_mano_obra;
    }

    public function getImporteContratistasCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_contratistas / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_contratistas;
    }

    public function getImporteMaterialesCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_materiales / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_materiales;
    }

    public function getImporteSupervisionCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_supervision / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_supervision;
    }

    public function getImportePrestacionesCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_prestaciones / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_prestaciones;
    }

    public function getImporteCostoDirectoCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_costo_directo / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_costo_directo;
    }

    public function getImporteIndirectosCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_indirectos / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_indirectos;
    }

    public function getImporteBrutoCurrencyAttribute(){
        if($this->presupuesto->moneda != 'MXN'){
            return round($this->importe_bruto / $this->presupuesto->tipo_cambio, 2);
        }
        return $this->importe_bruto;
    }

}
