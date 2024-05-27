<?php

namespace App\Http\Livewire\Entrada;

use App\Models\Entrada;
use Livewire\Component;

class EditAreaTrabajo extends Component
{
    public $areas = [];
    public Entrada $entrada;

    protected $rules = [
        'areas' => 'array|required',
    ];

    public function mount(Entrada $entrada){
        $this->entrada = $entrada;
        $this->areas = json_decode($this->entrada->area_trabajo);
        // dd($this->areas);
    }

    public function render()
    {
        return view('livewire.entrada.edit-area-trabajo.view');
    }

    public function selectPart($value){
        if(in_array($value, $this->areas)){
            $this->areas = array_diff($this->areas, array($value));
        }else{
            array_push($this->areas, $value);
        }
    }

    public function save(){
        $res = $this->entrada->update([
            'area_trabajo' => array_values($this->areas),
        ]);

        if($res){
            $this->emit('ok', 'Se han guardado datos');
            return redirect()->to("/servicios/{$this->entrada->id}/");
        }
    }

    public function back(){
        // return back()->withInput();
        return redirect()->to("/servicios/{$this->entrada->id}/");
    }
}
