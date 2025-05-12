<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use Livewire\Component;

class FinalChecklist extends Component
{
    public Entrada $entrada;
    public $checklist = [
        'revision_general' => [
            'piezas_alineadas' => false,
            'lineas_ensamble' => false,
            'sin_abolladuras' => false,
            'sin_rayones' => false,
            'sin_residuos' => false,
        ],
        'revision_pintura' => [
            'color_coincide' => false,
            'sin_diferencias_tono' => false,
            'sin_escurrimientos' => false,
            'sin_exceso_pintura' => false,
            'barniz_correcto' => false,
        ],
        'limpieza' => [
            'vehiculo_lavado' => false,
            'sin_residuos' => false,
        ],
        'sistema_electrico' => [
            'luces_altas_bajas' => false,
            'direccionales' => false,
            'luces_freno_reversa' => false,
            'claxon' => false,
            'limpiaparabrisas' => false,
            'elevadores_seguros' => false,
            'aire_radio' => false,
        ]
    ];

    public function mount(Entrada $entrada)
    {
        $this->entrada = $entrada;
        // Load existing checklist data if any
        if ($this->entrada->checklist) {
            $this->checklist = array_merge($this->checklist, $this->entrada->checklist);
        }
    }

    public function saveChecklist()
    {
        // $this->entrada->update([
        //     'checklist' => $this->checklist
        // ]);

        $this->emit('ok', 'Checklist guardado correctamente');
    }

    public function render()
    {
        return view('livewire.entrada.final-checklist.view');
    }
} 