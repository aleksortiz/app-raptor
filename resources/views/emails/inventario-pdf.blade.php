<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventario de Vehículo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #2c5aa0;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .info-row {
            margin: 10px 0;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background: #e9ecef;
            border-radius: 5px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Autoservicio Raptor" style="max-width: 200px; height: auto; margin-bottom: 10px;">
        <h1>Inventario de Vehículo</h1>
        <p>Folio: {{ $inventario->entrada->folio_short }}</p>
    </div>

    <div class="content">
        <h2>Estimado {{ $inventario->cliente }},</h2>
        
        <p>Le enviamos adjunto el inventario completo de su vehículo con los siguientes detalles:</p>
        
        <div class="info-row">
            <span class="info-label">Vehículo:</span> {{ $inventario->vehiculo }}
        </div>
        
        <div class="info-row">
            <span class="info-label">Placas:</span> {{ $inventario->placas }}
        </div>
        
        <div class="info-row">
            <span class="info-label">Fecha de inventario:</span> {{ $inventario->fecha_creacion }}
        </div>
        
        <div class="info-row">
            <span class="info-label">Realizado por:</span> {{ $inventario->user->name }}
        </div>
        
        <p>El documento PDF adjunto contiene el inventario completo con todos los detalles, incluyendo:</p>
        <ul>
            <li>Información completa del vehículo</li>
            <li>Inventario de equipamiento</li>
            <li>Estado de testigos de advertencia</li>
            <li>Daños de carrocería (si aplica)</li>
            <li>Estado mecánico</li>
            <li>Diagrama del vehículo (si disponible)</li>
            <li>Firma del cliente</li>
        </ul>
        
        <p>Si tiene alguna pregunta o necesita aclaraciones sobre este inventario, no dude en contactarnos.</p>
    </div>

    <div class="footer">
        <p>Este correo fue generado automáticamente por el sistema de Autoservicio Raptor.</p>
        <p>Por favor, conserve este documento para sus registros.</p>
    </div>
</body>
</html>
