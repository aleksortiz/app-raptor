<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Checklist Final - {{ $entrada->folio_short }} / {{ $entrada->vehiculo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #f8f9fa;
            padding: 5px;
        }
        .checklist-item {
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }
        .checklist-item:before {
            content: "-";
            position: absolute;
            left: 0;
            color: #28a745;
        }
        .comment {
            margin-left: 20px;
            font-style: italic;
            color: #dc3545;
            margin-top: 5px;
        }
        .signature-section {
            margin-top: 30px;
            text-align: center;
        }
        .signature-image {
            max-width: 300px;
            margin: 20px auto;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Checklist Final - {{ $entrada->folio_short }} / {{ $entrada->vehiculo }}</h1>
        <p>Fecha de revisión: {{ $entrada->final_checklist->fecha_revision->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Revisión General -->
    <div class="section">
        <div class="section-title">1. Revisión General de Carrocería</div>
        @foreach($entrada->final_checklist->checklist['revision_general'] as $key => $item)
            <div class="checklist-item">
                {{ $item['text'] }}
                @if(!empty($entrada->final_checklist->checklist_comments['revision_general'][$key]))
                    <div class="comment">{{ $entrada->final_checklist->checklist_comments['revision_general'][$key] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Revisión de Pintura -->
    <div class="section">
        <div class="section-title">2. Revisión de Pintura</div>
        @foreach($entrada->final_checklist->checklist['revision_pintura'] as $key => $item)
            <div class="checklist-item">
                {{ $item['text'] }}
                @if(!empty($entrada->final_checklist->checklist_comments['revision_pintura'][$key]))
                    <div class="comment">{{ $entrada->final_checklist->checklist_comments['revision_pintura'][$key] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Limpieza -->
    <div class="section">
        <div class="section-title">3. Limpieza Exterior e Interior</div>
        @foreach($entrada->final_checklist->checklist['limpieza'] as $key => $item)
            <div class="checklist-item">
                {{ $item['text'] }}
                @if(!empty($entrada->final_checklist->checklist_comments['limpieza'][$key]))
                    <div class="comment">{{ $entrada->final_checklist->checklist_comments['limpieza'][$key] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Sistema Eléctrico -->
    <div class="section">
        <div class="section-title">4. Sistema Eléctrico y Funcionalidades</div>
        @foreach($entrada->final_checklist->checklist['sistema_electrico'] as $key => $item)
            <div class="checklist-item">
                {{ $item['text'] }}
                @if(!empty($entrada->final_checklist->checklist_comments['sistema_electrico'][$key]))
                    <div class="comment">{{ $entrada->final_checklist->checklist_comments['sistema_electrico'][$key] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Testigos -->
    <div class="section">
        <div class="section-title">5. Revisión de Testigos</div>
        @foreach($entrada->final_checklist->checklist['testigos'] as $key => $item)
            <div class="checklist-item">
                {{ $item['text'] }}
                @if(!empty($entrada->final_checklist->checklist_comments['testigos'][$key]))
                    <div class="comment">{{ $entrada->final_checklist->checklist_comments['testigos'][$key] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Firma -->
    <div class="section signature-section">
        <div class="section-title">6. Firma de Verificación</div>
        @if($entrada->final_checklist->firma)
            <img src="{{ $entrada->final_checklist->firma }}" class="signature-image">
        @endif
        <p>Verificado por: {{ $entrada->final_checklist->user->name }}</p>
    </div>

    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html> 