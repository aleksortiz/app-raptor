<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cita Confirmada - AUTOSERVICIO-RAPTOR</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="600px" style="background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="https://app.autoservicioraptor.com/images/logo.png" width="500px" alt="Notificación" style="margin-bottom: 20px;">
                        </td>
                    </tr>

                    <!-- Título -->
                    <tr>
                        <td align="center">
                            <h2 style="color: #333;">🔧 ¡Tu cita ha sido confirmada!</h2>
                            <p style="color: #555;">Gracias por confiar en <strong>AUTOSERVICIO-RAPTOR</strong>. Aquí tienes los detalles de tu cita:</p>
                        </td>
                    </tr>

                    <!-- Datos de la Cita -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <table width="100%" cellspacing="0" cellpadding="10" style="background: #1e1e1e; color: #ffffff; border-radius: 8px;">
                                <tr>
                                    <td style="text-align: left;"><strong>👤 Nombre:</strong></td>
                                    <td style="text-align: right;">{{$registroQR->cliente_nombre}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><strong>🚗 Vehículo:</strong></td>
                                    <td style="text-align: right;">{{$registroQR->vehiculo}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><strong>📅 Fecha de Cita:</strong></td>
                                    <td style="text-align: right;">{{$registroQR->fecha_cita_format}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><strong>🛠️ Asunto:</strong></td>
                                    <td style="text-align: right;">{{$registroQR->tipo_format}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Mensaje de Contacto -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <p style="color: #555;">Si tienes alguna duda, no dudes en contactarnos.</p>
                            <p style="font-size: 14px; color: #777;">📞 Teléfono: +52 (656) 381 7465 | 📧 Email: autoservicioraptor@hotmail.com</p>
                        </td>
                    </tr>

                    <!-- Pie de Página -->
                    <tr>
                        <td align="center" style="background: #1e1e1e; color: #ffffff; padding: 15px; border-radius: 0 0 8px 8px;">
                            &copy; 2025 AUTOSERVICIO-RAPTOR. Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
