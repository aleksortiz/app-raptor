<div wire:ignore.self class="modal fade" data-backdrop="static" id="{{$this->mdlName}}">
    <div class="modal-dialog modal-dialog-scrollable modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Subir fotos desde el celular</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @php
                    $valor = QrCode::size(300)->generate($this->qrString);
                @endphp
                <center>
                    <img src="data:image/svg+xml;base64,{{ base64_encode($valor) }}">
                </center>

                {{-- <textarea wire:model="qrString" id="qrcode" style="width: 100%; height: 100px;"></textarea> --}}
  
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>
            </div>
        </div>
    </div>
  </div>
  