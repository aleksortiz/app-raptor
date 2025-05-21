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
    public $masterAcceptance = false;
    public $checklist = [
        'revision_general' => [
            'piezas_alineadas' => [
                'checked' => false,
                'text' => 'Todas las piezas están bien alineadas (cofres, puertas, fascias, etc.)'
            ],
            'lineas_ensamble' => [
                'checked' => false,
                'text' => 'Las líneas de ensamble son uniformes'
            ],
            'sin_abolladuras' => [
                'checked' => false,
                'text' => 'No hay abolladuras visibles'
            ],
            'sin_rayones' => [
                'checked' => false,
                'text' => 'No hay rayones ni imperfecciones en superficies reparadas'
            ],
            'sin_residuos' => [
                'checked' => false,
                'text' => 'No hay restos de polvo o residuos de lijado o pintura'
            ],
        ],
        'revision_pintura' => [
            'color_coincide' => [
                'checked' => false,
                'text' => 'El color coincide con el resto del vehículo'
            ],
            'sin_diferencias_tono' => [
                'checked' => false,
                'text' => 'No hay diferencia de tono entre partes reparadas y originales'
            ],
            'sin_escurrimientos' => [
                'checked' => false,
                'text' => 'No hay escurrimientos, burbujas o piel de naranja'
            ],
            'sin_exceso_pintura' => [
                'checked' => false,
                'text' => 'No hay exceso de pintura en molduras, empaques o cristales'
            ],
            'barniz_correcto' => [
                'checked' => false,
                'text' => 'Se aplicó barniz correctamente'
            ],
        ],
        'limpieza' => [
            'vehiculo_lavado' => [
                'checked' => false,
                'text' => 'Vehículo lavado completamente'
            ],
            'sin_residuos' => [
                'checked' => false,
                'text' => 'Se eliminaron residuos de masilla, polish o compuestos de pulido'
            ],
        ],
        'sistema_electrico' => [
            'luces_altas_bajas' => [
                'checked' => false,
                'text' => 'Luces altas y bajas funcionando correctamente'
            ],
            'direccionales' => [
                'checked' => false,
                'text' => 'Direccionales delanteras y traseras funcionando'
            ],
            'luces_freno_reversa' => [
                'checked' => false,
                'text' => 'Luces de freno y de reversa funcionando'
            ],
            'claxon' => [
                'checked' => false,
                'text' => 'Claxon en funcionamiento'
            ],
            'limpiaparabrisas' => [
                'checked' => false,
                'text' => 'Limpiaparabrisas (wipers) funcionando correctamente'
            ],
            'elevadores_seguros' => [
                'checked' => false,
                'text' => 'Elevadores eléctricos y seguros de puertas operan bien'
            ],
            'aire_radio' => [
                'checked' => false,
                'text' => 'Aire acondicionado y radio funcionando correctamente'
            ],
        ],
        'testigos' => [
            'abs' => [
                'checked' => false,
                'text' => 'ABS apagado'
            ],
            'check_engine' => [
                'checked' => false,
                'text' => 'CHECK ENGINE apagado'
            ],
            'antiderrapante' => [
                'checked' => false,
                'text' => 'ANTIDERRAPANTE apagado'
            ],
            'brake' => [
                'checked' => false,
                'text' => 'BRAKE apagado'
            ],
            'bolsas' => [
                'checked' => false,
                'text' => 'AIRBAGS apagado'
            ],
            'stability_track' => [
                'checked' => false,
                'text' => 'STABILITY TRACK apagado'
            ],
        ]
    ];

    public $comments = [];
    public $showCommentModal = false;
    public $currentCommentSection = '';
    public $currentCommentItem = '';
    public $currentCommentText = '';

    protected $listeners = ['saveSign', 'openCommentModal', 'saveComment', 'confirmMasterAcceptance'];

    public function mount(Entrada $entrada)
    {
        $this->entrada = $entrada;
        // Load existing checklist data if any
        if ($this->entrada->checklist) {
            $savedChecklist = $this->entrada->checklist;
            foreach ($savedChecklist as $section => $items) {
                foreach ($items as $item => $data) {
                    if (isset($this->checklist[$section][$item])) {
                        $this->checklist[$section][$item]['checked'] = $data['checked'];
                    }
                }
            }
        }
        // Initialize comments array
        foreach ($this->checklist as $section => $items) {
            foreach ($items as $item => $data) {
                $this->comments[$section][$item] = '';
            }
        }
        // Load existing comments if any
        if ($this->entrada->checklist_comments) {
            $this->comments = array_merge($this->comments, $this->entrada->checklist_comments);
        }
    }

    public function openCommentModal($section, $item)
    {
        if (!$this->checklist[$section][$item]['checked']) {
            $this->emit('error', 'El punto debe estar marcado para agregar un comentario');
            return;
        }
        $this->currentCommentSection = $section;
        $this->currentCommentItem = $item;
        $this->currentCommentText = $this->comments[$section][$item] ?? '';
        $this->showCommentModal = true;
    }

    public function saveComment()
    {
        $this->comments[$this->currentCommentSection][$this->currentCommentItem] = $this->currentCommentText;
        $this->showCommentModal = false;
        $this->currentCommentText = '';
    }

    public function hasComment($section, $item)
    {
        return !empty($this->comments[$section][$item]);
    }

    public function toggleMasterAcceptance()
    {
        if (!$this->masterAcceptance) {
            $this->emit('confirm', 
                'Al marcar esta opción, usted confirma que ha realizado una revisión exhaustiva del vehículo y que todos los puntos del checklist han sido verificados y cumplen con los estándares de calidad requeridos. ¿Desea continuar?',
                'Confirmación de Revisión Completa',
                'confirmMasterAcceptance'
            );
        } else {
            $this->masterAcceptance = false;
            foreach ($this->checklist as $section => $items) {
                foreach ($items as $item => $data) {
                    $this->checklist[$section][$item]['checked'] = false;
                }
            }
        }
    }

    public function confirmMasterAcceptance()
    {
        $this->masterAcceptance = true;
        foreach ($this->checklist as $section => $items) {
            foreach ($items as $item => $data) {
                $this->checklist[$section][$item]['checked'] = true;
            }
        }
    }

    public function areAllCheckboxesChecked()
    {
        if ($this->masterAcceptance) {
            return true;
        }
        foreach ($this->checklist as $section) {
            foreach ($section as $item) {
                if (!$item['checked']) {
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
                'firma' => $image,
                'checklist' => $this->checklist,
                'checklist_comments' => $this->comments
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