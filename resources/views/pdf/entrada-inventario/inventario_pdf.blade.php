<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario # {{$inventario->id_paddy}}</title>
    
    <style type="text/css">
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-size: 8px;
            line-height: 1.2;
            color: #333;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        
        .header {
            border-bottom: 2px solid #2c5aa0;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .logo-section {
            width: 25%;
            vertical-align: top;
        }
        
        .info-section {
            width: 75%;
            vertical-align: top;
            padding-left: 10px;
        }
        
        .folio-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c5aa0;
            margin: 0;
            text-transform: uppercase;
        }
        
        .inventory-info {
            background: #f8f9fa;
            padding: 6px;
            border-radius: 3px;
            margin-top: 5px;
            border-left: 3px solid #2c5aa0;
        }
        
        .section-title {
            background: #2c5aa0;
            color: white;
            padding: 4px 8px;
            margin: 6px 0 3px 0;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 2px;
        }
        
        .section-content {
            background: #f8f9fa;
            padding: 6px;
            border-radius: 3px;
            margin-bottom: 6px;
            border: 1px solid #dee2e6;
        }
        
        .field-row {
            display: table;
            width: 100%;
            margin-bottom: 2px;
            padding: 1px 0;
        }
        
        .field-label {
            display: table-cell;
            font-weight: bold;
            width: 35%;
            color: #495057;
            font-size: 8px;
        }
        
        .field-value {
            display: table-cell;
            width: 65%;
            color: #212529;
            font-size: 8px;
        }
        
        .two-column {
            width: 100%;
            display: table;
        }
        
        .column-left {
            width: 48%;
            vertical-align: top;
            padding-right: 2%;
            display: table-cell;
        }
        
        .column-right {
            width: 48%;
            vertical-align: top;
            padding-left: 2%;
            display: table-cell;
        }
        
        .status-ok {
            color: #28a745;
            font-weight: bold;
            background: #d4edda;
            padding: 2px 6px;
            border-radius: 3px;
        }
        
        .status-warning {
            color: #856404;
            font-weight: bold;
            background: #fff3cd;
            padding: 2px 6px;
            border-radius: 3px;
        }
        
        .status-error {
            color: #721c24;
            font-weight: bold;
            background: #f8d7da;
            padding: 2px 6px;
            border-radius: 3px;
        }
        
        .checkbox-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            margin-right: 8px;
            margin-bottom: 2px;
        }
        
        .checkbox {
            width: 8px;
            height: 8px;
            border: 1px solid #495057;
            margin-right: 4px;
            display: inline-block;
            border-radius: 1px;
        }
        
        .diagram-section {
            text-align: center;
            margin: 8px 0;
            padding: 6px;
            background: #f8f9fa;
            border-radius: 3px;
            border: 1px solid #dee2e6;
        }
        
        .signature-section {
            margin-top: 8px;
            text-align: center;
        }
        
        .signature-box {
            border: 1px solid #495057;
            padding: 6px;
            margin: 8px auto;
            max-width: 600px;
            border-radius: 3px;
            background: #f8f9fa;
        }
        
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 6px;
            margin: 8px 0;
            border-radius: 3px;
        }
        
        .warning-title {
            color: #856404;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 3px;
            font-size: 8px;
        }
        
        .warning-text {
            color: #856404;
            text-align: justify;
            line-height: 1.2;
            font-size: 7px;
        }
        
        .grid-container {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .grid-item {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }
        
        .highlight-box {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 15px 0;
            border-radius: 6px;
        }
        
        .damage-section {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            padding: 4px;
            margin: 2px 0;
            border-radius: 2px;
        }
        
        .damage-title {
            color: #c53030;
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 8px;
        }
        
        .mechanical-section {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            padding: 4px;
            margin: 2px 0;
            border-radius: 2px;
        }
        
        .mechanical-title {
            color: #2f855a;
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 8px;
        }
        
        .text-detail {
            background: #f8f9fa;
            padding: 2px;
            border-radius: 2px;
            margin-top: 1px;
            font-style: italic;
            border-left: 2px solid #6c757d;
            font-size: 7px;
        }
        
        @media print {
            .section-content {
                break-inside: avoid;
            }
            .grid-container {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    @php
        $inventarioData = json_decode($inventario->inventario, true);
        $testigosData = json_decode($inventario->testigos, true);
        $carroceriaData = json_decode($inventario->carroceria, true);
        $mecanicaData = json_decode($inventario->mecanica, true);
    @endphp

    <!-- HEADER SECTION -->
    <div class="header">
  <table width="100%">
    <tr>
      <td class="logo-section">
        @include('pdf.entrada-inventario.logo')
      </td>
                <td class="info-section">
                    <h1 class="folio-title">Folio: {{$inventario->entrada->folio_short}}</h1>
                    <div class="inventory-info">
                        <div class="field-row">
                            <div class="field-label">Inventario:</div>
                            <div class="field-value">#{{ $inventario->id_paddy }}</div>
                        </div>
                        <div class="field-row">
                            <div class="field-label">Fecha:</div>
                            <div class="field-value">{{ $inventario->fecha_creacion }}</div>
                        </div>
                        <div class="field-row">
                            <div class="field-label">Realizado por:</div>
                            <div class="field-value">{{$inventario->user->name}}</div>
                        </div>
        </div>
      </td>
    </tr>
  </table>
    </div>

    <!-- VEHICLE INFORMATION -->
    <div class="section-title"><i class="fas fa-car"></i> INFORMACIÓN DEL VEHÍCULO</div>
    <div class="section-content">
        <div class="two-column">
            <div class="column-left">
                <div class="field-row">
                    <div class="field-label">Cliente:</div>
                    <div class="field-value">{{ $inventario->cliente }}</div>
                </div>
                <div class="field-row">
                    <div class="field-label">Teléfono:</div>
                    <div class="field-value">{{$inventario->telefono}}</div>
                </div>
                <div class="field-row">
                    <div class="field-label">Vehículo:</div>
                    <div class="field-value">{{$inventario->vehiculo}}</div>
                </div>
                <div class="field-row">
                    <div class="field-label">Año:</div>
                    <div class="field-value">{{$inventario->year}}</div>
                </div>
                <div class="field-row">
                    <div class="field-label">Kilometraje:</div>
                    <div class="field-value">{{$inventario->kilometros}} km</div>
                </div>
            </div>
            <div class="column-right">
                <div class="field-row">
                    <div class="field-label">Placas:</div>
                    <div class="field-value">{{ $inventario->placas }}</div>
                </div>
                <div class="field-row">
                    <div class="field-label">Gasolina:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventario->gasolina > 50 ? 'ok' : ($inventario->gasolina > 25 ? 'warning' : 'error') }}">
                            {{$inventario->gasolina}}%
                        </span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-label">Color:</div>
                    <div class="field-value">{{$inventario->color}}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- INVENTORY SECTION -->
    <div class="section-title">INVENTARIO DE EQUIPAMIENTO</div>
    <div class="section-content">
        <div class="two-column">
            <div class="column-left">
                @if(isset($inventarioData['estereo']))
                <div class="field-row">
                    <div class="field-label">Estéreo:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['estereo'] === 'FUNCIONAL' ? 'ok' : ($inventarioData['estereo'] === 'NO TIENE' ? 'warning' : 'error') }}">
                            {{ $inventarioData['estereo'] }}
                        </span>
                    </div>
                </div>
                @endif
                @if(isset($inventarioData['tapetes']))
                <div class="field-row">
                    <div class="field-label">Tapetes:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['tapetes'] === 'COMPLETOS' ? 'ok' : ($inventarioData['tapetes'] === 'INCOMPLETOS' ? 'warning' : 'error') }}">
                            {{ $inventarioData['tapetes'] }}
                        </span>
                    </div>
                </div>
                @endif
                @if(isset($inventarioData['parabrisas']))
                <div class="field-row">
                    <div class="field-label">Parabrisas:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['parabrisas'] === 'SIN DETALLES' ? 'ok' : 'error' }}">
                            {{ $inventarioData['parabrisas'] }}
                        </span>
                    </div>
                </div>
                @endif
                @if(isset($inventarioData['ac']))
                <div class="field-row">
                    <div class="field-label">Aire Acondicionado:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['ac'] === 'FUNCIONAL' ? 'ok' : ($inventarioData['ac'] === 'SIN GAS' ? 'warning' : 'error') }}">
                            {{ $inventarioData['ac'] }}
                        </span>
                    </div>
                </div>
                @endif
            </div>
            <div class="column-right">
                @if(isset($inventarioData['gato']))
                <div class="field-row">
                    <div class="field-label">Gato:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['gato'] === 'TIENE' ? 'ok' : 'error' }}">
                            {{ $inventarioData['gato'] }}
                        </span>
                    </div>
                </div>
                @endif
                @if(isset($inventarioData['extra']))
                <div class="field-row">
                    <div class="field-label">Extras:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['extra'] === 'TIENE' ? 'ok' : 'warning' }}">
                            {{ $inventarioData['extra'] }}
                        </span>
                    </div>
                </div>
                @endif
                @if(isset($inventarioData['herramientas']))
                <div class="field-row">
                    <div class="field-label">Herramientas:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['herramientas'] === 'TIENE' ? 'ok' : 'warning' }}">
                            {{ $inventarioData['herramientas'] }}
                        </span>
                    </div>
                </div>
                @endif
                @if(isset($inventarioData['cables']))
                <div class="field-row">
                    <div class="field-label">Cables:</div>
                    <div class="field-value">
                        <span class="status-{{ $inventarioData['cables'] === 'TIENE' ? 'ok' : 'warning' }}">
                            {{ $inventarioData['cables'] }}
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- WARNING LIGHTS SECTION -->
    <div class="section-title">TESTIGOS DE ADVERTENCIA</div>
    <div class="section-content">
        @if($testigosData)
        <div class="two-column">
            <div class="column-left">
                <div class="field-row">
                    <div class="field-label">ABS:</div>
                    <div class="field-value">
                        <span class="status-{{ $testigosData['abs'] ? 'error' : 'ok' }}">
                            {{ $testigosData['abs'] ? 'ENCENDIDO' : 'OK' }}
                        </span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-label">Check Engine:</div>
                    <div class="field-value">
                        <span class="status-{{ $testigosData['check_engine'] ? 'error' : 'ok' }}">
                            {{ $testigosData['check_engine'] ? 'ENCENDIDO' : 'OK' }}
                        </span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-label">Antiderrapante:</div>
                    <div class="field-value">
                        <span class="status-{{ $testigosData['antiderrapante'] ? 'error' : 'ok' }}">
                            {{ $testigosData['antiderrapante'] ? 'ENCENDIDO' : 'OK' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="column-right">
                <div class="field-row">
                    <div class="field-label">Brake:</div>
                    <div class="field-value">
                        <span class="status-{{ $testigosData['brake'] ? 'error' : 'ok' }}">
                            {{ $testigosData['brake'] ? 'ENCENDIDO' : 'OK' }}
                        </span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-label">Bolsas de Aire:</div>
                    <div class="field-value">
                        <span class="status-{{ $testigosData['bolsas'] ? 'error' : 'ok' }}">
                            {{ $testigosData['bolsas'] ? 'ENCENDIDO' : 'OK' }}
                        </span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field-label">Stability Track:</div>
                    <div class="field-value">
                        <span class="status-{{ $testigosData['stability_track'] ? 'error' : 'ok' }}">
                            {{ $testigosData['stability_track'] ? 'ENCENDIDO' : 'OK' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>


    <!-- BODYWORK DAMAGE SECTION -->
    <div class="section-title">DAÑOS DE CARROCERÍA</div>
    <div class="section-content">
        @if($carroceriaData)
            <!-- Puertas -->
            @if(isset($carroceriaData['puertas']) && array_filter($carroceriaData['puertas']))
                <div class="damage-section">
                    <div class="damage-title">PUERTAS</div>
                    <div class="checkbox-list">
                        @foreach($carroceriaData['puertas'] as $puerta => $tiene_dano)
                            @if($tiene_dano)
                                <div class="checkbox-item">
                                    
                                    <span>{{ ucfirst(str_replace('_', ' ', $puerta)) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Costados -->
            @if(isset($carroceriaData['costados']) && array_filter($carroceriaData['costados']))
                <div class="damage-section">
                    <div class="damage-title">COSTADOS</div>
                    <div class="checkbox-list">
                        @foreach($carroceriaData['costados'] as $costado => $tiene_dano)
                            @if($tiene_dano)
                                <div class="checkbox-item">
                                    
                                    <span>{{ ucfirst(str_replace('_', ' ', $costado)) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Otros daños de carrocería -->
            @php
                $otros_danos = [
                    'piso_cajuela' => 'Piso de Cajuela',
                    'tolva_escape' => 'Tolva de Escape',
                    'capacete' => 'Capacete',
                    'cofre' => 'Cofre',
                    'rep_granizo' => 'Reparación de Granizo',
                    'pintura_general' => 'Pintura General'
                ];
  @endphp

            @foreach($otros_danos as $campo => $nombre)
                @if(isset($carroceriaData[$campo]) && $carroceriaData[$campo])
                    <div class="damage-section">
                        <div class="damage-title">{{ strtoupper($nombre) }}</div>
                        <div class="checkbox-item">
                            
                            <span>Daño detectado</span>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Fenders -->
            @if(isset($carroceriaData['fender']) && array_filter($carroceriaData['fender']))
                <div class="damage-section">
                    <div class="damage-title">FENDERS</div>
                    <div class="checkbox-list">
                        @foreach($carroceriaData['fender'] as $fender => $tiene_dano)
                            @if($tiene_dano)
                                <div class="checkbox-item">
                                    
                                    <span>{{ ucfirst(str_replace('_', ' ', $fender)) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Facias -->
            @if(isset($carroceriaData['facia']) && array_filter($carroceriaData['facia']))
                <div class="damage-section">
                    <div class="damage-title">FACIAS</div>
                    <div class="checkbox-list">
                        @foreach($carroceriaData['facia'] as $facia => $tiene_dano)
                            @if($tiene_dano)
                                <div class="checkbox-item">
                                    
                                    <span>{{ ucfirst(str_replace('_', ' ', $facia)) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Otros daños específicos -->
            @if(isset($carroceriaData['carroceria_otro']) && $carroceriaData['carroceria_otro'] && !empty($carroceriaData['carroceria_otro_text']))
                <div class="damage-section">
                    <div class="damage-title">OTROS DAÑOS</div>
                    <div class="text-detail">{{ $carroceriaData['carroceria_otro_text'] }}</div>
                </div>
            @endif
        @endif
    </div>

    <!-- MECHANICAL SECTION -->
    <div class="section-title">ESTADO MECÁNICO</div>
    <div class="section-content">
        @if($mecanicaData)
            <div class="mechanical-section">
                <div class="mechanical-title">SERVICIOS REQUERIDOS</div>
                <div class="checkbox-list">
                    @php
                        $servicios = [
                            'afinacion_mayor' => 'Afinación Mayor',
                            'cambio_aceite' => 'Cambio de Aceite',
                            'frenos' => 'Frenos'
                        ];
                    @endphp
                    @foreach($servicios as $servicio => $nombre)
                        @if(isset($mecanicaData[$servicio]) && $mecanicaData[$servicio])
                            <div class="checkbox-item">
                                
                                <span>{{ $nombre }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Fallas mecánicas -->
            @if(isset($mecanicaData['falla_mecanica']) && $mecanicaData['falla_mecanica'] && !empty($mecanicaData['falla_mecanica_text']))
                <div class="mechanical-section">
                    <div class="mechanical-title">FALLAS MECÁNICAS</div>
                    <div class="text-detail">{{ $mecanicaData['falla_mecanica_text'] }}</div>
                </div>
            @endif

            <!-- Suspensión -->
            @if(isset($mecanicaData['suspension']) && $mecanicaData['suspension'] && !empty($mecanicaData['suspension_text']))
                <div class="mechanical-section">
                    <div class="mechanical-title">SUSPENSIÓN</div>
                    <div class="text-detail">{{ $mecanicaData['suspension_text'] }}</div>
                </div>
            @endif

            <!-- Otros problemas mecánicos -->
            @if(isset($mecanicaData['mecanica_otro']) && $mecanicaData['mecanica_otro'] && !empty($mecanicaData['mecanica_otro_text']))
                <div class="mechanical-section">
                    <div class="mechanical-title">OTROS PROBLEMAS MECÁNICOS</div>
                    <div class="text-detail">{{ $mecanicaData['mecanica_otro_text'] }}</div>
                </div>
            @endif
        @endif
    </div>

    <!-- VEHICLE DIAGRAM -->
    @if($inventario->diagrama)
        <div class="diagram-section">
            <h3>DIAGRAMA DEL VEHÍCULO</h3>
            <img src="{{$inventario->diagrama}}" width="400" height="200" alt="Diagrama del vehículo" />
        </div>
    @endif

    <!-- NOTES SECTION -->
  @if($inventario->notas)
        <div class="section-title">NOTAS ADICIONALES</div>
        <div class="section-content">
            <div class="highlight-box">
                {{$inventario->notas}}
            </div>
        </div>
  @endif

    <!-- SIGNATURE SECTION -->
    <div class="signature-section">
        @if($inventario->firma)
            <img src="{{$inventario->firma}}" width="200" height="120" alt="Firma del cliente" />
        @endif
        <h4>{{$inventario->cliente}}</h4>
        
        <div class="warning-box">
            <div class="warning-title">[!] AVISO IMPORTANTE</div>
            <div class="warning-text">
              Declaro que he sido informado y acepto que no he dejado objetos de valor dentro del vehículo. 
              Entiendo y acepto que Autoservicio Raptor no será responsable por la pérdida, robo o daño de objetos olvidados.
            </div>
        </div>
      </div>
</body>
</html>
