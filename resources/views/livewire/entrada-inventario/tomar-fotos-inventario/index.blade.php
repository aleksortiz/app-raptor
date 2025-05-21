@extends('layouts.public')


@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/ion-range-slider/css/ion.rangeSlider.min.css') }}">
    <style>
        .layer {
            align-items: center;
            justify-content: center;
            /* margin: 10px; */
            /* height: 70vh; */
        }

        h1 {
            margin-bottom: 20px;
        }

        canvas {
            border: 1px solid #000;
            /* width: 100%; */
            /* height: 60vh; */
        }
    </style>
@endsection


@section('content')
    @include('shared.system.loader')
    @livewire('entrada-inventario.tomar-fotos-inventario', ['inventario' => $inventario])
@endsection


@push('js')
<script>
    let aceptado = false;


    function aceptarLeyendaClick() {
        aceptado = !aceptado;
        const leyenda = document.getElementById('aceptarLeyenda');
        const btnAceptar = document.getElementById('btnAceptarFirma');
        const icono = document.getElementById('iconoLeyenda');
        if (aceptado) {
            leyenda.style.background = '#28a745';
            leyenda.style.color = '#fff';
            leyenda.style.border = '2px solid #218838';
            icono.innerHTML = '<i class="fa fa-check mr-2"></i>';
            btnAceptar.removeAttribute('disabled');
        } else {
            leyenda.style.background = '#f8d7da';
            leyenda.style.color = '#721c24';
            leyenda.style.border = '2px solid #f5c6cb';
            icono.innerHTML = '<i class="fa fa-exclamation-triangle mr-2"></i>';
            btnAceptar.setAttribute('disabled', 'disabled');
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        const btnAceptar = document.getElementById('btnAceptarFirma');
        if(btnAceptar) btnAceptar.setAttribute('disabled', 'disabled');
        const icono = document.getElementById('iconoLeyenda');
        if(icono) icono.innerHTML = '<i class="fa fa-exclamation-triangle mr-2"></i>';
        initCanvas();
    });


    Livewire.on('init-canvas', function(target){
        initCanvas();
    });

    Livewire.on('guardar-firma', function(target){
        const canvas = document.getElementById('drawingCanvas');
        const dataUrl = canvas.toDataURL('image/png');
        window.livewire.emit('saveSign', dataUrl);
    });

    function initCanvas() {
            const canvas = document.getElementById('drawingCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            canvas.height = 300;
            canvas.width = 800;

            // Variables para el dibujo
            let drawing = false;

            function startDrawing(e) {
                e.preventDefault();
                drawing = true;
                draw(e);
            }

            function stopDrawing(e) {
                e.preventDefault();
                drawing = false;
                ctx.beginPath();
            }

            function getEventPosition(e) {
                const rect = canvas.getBoundingClientRect();
                let clientX, clientY;

                if (e.touches && e.touches[0]) {
                    // Evento táctil
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                } else {
                    // Evento de mouse
                    clientX = e.clientX;
                    clientY = e.clientY;
                }

                const x = (clientX - rect.left) * (canvas.width / rect.width);
                const y = (clientY - rect.top) * (canvas.height / rect.height);

                return { x, y };
            }


            function draw(e) {
                if (!drawing) return;

                e.preventDefault();
                ctx.lineWidth = 3;
                ctx.lineCap = 'round';
                ctx.strokeStyle = 'black';

                const { x, y } = getEventPosition(e);

                ctx.lineTo(x, y);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(x, y);
                hasSignature = true;
            }

            // Event Listeners
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseleave', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing);
            canvas.addEventListener('touchend', stopDrawing);
            canvas.addEventListener('touchmove', draw);
    }

    function cleanCanvas() {
        const canvas = document.getElementById('drawingCanvas');
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasSignature = false;
        initCanvas();
    }


</script>
@endpush