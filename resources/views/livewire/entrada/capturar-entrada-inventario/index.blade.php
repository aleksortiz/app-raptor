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
    @livewire('entrada.capturar-entrada-inventario', ['entrada' => $entrada])
@endsection

@section('js')
    <script src="{{ asset('vendor/ion-range-slider/ion.rangeSlider.min.js') }}"></script>
    <script>
        $("#range_gas").ionRangeSlider({
            skin: "round",
            postfix : ' %',
            prettify_enabled: true,
            min: 0,
            max: 100,
            from: 0,
            onStart: function(data) {
                // fired then range slider is ready
            },
            onChange: function(data) {
                window.livewire.emit('setGas', data.from);
            },
            onFinish: function(data) {
                // fired on pointer release
            },
            onUpdate: function(data) {
                // fired on changing slider with Update method
            }
        });


        const canvas = document.getElementById('drawingCanvas');
        const ctx = canvas.getContext('2d');

        // Ajusta el tamaño del canvas
        canvas.width = window.innerWidth * 0.5;
        canvas.height = window.innerHeight * 0.5;
        // canvas.width = '50px';

        // Variables para el dibujo
        let drawing = false;

        function startDrawing(e) {
            e.preventDefault(); // Previene el comportamiento predeterminado
            drawing = true;
            draw(e); // Llama a la función draw para comenzar a dibujar de inmediato
        }

        function stopDrawing(e) {
            e.preventDefault(); // Previene el comportamiento predeterminado
            drawing = false;
            ctx.beginPath(); // Comienza un nuevo trazo
        }

        function getEventPosition(e) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: e.clientX !== undefined ? e.clientX - rect.left : e.touches[0].clientX - rect.left,
                y: e.clientY !== undefined ? e.clientY - rect.top : e.touches[0].clientY - rect.top
            };
        }

        function draw(e) {
            if (!drawing) return;

            e.preventDefault(); // Previene el comportamiento predeterminado
            ctx.lineWidth = 1;
            ctx.lineCap = 'round';
            ctx.strokeStyle = 'black';

            const {
                x,
                y
            } = getEventPosition(e);

            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        function downloadCanvas() {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'canvas-image.png';
            link.click();
        }

        async function saveCanvas() {
            const dataUrl = canvas.toDataURL('image/png');
            const response = await fetch('https://your-api-endpoint.com/save-image', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    image: dataUrl
                })
            });

            if (response.ok) {
                alert('Imagen guardada exitosamente!');
            } else {
                alert('Error al guardar la imagen.');
            }
        }

        // Event Listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mousemove', draw);

        canvas.addEventListener('touchstart', startDrawing);
        canvas.addEventListener('touchend', stopDrawing);
        canvas.addEventListener('touchmove', draw);

        const downloadBtn = document.getElementById('downloadBtn');
        downloadBtn.addEventListener('click', downloadCanvas);

        const saveBtn = document.getElementById('saveBtn');
        saveBtn.addEventListener('click', saveCanvas);
    </script>
@endsection
