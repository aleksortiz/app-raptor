<div class="card">
  <div class="card-header">
    <h3 class="card-title font-weight-bold"><i class="fas fa-user"></i> Material para: </h3>
    <div class="card-tools">
      @if($this->personal?->id)
        <button class="btn btn-xs btn-danger" wire:click="setPersonal(0)"><i class="fas fa-minus"></i> <i class="fas fa-user"></i> Remover Personal</button>
      @else
        <button class="btn btn-xs btn-primary" wire:click="$emit('showModal', '#mdlSelectPersonal')"><i class="fas fa-plus"></i><i class="fas fa-user"></i> Selecc. Personal</button>
      @endif
    </div>
  </div>


  <div class="card-body p-3">
    @if(isset($this->personal->id))
      <center>
        <h4>{{$this->personal->nombre}}</h4>
      </center>
    @else
      <center>
        <h4>Seleccione Personal</h4>
      </center>
    @endif

  </div>
</div>
