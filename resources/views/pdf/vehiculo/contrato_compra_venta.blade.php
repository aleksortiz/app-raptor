<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Compraventa</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet"> --}}
    <style>


        body {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            margin-top: 0px;
            /* margin: 40px; */
            margin-left: 20px;
            margin-right: 20px;
            padding: 10px;
            position: relative;
            line-height: 1.6;
        }

        .contract {
            position: relative;
            z-index: 2;
        }

        h1, h2, h3 {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            font-weight: 700;
            text-align: center;
        }

        .signature-section {
            margin-top: 40px;
        }

        .signature {
            display: inline-block;
            width: 45%;
            text-align: center;
            margin-top: 20px;
            vertical-align: top
        }

        /* Marca de agua repetida en cada página */
        .watermark {
            position: fixed;
            top: 40%;
            left: 42%;
            transform: translate(-50%, -50%);
            width: 900px;
            opacity: 0.2;
            z-index: -1;
            pointer-events: none;
        }

        /* Para asegurar que la marca de agua aparezca en cada página impresa */
        @media print {
            .watermark {
                position: fixed;
                top: 40%;
                left: 42%;
                transform: translate(-50%, -50%);
                width: 900px;
                opacity: 0.2;
                z-index: -1;
                pointer-events: none;
            }

            body {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>

    <!-- Marca de Agua -->
    @include('pdf.vehiculo.logogv')

    <div class="contract">
        <h1>CONTRATO DE COMPRA-VENTA</h1>

        <p><strong>QUE CELEBRAN POR UNA PARTE</strong> el C. <strong>{{ $contratoVendedor }}</strong>, quien en lo sucesivo se denominará <strong>"EL VENDEDOR"</strong>, y por la otra parte el C. <strong>{{ $contratoComprador }}</strong>, con domicilio en <strong>{{ $contratoDomicilioComprador }}</strong>, quien en adelante se denominará <strong>"EL COMPRADOR"</strong>, de conformidad con las siguientes cláusulas:</p>

        <h2>DECLARACIONES</h2>
        <p>1. <strong>EL VENDEDOR</strong> declara:</p>
        <ul>
            <li>Ser legítimo propietario del vehículo descrito en este contrato.</li>
            <li>Que el vehículo se encuentra libre de gravamen, embargo o adeudo.</li>
            <li>Los documentos del vehículo se entregan al liquidar.</li>
        </ul>

        <p>2. <strong>EL COMPRADOR</strong> declara:</p>
        <ul>
            @if ($contratoIdentificacion)
                <li>Que su identidad se acredita con <strong>{{ $contratoIdentificacion }}</strong>, con número <strong>{{ $contratoIdentificacionNumero }}</strong>.</li>
            @endif
            <li>Que ha inspeccionado el vehículo y acepta su estado físico y mecánico.</li>
            <li>Que ha realizado todas las pruebas y revisiones necesarias, incluyendo mecánicas y documentales, y acepta la compra en las condiciones actuales del vehículo, sin responsabilidad posterior para <strong>EL VENDEDOR</strong>.</li>
            <li>Que ha revisado y está de acuerdo con las condiciones mecánicas del vehículo, aceptando que cualquier reparación o mantenimiento futuro será su responsabilidad exclusiva.</li>
            <li>Que tiene interés en adquirir el vehículo bajo los términos pactados en este contrato.</li>
        </ul>

        <h2>CLÁUSULAS</h2>

        <h3>PRIMERA. OBJETO DEL CONTRATO</h3>
        <p><strong>EL VENDEDOR</strong> vende a <strong>EL COMPRADOR</strong> el vehículo con las siguientes características:</p>
        <ul>
            <li><strong>Marca y Modelo:</strong> {{ $contratoMarca }} {{ $contratoModelo }}</li>
            <li><strong>Año:</strong> {{ $contratoYear }}</li>

            @if ($contratoNumeroSerie )
                <li><strong>Número de serie (VIN):</strong> {{ $contratoNumeroSerie }}</li>
            @endif
            
            @if ($contratoKilometraje )
                <li><strong>Kilometraje:</strong> {{ number_format($contratoKilometraje, 0) }} km</li>
            @endif

            <li><strong>Color:</strong> {{ $contratoColor }}</li>

            @if ($contratoPlacas )
                <li><strong>Placas:</strong> {{ $contratoPlacas }}</li>
            @endif
        </ul>
        
        <br>

        <h3>SEGUNDA. PRECIO Y CONDICIONES DE PAGO</h3>
        <p>El precio total del vehículo es de <strong>${{ number_format($contratoPrecio, 2) }}</strong> ({{ $contratoPrecioLetra }}).</p>

        <p>El pago se efectuará en los siguientes términos:</p>
        <ul>
            <li><strong>Anticipo:</strong> ${{ number_format($contratoAnticipo, 2) }} ({{ $contratoAnticipoLetra }}).</li>
            <li><strong>Saldo restante:</strong> ${{ number_format($contratoPrecio - $contratoAnticipo, 2) }}, a pagarse en <strong>{{ $contratoPlazos }}</strong> pagos mensuales de <strong>${{ number_format(($contratoPrecio - $contratoAnticipo) / $contratoPlazos, 2) }}</strong> cada uno.</li>
            <li>La propiedad del vehículo permanecerá a nombre de <strong>EL VENDEDOR</strong> hasta la liquidación total del monto adeudado.</li>
        </ul>

        <h3>TERCERA. OBLIGACIONES DEL COMPRADOR</h3>
        <p>A partir de la entrega del vehículo, <strong>EL COMPRADOR</strong> se compromete a:</p>
        <ul>
            <li>Realizar el mantenimiento adecuado del vehículo.</li>
            <li>Cubrir cualquier gasto relacionado con tenencia, seguro, verificaciones y demás obligaciones legales.</li>
            <li>No vender ni transferir la posesión del vehículo hasta haber liquidado la totalidad del monto adeudado.</li>
            <li>Reconocer que el vehículo se vende en las condiciones en las que se encuentra, sin garantía de parte de <strong>EL VENDEDOR</strong>, y que cualquier reparación posterior es su responsabilidad exclusiva.</li>
        </ul>

        <h3>CUARTA. RESOLUCIÓN DEL CONTRATO</h3>
        <p>Ambas partes acuerdan que este contrato podrá darse por terminado de mutuo acuerdo, en cuyo caso se definirán las condiciones de devolución o liquidación del monto adeudado.</p>

        <h2>FIRMAS</h2>
        <div class="signature-section">
            <div class="signature">
                <p>___________________________</p>
                <p><strong>EL VENDEDOR</strong></p>
                <p>{{ $contratoVendedor }}</p>
            </div>
            <div class="signature">
                <p>___________________________</p>
                <p><strong>EL COMPRADOR</strong></p>
                <p>{{ $contratoComprador }}</p>
            </div>
        </div>

        {{-- <h2>TESTIGOS</h2>
        <p>Nombre: ___________________________ Firma: ___________________________</p>
        <p>Nombre: ___________________________ Firma: ___________________________</p> --}}

    </div>

</body>
</html>
