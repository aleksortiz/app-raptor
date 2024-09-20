<?php

namespace App\Http\Livewire\Entrada\Common;

use App\Models\Entrada;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectEntrada extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mdlName = 'mdlSelectEntrada';
    public $emitAction;
    public $keyWord;

    public function updatedKeyWord(){
        $this->resetPage('selectEntradaPage');
    }

    public function mount($emitAction){
        $this->emitAction = $emitAction;
    }

    public function render()
    {
      return view('livewire.entrada.common.mdl-select-entrada', $this->getRenderData());
    }

    public function getRenderData(){
      $entradas = Entrada::OrderBy('id','desc')
      ->where(function ($q){
          $q->orWhere('modelo', 'LIKE', "%{$this->keyWord}%")
          ->orWhereHas('fabricante', function($fab){
              $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
          })
          ->orWhereHas('cliente', function($fab){
              $fab->where('nombre', 'LIKE', "%{$this->keyWord}%");
          })
          ->orWhere('folio', 'LIKE', "{$this->keyWord}%")
          ->orWhere('serie', 'LIKE', "{$this->keyWord}%")
          ->orWhere('orden', 'LIKE', "{$this->keyWord}%")
          ->orWhere(DB::raw('REPLACE(orden, " ", "")'), 'LIKE', trim($this->keyWord).'%');
      });

      return [
          'entradas' => $entradas->paginate(50, ['*'], 'selectEntradaPage'),
      ];

    }

    public function select($id){
        // $this->validate();
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emitUp($this->emitAction, $id);
    }
}
