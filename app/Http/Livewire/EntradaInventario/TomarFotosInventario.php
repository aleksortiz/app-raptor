<?php

namespace App\Http\Livewire\EntradaInventario;

use App\Jobs\SendInventarioPdfEmail;
use App\Models\EntradaInventario;
use Livewire\Component;

class TomarFotosInventario extends Component
{

    public $entrada;
    public $inventario;

    public $firma = false;
    public $email = '';

    protected $listeners = ['saveSign'];

    protected $rules = [
        'email' => 'nullable|email',
    ];

    protected $messages = [
        'email.email' => 'Por favor ingrese un email válido.',
    ];

    public function mount(EntradaInventario $inventario){
        $this->inventario = $inventario;
        $this->entrada = $inventario->entrada;
        $this->email = $inventario->email ?? '';
    }

    public function render()
    {
        return view('livewire.entrada-inventario.tomar-fotos-inventario.view');
    }

    public function fotos(){
      $this->firma = false;
    }

    public function firmar(){
        $this->firma = true;

        if($this->firma){
            $this->emit('init-canvas');
        }
    }

    public function guardarFirma(){
      $this->emit('guardar-firma');
    }

    public function saveSign($image){
        $this->inventario->firma = $image;
        
        // Validar y guardar email si se proporcionó
        if ($this->email) {
            $this->validate();
            $this->inventario->email = $this->email;
        }
        
        $this->inventario->save();
        
        // Enviar email si se proporcionó un email válido
        if ($this->email) {
            SendInventarioPdfEmail::dispatch($this->inventario, $this->email);
            $this->emit('ok', 'Firma guardada correctamente y correo enviado a: ' . $this->email);
        } else {
            $this->emit('ok', 'Firma guardada correctamente');
        }
        
        return redirect()->to('/');
    }



}
