<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Captura de Imagen</title>
</head>
<body>

<h2>Captura una Imagen</h2>
<video id="video" width="1280" height="720" autoplay></video>
<button id="capture">Capturar Foto</button>
<canvas id="canvas" width="1280" height="720" style="display: none;"></canvas>
<img id="photo" alt="Vista previa" width="1280" height="720">

<!-- Formulario para enviar la imagen -->
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="photo" id="photoInput">
    <button type="submit">Subir Imagen</button>
</form>

<script>
    // Acceder a la cámara
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const photo = document.getElementById('photo');
    const photoInput = document.getElementById('photoInput');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((err) => {
            console.error("Error al acceder a la cámara: ", err);
        });

    // Capturar la foto
    document.getElementById('capture').addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Convertir la imagen del canvas a Base64
        const dataUrl = canvas.toDataURL('image/png');
        photo.src = dataUrl;
        photoInput.value = dataUrl; // Asigna la imagen Base64 al campo oculto
    });
</script>

</body>
</html>
