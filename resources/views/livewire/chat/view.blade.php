<div>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0a192f; /* Azul oscuro profundo */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #e0e0e0; /* Texto claro */
        }
    
        /* Contenedor principal del chat */
        .chat-wrapper {
            /* width: 90%; */
            min-width: 700px;
            height: 90vh;
            /* max-height: 900px; */
            background-color: #112240; /* Azul oscuro */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
    
        /* Contenedor del chat */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #112240; /* Azul oscuro */
        }
    
        /* Encabezado del chat */
        .chat-header {
            background-color: #ffffff; /* Azul oscuro más intenso */
            color: #ffffff;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #1f2a48;
        }
    
        .chat-title {
            font-size: 18px;
            font-weight: bold;
        }
    
        .chat-status {
            font-size: 12px;
            color: #64ffda; /* Color turquesa para el estado */
        }
    
        /* Área de mensajes */
        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background-color: #112240; /* Azul oscuro */
            display: flex;
            flex-direction: column;
            gap: 10px; /* Espacio entre mensajes */
        }
    
        /* Estilos para los mensajes */
        .message {
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            position: relative;
            word-wrap: break-word;
            display: inline-block; /* Ajusta el tamaño al contenido */
        }
    
        .message.received {
            background-color: #1f2a48; /* Azul oscuro para mensajes recibidos */
            align-self: flex-start;
        }
    
        .message.sent {
            background-color: #64ffda; /* Turquesa para mensajes enviados */
            color: #0a192f; /* Texto oscuro para contrastar */
            align-self: flex-end;
        }
    
        .message-sender {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #64ffda; /* Turquesa para el remitente */
        }
    
        .message-content {
            font-size: 14px;
            margin: 0; /* Elimina el margen predeterminado */
        }
    
        .message-time {
            font-size: 10px;
            color: #8892b0; /* Texto gris azulado para la hora */
            text-align: right;
            margin-top: 5px;
        }
    
        /* Área de entrada de texto */
        .chat-input {
            display: flex;
            border-top: 1px solid #1f2a48;
            padding: 10px;
            background-color: #0a192f; /* Azul oscuro más intenso */
        }
    
        .input-field {
            flex: 1;
            padding: 10px;
            border: 1px solid #1f2a48;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
            background-color: #112240; /* Azul oscuro para el input */
            color: #e0e0e0; /* Texto claro */
        }
    
        .send-button {
            background-color: #64ffda; /* Turquesa para el botón */
            color: #0a192f; /* Texto oscuro */
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
            font-size: 14px;
        }
    
        .send-button:hover {
            background-color: #52e0c4; /* Turquesa más oscuro al pasar el mouse */
        }
    

    </style>
    
    <div class="chat-wrapper">
        <div class="chat-container">
            <!-- Encabezado del chat -->
            <div class="chat-header">
                <!-- <div class="chat-title">Chat con Autoservicio-Raptor</div> -->
                <image src="https://app.autoservicioraptor.com/images/logo.png" alt="Avatar" style="width:400px">
    
            </div>
    
            <!-- Área de mensajes -->
            <div class="chat-messages">
                <!-- Mensaje recibido -->
                <div class="message received">
                    <div class="message-sender">Autoservicio-Raptor</div>
                    <div class="message-content">Hola, Bienvenido a AutoservicioRaptor ¿En que te puedo ayudar?</div>
                    <div class="message-time">10:00 AM</div>
                </div>
    
                <!-- Mensaje enviado -->
                <div class="message sent">
                    <div class="message-content">¡Hola! que estatus tiene mi vehiculo 05-23?</div>
                    <div class="message-time">10:01 AM</div>
                </div>
    
                <!-- Mensaje recibido -->
                <div class="message received">
                    <div class="message-sender">Autoservicio-Raptor</div>
                    <div class="message-content">Tu vehiculo se encuentra en proceso de PINTURA, puedes ver aqui las <u>FOTOS</u> </div>
                    <div class="message-time">10:02 AM</div>
                </div>
    
                <!-- Mensaje enviado -->
                <div class="message sent">
                    <div class="message-content">Gracias</div>
                    <div class="message-time">10:03 AM</div>
                </div>
            </div>
    
            <!-- Área de entrada de texto -->
            <div class="chat-input">
                <input type="text" placeholder="Escribe un mensaje..." class="input-field">
                <button wire:click="sendMessage" class="send-button">Enviar</button>
            </div>
        </div>
    </div>
    
</div>