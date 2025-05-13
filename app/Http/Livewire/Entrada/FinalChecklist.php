<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use App\Models\EntradaAvance;
use App\Models\FinalChecklist as FinalChecklistModel;
use Livewire\Component;

class FinalChecklist extends Component
{
    public Entrada $entrada;
    public $firma = false;
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

    protected $listeners = ['saveSign'];

    public function mount(Entrada $entrada)
    {
        $this->entrada = $entrada;
        // Load existing checklist data if any
        if ($this->entrada->checklist) {
            $this->checklist = array_merge($this->checklist, $this->entrada->checklist);
        }
    }

    public function areAllCheckboxesChecked()
    {
        foreach ($this->checklist as $section) {
            foreach ($section as $item) {
                if (!$item) {
                    return false;
                }
            }
        }
        return true;
    }

    public function firmar()
    {
        $this->firma = true;
        if ($this->firma) {
            $this->emit('init-canvas');
        }
    }

    public function guardarFirma()
    {
        $this->emit('guardar-firma');
    }

    public function saveSign($image)
    {

        if (!$this->areAllCheckboxesChecked()) {
            $this->emit('error', 'Todos los elementos del checklist deben estar marcados para continuar');
            return;
        }

        $checklist = FinalChecklistModel::updateOrCreate(
            ['entrada_id' => $this->entrada->id],
            [
                'user_id' => auth()->id(),
                'fecha_revision' => now(),
                'firma' => $image
            ]
        );

        if($checklist){
            EntradaAvance::updateOrCreate(
                ['entrada_id' => $this->entrada->id],
                [
                    'terminado' => now()
                ]
            );
        }
        
        $this->emit('ok', 'Checklist guardado correctamente');
        $this->redirect('/servicios');
    }

    public function render()
    {
        return view('livewire.entrada.final-checklist.view');
    }
} 