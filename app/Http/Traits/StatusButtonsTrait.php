<?php


namespace App\Http\Traits;

use App\Models\Entrada;
use Illuminate\Support\Facades\DB;

trait StatusButtonsTrait {

    public $tipo_fecha;
    public $fecha;
    public $entrada;

    public function getFechaTituloProperty()
    {
        if ($this->tipo_fecha == 'fecha_entrega') {
            return 'Fecha de entrega';
        }
        else if ($this->tipo_fecha == 'fecha_pago') {
            return 'Fecha de pago';
        }
        else if ($this->tipo_fecha == 'fecha_pago_refacciones') {
            return 'Fecha pago de refacciones';
        }
    }

    public function pagarRefacciones($id){
        $this->entrada = Entrada::find($id);
        $this->entrada->update([
            'fecha_pago_refacciones' => DB::raw('now()'),
        ]);
        $this->entrada->refresh();
        $this->emit('ok', 'Se han pagado refacciones');
    }

    public function editFechaPagoRefacciones($id)
    {
        $this->entrada = Entrada::find($id);
        $this->tipo_fecha = 'fecha_pago_refacciones';
        $this->fecha = $this->entrada->fecha_pago_refacciones;
        $this->emit('showModal', '#mdlEditDate');
    }

    public function entregarVehiculo($id)
    {
        $this->entrada = Entrada::find($id);
        $this->entrada->update([
            'fecha_entrega' => DB::raw('now()'),
        ]);
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha entregado vehículo');
    }

    public function editFechaEntrega($id)
    {
        $this->entrada = Entrada::find($id);
        $this->tipo_fecha = 'fecha_entrega';
        $this->fecha = $this->entrada->fecha_entrega;
        $this->emit('showModal', '#mdlEditDate');
    }

    public function pagarEntrada($id)
    {
        $this->entrada = Entrada::find($id);
        $this->entrada->update([
            'fecha_pago' => DB::raw('now()'),
        ]);
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha pagado entrada');
    }

    public function editFechaPago()
    {
        $this->tipo_fecha = 'fecha_pago';
        $this->fecha = $this->entrada->fecha_pago;
        $this->emit('showModal', '#mdlEditDate');
    }

    public function removeDate()
    {
        $this->entrada->update([
            $this->tipo_fecha => null,
        ]);
        $this->emit('closeModal', '#mdlEditDate');
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha eliminado fecha');
    }

    public function saveDate()
    {
        $this->validate([
            'fecha' => 'date|required',
        ]);

        $this->entrada->update([
            $this->tipo_fecha => $this->fecha,
        ]);
        $this->emit('closeModal', '#mdlEditDate');
        $this->entrada->refresh();
        $this->emit('ok', 'Se ha actualizado fecha');
    }


}