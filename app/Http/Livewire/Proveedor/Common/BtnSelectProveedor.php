<?php

namespace App\Http\Livewire\Proveedor\Common;

use App\Models\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;

class BtnSelectProveedor extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $keyWord;

    public function updating(){
        $this->resetPage('pageProviders');
    }

    public function render()
    {
        return view('livewire.proveedor.common.btn-select-proveedor', [
            'proveedores' => Proveedor::orderBy('nombre')
            ->where('canceled_at', null)
            ->where(function($q){
                $q->where('id', $this->keyWord);
                $q->orWhere('nombre', 'like', "%{$this->keyWord}%");
            })
            ->paginate(30, ['*'], 'pageProviders'),
        ]);
    }
}
