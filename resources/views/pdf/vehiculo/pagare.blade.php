<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagaré</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .pagare {
            width: 100%;
            border: 2px solid #333;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        /* .logo {
            position: absolute;
            top: 10px;
            left: 40px;
            width: 100px;
            height: 100px;
            background: url('https://app.autoservicioraptor.com/images/logogv.png') no-repeat center;
            background-size: contain;
        } */
        /* h1 {
            text-align: left;
            text-transform: uppercase;
            font-size: 24px;
            margin-left: 150px;
            margin-bottom: 20px;
        } */
        p {
            text-align: justify;
            line-height: 1.6;
            font-size: 16px;
        }
        .datos {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .datos strong {
            display: inline-block;
            width: 150px;
        }
        .firma {
            margin-top: 40px;
            text-align: center;
            font-size: 20px;
        }
        .firma div {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
        .firma p {
            font-size: 20px;
        }

        h1, h2, h3 {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            font-weight: 700;
            text-align: center;
            text-transform: uppercase;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 42%;
            transform: translate(-50%, -50%);
            width: 900px;
            opacity: 0.15;
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
                opacity: 0.15;
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
    @include('pdf.vehiculo.logogv')

    <div class="pagare">
        <div style="padding: 20px; margin-bottom: 50px;">
            <div>
                <h1>Pagaré {{$pagare->numero_pagare}}</h1>
            </div>
            <p>
                En <strong>{{strtoupper($venta->lugar)}}</strong>, a <strong>{{strtoupper($venta->fecha_letra)}}</strong>, yo, <strong>{{strtoupper($venta->comprador)}}</strong>, con domicilio en <strong>{{strtoupper($venta->comprador_domicilio)}}</strong>, me obligo incondicionalmente a pagar a la orden de <strong>{{strtoupper($venta->vendedor)}}</strong>, la cantidad de <strong>@money($pagare->monto) {{$montoLetra}}</strong>, en <strong>{{$venta->lugar}}</strong>, el día <strong>{{strtoupper($pagare->fecha_letra)}}</strong>.
                
                Dicho monto corresponde al saldo pendiente por la compra-venta del vehículo de las siguientes características:
            </p>
                
            <div class="datos">

                <p><strong>Marca:</strong> {{$vehiculo->marca}}</p>
                <p><strong>Modelo:</strong> {{$vehiculo->modelo}}</p>
                <p><strong>Año:</strong> {{$vehiculo->year}}</p>

                @if ($vehiculo->color)
                    <p><strong>Color:</strong> {{$vehiculo->color}}</p>
                @endif
                
                @if ($vehiculo->numero_serie)
                    <p><strong>Número de serie:</strong> {{$vehiculo->numero_serie}}</p>
                @endif

            </div>
            <p>
                
                Este pagaré es un título ejecutivo mercantil y el incumplimiento de su pago en la fecha estipulada generará intereses moratorios del <strong>{{$pagare->tasa_interes}}</strong>% mensual sobre el saldo insoluto hasta la total liquidación de la deuda.
                
                En caso de que este documento deba ser llevado a juicio, el suscriptor se somete expresamente a la jurisdicción de los tribunales competentes, renunciando a cualquier otro fuero que pudiera corresponderle.                
            </p>

            <div class="firma">
                <div></div>
                <p style="text-align: center;"><strong>{{strtoupper($venta->comprador)}}</strong><br>Firma del deudor</p>
            </div>
        </div>
    </div>
</body>
</html>
