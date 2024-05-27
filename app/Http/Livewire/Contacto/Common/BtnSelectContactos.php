<?php

namespace App\Http\Livewire\Contacto\Common;

use App\Models\Contacto;
use App\Models\ContactoModel;
use Livewire\Component;

class BtnSelectContactos extends Component
{
    public $searchValueContactos;
    public $provider;
    public $model;
    public $selectedContactos;

    protected $rules = [
        'selectedContactos.*.selected'
    ];

    public function mount($provider, $model){
        $this->provider = $provider;
        $this->model = $model;

        foreach($this->model->contactos as $item) {
            $this->selectedContactos[$item->id]['selected'] = true;
        }
    }

    public function render()
    {
        return view('livewire.contacto.common.btn-select-contactos',[
            'contactos' => Contacto::orderBy('nombre')
            ->where(function($query){
                $query->where('model_type', get_class($this->provider));
                $query->where('model_id', $this->provider->id);
            })
            ->where(function($query){
                $query->orWhere('nombre', 'like', "%{$this->searchValueContactos}%");
                $query->orWhere('correo', 'like', "%{$this->searchValueContactos}%");
            })->get(),
        ]);
    }

    public function saveContactos(){
        foreach ($this->selectedContactos as $key => $value) {
            if($value['selected'] == false){
                ContactoModel::where([
                    'contacto_id' => $key,
                    'model_id' => $this->model->id,
                    'model_type' => get_class($this->model),
                ])->delete();
            }
        }

        $contactos = ContactoModel::where('model_id', $this->model->id)
        ->where('model_type', get_class($this->model))->orderBy('orden')->get();

        foreach ($contactos as $index => $contacto) {
            $contacto->orden = $index + 1;
            $contacto->save();
        }

        foreach ($this->selectedContactos as $key => $value) {
            if($value['selected'] == true){
                ContactoModel::updateOrCreate([
                    'contacto_id' => $key,
                    'model_id' => $this->model->id,
                    'model_type' => get_class($this->model),
                ]);
            }
        }

        
        $this->emit('ok', 'Se han guardado contactos');
        $this->emit('loadContactos');

    }
}
