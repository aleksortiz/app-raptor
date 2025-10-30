<div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fa fa-video"></i> Videos
            </h5>
            <button wire:click="openModal" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Grabar/Subir Video
            </button>
        </div>
        <div class="card-body">
            @if(count($videos) > 0)
                <div class="row">
                    @foreach($videos as $video)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <video controls class="w-100 mb-2" style="max-height: 200px;">
                                        <source src="{{ $video->complete_url }}" type="{{ $video->mime_type }}">
                                        Tu navegador no soporta el tag de video.
                                    </video>
                                    <div class="video-info">
                                        <p class="mb-1"><strong>{{ $video->filename }}</strong></p>
                                        @if($video->description)
                                            <p class="text-muted small mb-1">{{ $video->description }}</p>
                                        @endif
                                        <p class="text-muted small mb-1">
                                            <i class="fa fa-clock"></i> {{ $video->formatted_duration }} | 
                                            <i class="fa fa-hdd"></i> {{ $video->formatted_size }}
                                        </p>
                                        <p class="text-muted small">
                                            {{ $video->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ $video->complete_url }}" download="{{ $video->filename }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-download"></i> Descargar
                                        </a>
                                        <button wire:click="deleteVideo({{ $video->id }})" 
                                                onclick="return confirm('¿Está seguro de eliminar este video?')"
                                                class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> No hay videos adjuntos. Haga clic en "Grabar/Subir Video" para comenzar.
                </div>
            @endif
        </div>
    </div>

    <!-- Modal para grabar/subir video -->
    @if($showModal)
        <div class="modal fade show d-block" id="videoModal" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa fa-video"></i> Grabar o Subir Video
                        </h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="record-tab" data-toggle="tab" href="#record" role="tab">
                                    <i class="fa fa-circle"></i> Grabar Video
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab">
                                    <i class="fa fa-upload"></i> Subir Video
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-3">
                            <!-- Tab para grabar video -->
                            <div class="tab-pane fade show active" id="record" role="tabpanel">
                                <div class="text-center">
                                    <video id="videoPreview" autoplay muted class="w-100 mb-3" style="max-height: 400px; background: #000;"></video>
                                    <video id="recordedVideo" controls class="w-100 mb-3 d-none" style="max-height: 400px;"></video>
                                    
                                    <div class="mb-3">
                                        <button type="button" id="startRecording" class="btn btn-success">
                                            <i class="fa fa-circle"></i> Iniciar Grabación
                                        </button>
                                        <button type="button" id="stopRecording" class="btn btn-danger d-none">
                                            <i class="fa fa-stop"></i> Detener Grabación
                                        </button>
                                        <button type="button" id="discardRecording" class="btn btn-warning d-none">
                                            <i class="fa fa-redo"></i> Reintentar
                                        </button>
                                        <span id="recordingTime" class="ml-3 d-none text-danger font-weight-bold">
                                            <i class="fa fa-circle blink"></i> 00:00
                                        </span>
                                    </div>
                                    
                                    <div id="recordingControls" class="d-none">
                                        <div class="form-group">
                                            <label>Descripción (opcional)</label>
                                            <textarea id="recordDescription" class="form-control" rows="3" placeholder="Agregar una descripción..."></textarea>
                                        </div>
                                        <button type="button" id="saveRecording" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Guardar Video
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab para subir video -->
                            <div class="tab-pane fade" id="upload" role="tabpanel">
                                <form id="uploadVideoForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Seleccionar Video</label>
                                        <input type="file" id="videoFile" class="form-control-file" accept="video/*" required>
                                        <small class="form-text text-muted">
                                            Formatos: MP4, MOV, AVI, WMV, FLV, WEBM. Tamaño máximo: 100MB
                                        </small>
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción (opcional)</label>
                                        <textarea id="uploadDescription" class="form-control" rows="3" placeholder="Agregar una descripción..."></textarea>
                                    </div>
                                    <div class="progress d-none mb-3" id="uploadProgress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                             role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-upload"></i> Subir Video
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Script inline para el modal (se ejecuta inmediatamente cuando el modal aparece)
        (function() {
            let mediaRecorder, recordedChunks = [], stream, recordingTimer, recordingSeconds = 0, recordedBlob = null;

            // Botón iniciar grabación
            const startBtn = document.getElementById('startRecording');
            if (startBtn && !startBtn.hasAttribute('data-listener')) {
                startBtn.setAttribute('data-listener', 'true');
                startBtn.addEventListener('click', async function() {
                    console.log('Iniciando grabación...');
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                        document.getElementById('videoPreview').srcObject = stream;
                        
                        mediaRecorder = new MediaRecorder(stream);
                        recordedChunks = [];
                        
                        mediaRecorder.ondataavailable = (e) => { if (e.data.size > 0) recordedChunks.push(e.data); };
                        mediaRecorder.onstop = () => {
                            recordedBlob = new Blob(recordedChunks, { type: 'video/webm' });
                            document.getElementById('recordedVideo').src = URL.createObjectURL(recordedBlob);
                            document.getElementById('recordedVideo').classList.remove('d-none');
                            document.getElementById('videoPreview').classList.add('d-none');
                            document.getElementById('recordingControls').classList.remove('d-none');
                            stream.getTracks().forEach(track => track.stop());
                        };
                        
                        mediaRecorder.start();
                        document.getElementById('startRecording').classList.add('d-none');
                        document.getElementById('stopRecording').classList.remove('d-none');
                        document.getElementById('recordingTime').classList.remove('d-none');
                        
                        recordingSeconds = 0;
                        recordingTimer = setInterval(() => {
                            recordingSeconds++;
                            const m = Math.floor(recordingSeconds / 60), s = recordingSeconds % 60;
                            document.getElementById('recordingTime').innerHTML = 
                                `<i class="fa fa-circle blink"></i> ${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                        }, 1000);
                    } catch (error) {
                        console.error('Error:', error);
                        alert('No se pudo acceder a la cámara. Verifica los permisos.');
                    }
                });
            }

            // Botón detener grabación
            const stopBtn = document.getElementById('stopRecording');
            if (stopBtn && !stopBtn.hasAttribute('data-listener')) {
                stopBtn.setAttribute('data-listener', 'true');
                stopBtn.addEventListener('click', function() {
                    if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                        mediaRecorder.stop();
                        clearInterval(recordingTimer);
                        document.getElementById('stopRecording').classList.add('d-none');
                        document.getElementById('discardRecording').classList.remove('d-none');
                        document.getElementById('recordingTime').classList.add('d-none');
                    }
                });
            }

            // Botón descartar
            const discardBtn = document.getElementById('discardRecording');
            if (discardBtn && !discardBtn.hasAttribute('data-listener')) {
                discardBtn.setAttribute('data-listener', 'true');
                discardBtn.addEventListener('click', function() {
                    recordedChunks = [];
                    recordedBlob = null;
                    document.getElementById('recordedVideo').classList.add('d-none');
                    document.getElementById('videoPreview').classList.remove('d-none');
                    document.getElementById('recordingControls').classList.add('d-none');
                    document.getElementById('discardRecording').classList.add('d-none');
                    document.getElementById('startRecording').classList.remove('d-none');
                    document.getElementById('recordDescription').value = '';
                });
            }

            // Botón guardar
            const saveBtn = document.getElementById('saveRecording');
            if (saveBtn && !saveBtn.hasAttribute('data-listener')) {
                saveBtn.setAttribute('data-listener', 'true');
                saveBtn.addEventListener('click', async function() {
                    if (!recordedBlob) return alert('No hay video grabado');
                    
                    const btn = this;
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Guardando...';
                    
                    const formData = new FormData();
                    formData.append('video', recordedBlob, 'recorded-video.webm');
                    formData.append('model_type', '{{ $modelType }}');
                    formData.append('model_id', '{{ $modelId }}');
                    formData.append('description', document.getElementById('recordDescription').value);
                    formData.append('duration', recordingSeconds);
                    
                    try {
                        console.log('Enviando video...');
                        console.log('Model Type:', '{{ $modelType }}');
                        console.log('Model ID:', '{{ $modelId }}');
                        
                        const res = await fetch('/api/videos', {
                            method: 'POST',
                            body: formData
                        });
                        
                        console.log('Response status:', res.status);
                        const data = await res.json();
                        console.log('Response data:', data);
                        
                        if (res.ok && data.success) {
                            alert('Video guardado exitosamente');
                            @this.call('loadVideos');
                            @this.call('closeModal');
                        } else {
                            const errorMsg = data.message || 'Error desconocido';
                            console.error('Error del servidor:', data);
                            alert('Error al guardar: ' + errorMsg);
                        }
                    } catch (error) {
                        console.error('Error completo:', error);
                        alert('Error al guardar el video. Revisa la consola (F12) para más detalles.');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa fa-save"></i> Guardar Video';
                    }
                });
            }

            // Form de subida
            const uploadForm = document.getElementById('uploadVideoForm');
            if (uploadForm && !uploadForm.hasAttribute('data-listener')) {
                uploadForm.setAttribute('data-listener', 'true');
                uploadForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const file = document.getElementById('videoFile').files[0];
                    if (!file) return alert('Selecciona un archivo');
                    
                    const progressBar = document.getElementById('uploadProgress');
                    const progressBarInner = progressBar.querySelector('.progress-bar');
                    progressBar.classList.remove('d-none');
                    
                    const formData = new FormData();
                    formData.append('video', file);
                    formData.append('model_type', '{{ $modelType }}');
                    formData.append('model_id', '{{ $modelId }}');
                    formData.append('description', document.getElementById('uploadDescription').value);
                    
                    const xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', (e) => {
                        if (e.lengthComputable) {
                            const pct = (e.loaded / e.total) * 100;
                            progressBarInner.style.width = pct + '%';
                            progressBarInner.textContent = Math.round(pct) + '%';
                        }
                    });
                    
                    xhr.addEventListener('load', function() {
                        console.log('Upload status:', xhr.status);
                        console.log('Upload response:', xhr.responseText);
                        
                        if (xhr.status === 201) {
                            alert('Video subido exitosamente');
                            @this.call('loadVideos');
                            @this.call('closeModal');
                            uploadForm.reset();
                            progressBar.classList.add('d-none');
                        } else {
                            const response = JSON.parse(xhr.responseText);
                            const errorMsg = response.message || 'Error desconocido';
                            console.error('Error upload:', response);
                            alert('Error al subir: ' + errorMsg);
                        }
                    });
                    
                    xhr.open('POST', '/api/videos');
                    xhr.send(formData);
                });
            }
        })();
        </script>
    @endif

    <style>
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0; }
        }
        .blink {
            animation: blink 1s infinite;
        }
    </style>
</div>

