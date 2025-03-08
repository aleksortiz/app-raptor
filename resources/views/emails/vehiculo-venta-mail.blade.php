<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚗 Vehículo en Venta - AUTOSERVICIO-RAPTOR</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <table width="600px" style="background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
                    <!-- Logo -->
                    <tr>
                        <td align="center">
                            <img src="https://app.autoservicioraptor.com/images/logogv.png" width="300px" alt="logo" style="margin-bottom: 20px;">
                        </td>
                    </tr>

                    <!-- Título -->
                    <tr>
                        <td align="center">
                            <h2 style="color: #333;">🚘 ¡Tenemos un vehículo para ti!</h2>
                            <p style="color: #555;">Descubre los detalles de este increíble automóvil disponible en AUTOSERVICIO-RAPTOR.</p>
                        </td>
                    </tr>

                    <!-- Datos del Vehículo -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <table width="100%" cellspacing="0" cellpadding="10" style="background: #1e1e1e; color: #ffffff; border-radius: 8px;">
                                <tr>
                                    <td style="text-align: left;"><strong>🚗 Modelo:</strong></td>
                                    <td style="text-align: right;">{{ strtoupper($vehiculo->modelo) }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><strong>📅 Año:</strong></td>
                                    <td style="text-align: right;">{{$vehiculo->year}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;"><strong>💰 Precio:</strong></td>
                                    <td style="text-align: right;">${{ number_format($vehiculo->precio_venta, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>   

                    <!-- Mensaje de Contacto -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <p style="color: #555;">Si deseas más información sobre este vehículo, ¡contáctanos ahora!</p>

                            <!-- Botón de WhatsApp -->
                            <a href="https://wa.me/5216563817465?text=Hola, estoy interesado en el vehículo: {{$vehiculo->descripcion}} ¿Podrían darme más información?"
                               style="display: inline-block; background-color: #25D366; color: white; padding: 12px 20px; font-size: 16px; border-radius: 5px; text-decoration: none; font-weight: bold;">
                                📲 Preguntar por WhatsApp
                            </a>

                            <p style="font-size: 14px; color: #777; margin-top: 10px;">📞 Teléfono: +52 (656) 381 7465 | 📧 Email: autoservicioraptor@hotmail.com</p>
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
