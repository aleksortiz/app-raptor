<?php

namespace App\Http\Livewire\Personal\Common;

use App\Models\Personal;
use Livewire\Component;
use Livewire\WithPagination;

class MdlSelectPersonal extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $mdlName = 'mdlSelectPersonal';
    public $emitAction;
    public $searchValue;

    public function updatedSearchValue(){
        $this->resetPage('selectPersonalPage');
    }

    public function mount($emitAction){
        $this->emitAction = $emitAction;
    }

    public function render()
    {
        return view('livewire.personal.common.mdl-select-personal',[
            'personal' => Personal::orderBy('nombre')
            ->orWhere('nombre', 'LIKE', "%{$this->searchValue}%")
            ->paginate(50, ['*'], 'selectPersonalPage'),
        ]);
    }

    public function select($id){
        // $this->validate();
        $this->emit('closeModal', "#{$this->mdlName}");
        $this->emitUp($this->emitAction, $id);
    }
}
