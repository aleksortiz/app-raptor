<?php

namespace App\Http\Livewire\Entrada;

use App\Models\CitaReparacion;
use App\Models\Entrada;
use App\Models\EntradaInventario;
use App\Models\Fabricante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Valuacion;

class CapturarEntradaInventarioWizard extends Component
{
    public $cita;
    public $folioCita;
    public $entradaId;
    public $entrada;
    public $cliente;
    public $vehiculo;

    // Información General (Step 1)
    public $year;
    public $kilometros;
    public $color;
    public $placas;
    public $gasolina = 0;

    // Inventario (Step 3)
    public $estereo;
    public $tapetes;
    public $parabrisas;
    public $gato;
    public $extra;
    public $herramientas;
    public $cables;
    public $ac;

    // Testigos (Step 4)
    public $abs = false;
    public $check_engine = false;
    public $antiderrapante = false;
    public $brake = false;
    public $bolsas = false;
    public $stability_track = false;

    // Carrocería (Step 5)
    public $puertas = false, $puertas_1 = false, $puertas_2 = false, $puertas_3 = false, $puertas_4 = false, $puertas_5 = false;
    public $costados = false, $costados_izquierdo = false, $costados_derecho = false;
    public $piso_cajuela = false;
    public $tolva_escape = false;
    public $capacete = false;
    public $cofre = false;
    public $rep_granizo = false;
    public $pintura_general = false;
    public $fender = false, $fender_izquierdo = false, $fender_derecho = false;
    public $facia = false, $facia_delantera = false, $facia_trasera = false;
    public $carroceria_otro = false, $carroceria_otro_text;

    // Mecánica (Step 5)
    public $afinacion_mayor = false;
    public $cambio_aceite = false;
    public $falla_mecanica = false, $falla_mecanica_text;
    public $frenos = false;
    public $suspension = false, $suspension_text;
    public $mecanica_otro = false, $mecanica_otro_text;

    // Notas finales (Step 6)
    public $notas;

    protected $queryString = [
        'folioCita',
        'entradaId'
    ];

    /**
     * Validaciones optimizadas por pasos
     * Solo se ejecutan cuando es necesario
     */
    protected $rules = [
        // Step 1 - Información General
        'year' => 'nullable|numeric|digits:4|min:1900|max:2030',
        'kilometros' => 'nullable|numeric|min:0',
        'color' => 'required|string|max:255',
        'placas' => 'nullable|string|max:20',
        'gasolina' => 'required|numeric|min:0|max:100',

        // Step 3 - Inventario
        'estereo' => 'required|string|in:FUNCIONAL,NO TIENE,NO FUNCIONA',
        'tapetes' => 'required|string|in:COMPLETOS,INCOMPLETOS,SIN TAPETES',
        'parabrisas' => 'required|string|in:SIN DETALLES,TIENE DETALLE',
        'gato' => 'required|string|in:TIENE,NO TIENE',
        'extra' => 'required|string|in:TIENE,NO TIENE',
        'herramientas' => 'required|string|in:TIENE,NO TIENE',
        'cables' => 'required|string|in:TIENE,NO TIENE',
        'ac' => 'required|string|in:FUNCIONAL,SIN GAS,NO FUNCIONA',

        // Step 5 - Campos condicionales
        'carroceria_otro_text' => 'required_if:carroceria_otro,true|nullable|string|max:500',
        'falla_mecanica_text' => 'required_if:falla_mecanica,true|nullable|string|max:500',
        'suspension_text' => 'required_if:suspension,true|nullable|string|max:500',
        'mecanica_otro_text' => 'required_if:mecanica_otro,true|nullable|string|max:500',

        // Step 6 - Notas
        'notas' => 'nullable|string|max:2000',
    ];

    protected $messages = [
        'color.required' => 'El color del vehículo es requerido',
        'gasolina.required' => 'Debe especificar el nivel de gasolina',
        'gasolina.min' => 'El nivel de gasolina debe ser al menos 0%',
        'gasolina.max' => 'El nivel de gasolina no puede ser mayor a 100%',
        'year.min' => 'El año debe ser mayor a 1900',
        'year.max' => 'El año no puede ser mayor al año actual',
        'estereo.required' => 'Debe seleccionar el estado del estéreo',
        'tapetes.required' => 'Debe seleccionar el estado de los tapetes',
        'parabrisas.required' => 'Debe seleccionar el estado del parabrisas',
        'gato.required' => 'Debe especificar si tiene gato',
        'extra.required' => 'Debe especificar si tiene extras',
        'herramientas.required' => 'Debe especificar si tiene herramientas',
        'cables.required' => 'Debe especificar si tiene cables',
        'ac.required' => 'Debe seleccionar el estado del aire acondicionado',
        'carroceria_otro_text.required_if' => 'Debe especificar qué otro problema de carrocería',
        'falla_mecanica_text.required_if' => 'Debe especificar qué falla mecánica',
        'suspension_text.required_if' => 'Debe especificar qué problema de suspensión',
        'mecanica_otro_text.required_if' => 'Debe especificar qué otro problema mecánico',
    ];

    protected $listeners = [
        'setGas',
        'createInventario',
    ];

    public function mount()
    {
        $this->initializeData();
    }

    private function initializeData()
    {
        $this->entrada = Entrada::find($this->entradaId);
        
        if ($this->entrada) {
            $this->setupFromEntrada();
            return;
        }

        $this->setupFromCita();
    }

    private function setupFromEntrada()
    {
        $this->cita = new CitaReparacion([
            'cliente_id' => $this->entrada->cliente_id,
            'marca' => $this->entrada->marca,
            'modelo' => $this->entrada->modelo,
            'no_reporte' => $this->entrada->orden,
            'cita' => now(),
        ]);
        
        $this->cliente = $this->entrada->cliente;
        $this->vehiculo = $this->entrada->vehiculo;
        $this->year = $this->entrada->year;
        $this->color = $this->entrada->color;
    }

    private function setupFromCita()
    {
        $this->entradaId = null;
        $this->entrada = null;

        $this->cita = CitaReparacion::find($this->folioCita);
        
        if (!$this->cita || $this->cita->inventario_id) {
            abort(404, 'Cita no encontrada o ya tiene inventario');
        }

        $this->cliente = $this->cita->cliente;
        $this->vehiculo = $this->cita->vehiculo;
        $this->year = $this->cita->valuacion->year ?? null;
        $this->color = $this->cita->valuacion->color ?? '';
    }

    public function render()
    {
        return view('livewire.entrada.capturar-entrada-inventario.wizard-view', $this->getRenderData())
            ->extends('layouts.public')
            ->section('content');
    }

    public function getRenderData()
    {
        return [
            'fabricantes' => Fabricante::orderBy('nombre')->get(),
        ];
    }

    /**
     * Actualizar nivel de gasolina desde el slider
     */
    public function setGas($gasolina)
    {
        $this->gasolina = (int) $gasolina;
    }

    /**
     * Validación optimizada por pasos
     * Solo valida los campos del paso específico
     */
    public function validateStep($step)
    {
        switch ($step) {
            case 1:
                return $this->validateStepFields([
                    'year', 'kilometros', 'color', 'placas', 'gasolina'
                ]);
            case 3:
                return $this->validateStepFields([
                    'estereo', 'tapetes', 'parabrisas', 'gato', 
                    'extra', 'herramientas', 'cables', 'ac'
                ]);
            case 5:
                return $this->validateStepFields([
                    'carroceria_otro_text', 'falla_mecanica_text', 
                    'suspension_text', 'mecanica_otro_text'
                ]);
            case 6:
                return $this->validateStepFields(['notas']);
            default:
                return true; // Steps 2 y 4 no requieren validación
        }
    }

    private function validateStepFields($fields)
    {
        $rules = array_intersect_key($this->rules, array_flip($fields));
        $messages = array_intersect_key($this->messages, array_flip($fields));
        
        try {
            $this->validate($rules, $messages);
            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }
    }

    /**
     * Crear inventario con datos optimizados
     */
    public function createInventario($diagramaB64 = null)
    {
        // Validación final completa
        $this->validate();

        try {
            \DB::beginTransaction();

            $inventario = $this->createInventarioRecord($diagramaB64);
            $this->updateCita($inventario);
            $this->createOrUpdateEntrada();
            $this->linkInventarioToEntrada($inventario);

            \DB::commit();

            $this->emit('ok', 'Inventario registrado exitosamente');
            return redirect()->to("/inventarios/{$inventario->id}/tomar-fotos");

        } catch (\Exception $e) {
            \DB::rollback();
            $this->emit('error', 'Error al guardar el inventario: ' . $e->getMessage());
        }
    }

    private function createInventarioRecord($diagramaB64)
    {
        return EntradaInventario::create([
            'user_id' => Auth::id(),
            'cliente' => $this->cliente->nombre,
            'telefono' => $this->cliente->telefono,
            'marca' => $this->cita->marca,
            'modelo' => $this->cita->modelo,
            'year' => $this->year,
            'kilometros' => $this->kilometros,
            'color' => trim(strtoupper($this->color)),
            'placas' => trim(strtoupper($this->placas)),
            'notas' => $this->notas,
            'gasolina' => $this->gasolina,
            'inventario' => json_encode($this->getInventarioData()),
            'testigos' => json_encode($this->getTestigosData()),
            'carroceria' => json_encode($this->getCarroceriaData()),
            'mecanica' => json_encode($this->getMecanicaData()),
            'diagrama' => $diagramaB64,
        ]);
    }

    private function getInventarioData()
    {
        return [
            'estereo' => $this->estereo,
            'tapetes' => $this->tapetes,
            'parabrisas' => $this->parabrisas,
            'gato' => $this->gato,
            'extra' => $this->extra,
            'herramientas' => $this->herramientas,
            'cables' => $this->cables,
            'ac' => $this->ac,
        ];
    }

    private function getTestigosData()
    {
        return [
            'abs' => $this->abs,
            'check_engine' => $this->check_engine,
            'antiderrapante' => $this->antiderrapante,
            'brake' => $this->brake,
            'bolsas' => $this->bolsas,
            'stability_track' => $this->stability_track,
        ];
    }

    private function getCarroceriaData()
    {
        return [
            'puertas' => [
                'puertas_1' => $this->puertas_1,
                'puertas_2' => $this->puertas_2,
                'puertas_3' => $this->puertas_3,
                'puertas_4' => $this->puertas_4,
                'puertas_5' => $this->puertas_5,
            ],
            'costados' => [
                'costados_izquierdo' => $this->costados_izquierdo,
                'costados_derecho' => $this->costados_derecho,
            ],
            'piso_cajuela' => $this->piso_cajuela,
            'tolva_escape' => $this->tolva_escape,
            'capacete' => $this->capacete,
            'cofre' => $this->cofre,
            'rep_granizo' => $this->rep_granizo,
            'pintura_general' => $this->pintura_general,
            'fender' => [
                'fender_izquierdo' => $this->fender_izquierdo,
                'fender_derecho' => $this->fender_derecho,
            ],
            'facia' => [
                'facia_delantera' => $this->facia_delantera,
                'facia_trasera' => $this->facia_trasera,
            ],
            'carroceria_otro' => $this->carroceria_otro,
            'carroceria_otro_text' => $this->carroceria_otro_text,
        ];
    }

    private function getMecanicaData()
    {
        return [
            'afinacion_mayor' => $this->afinacion_mayor,
            'cambio_aceite' => $this->cambio_aceite,
            'falla_mecanica' => $this->falla_mecanica,
            'falla_mecanica_text' => $this->falla_mecanica_text,
            'frenos' => $this->frenos,
            'suspension' => $this->suspension,
            'suspension_text' => $this->suspension_text,
            'mecanica_otro' => $this->mecanica_otro,
            'mecanica_otro_text' => $this->mecanica_otro_text,
        ];
    }

    private function updateCita($inventario)
    {
        $this->cita->inventario_id = $inventario->id;
        if ($this->entrada) {
            $this->cita->cliente_id = $this->cliente->id;
        }
        $this->cita->save();
    }

    private function createOrUpdateEntrada()
    {
        if (!$this->entrada) {
            $this->entrada = Entrada::create([
                'user_id' => Auth::id(),
                'sucursal_id' => 1,
                'aseguradora_id' => 1,
                'fabricante_id' => 1,
                'marca' => $this->cita->marca,
                'cliente_id' => $this->cita->cliente_id,
                'origen' => 'ASEGURADORA',
                'modelo' => $this->cita->modelo,
                'orden' => $this->cita->no_reporte,
                'rfc' => $this->cita->cliente->rfc,
                'razon_social' => $this->cita->cliente->razon_social,
                'domicilio_fiscal' => $this->cita->cliente->codigo_postal,
            ]);

            $this->transferValuacionDocuments();
        }
    }

    private function transferValuacionDocuments()
    {
        if ($this->cita->valuacion_id) {
            $valuacion = Valuacion::find($this->cita->valuacion_id);
            if ($valuacion) {
                $valuacion->entrada_id = $this->entrada->id;
                $valuacion->save();

                foreach ($valuacion->documentos as $documento) {
                    $documento->model_id = $this->entrada->id;
                    $documento->model_type = Entrada::class;
                    $documento->save();
                }
            }
        }
    }

    private function linkInventarioToEntrada($inventario)
    {
        $inventario->entrada_id = $this->entrada->id;
        $inventario->save();
    }

    /**
     * Obtener progreso del wizard basado en campos completados
     */
    public function getProgressPercentage()
    {
        $totalFields = 0;
        $completedFields = 0;

        // Step 1 fields
        $step1Fields = ['year', 'kilometros', 'color', 'placas', 'gasolina'];
        foreach ($step1Fields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Step 3 fields  
        $step3Fields = ['estereo', 'tapetes', 'parabrisas', 'gato', 'extra', 'herramientas', 'cables', 'ac'];
        foreach ($step3Fields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        return $totalFields > 0 ? round(($completedFields / $totalFields) * 100) : 0;
    }
}
