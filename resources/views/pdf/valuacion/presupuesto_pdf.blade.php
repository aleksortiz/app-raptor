<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Presupuesto {{ $presupuesto->id_paddy ?? $presupuesto->id }}</title>
  <style>
    * { font-family: DejaVu Sans, Helvetica, Arial, sans-serif; }
    body { font-size: 10px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 6px; }
    .no-border { border: none !important; }
    .right { text-align: right; }
    .center { text-align: center; }
    .header { margin-bottom: 12px; }
    .header h2 { margin: 0 0 4px 0; font-size: 14px; text-align: center; }
    .muted { color: #666; }
    .mb-4 { margin-bottom: 16px; }
    .mb-2 { margin-bottom: 8px; }
    .small { font-size: 9px; }
  </style>
</head>
<body>
  <div class="header">
    <table class="no-border">
      <tr class="no-border">
        <td class="no-border" style="width: 20%">
          <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 60px;">
        </td>
        <td class="no-border" style="width: 60%">
          <h2>PRESUPUESTO</h2>
          @if (!empty($presupuesto->model) && method_exists($presupuesto->model, 'numero_reporte'))
            <div class="center small muted">Reporte: {{ $presupuesto->model->numero_reporte }}</div>
          @endif
        </td>
        <td class="no-border right" style="width: 20%">
          <div class="small">Fecha: {{ $presupuesto->fecha_format }}</div>
        </td>
      </tr>
    </table>
  </div>

  @if (!empty($pago_danos) && $pago_danos)
    <div class="center" style="color: #c00; font-weight: bold; font-size: 14px; margin-bottom: 8px;">PAGO DE DAÑOS</div>
  @endif

  <table class="mb-4">
    <tr>
      <td class="no-border" style="width:50%"><strong>Cliente:</strong> {{ $presupuesto->cliente->nombre ?? '' }}</td>
      <td class="no-border right" style="width:50%"><strong>Vehículo:</strong> {{ $presupuesto->vehiculo }}</td>
    </tr>
  </table>

  <table>
    <thead>
      <tr>
        <th class="center" style="width: 10%">Clave</th>
        <th class="center" style="width: 10%">Cantidad</th>
        <th class="center" style="width: 40%">Descripción</th>
        <th class="center" style="width: 20%">Mano de Obra</th>
        <th class="center" style="width: 20%">Refacciones</th>
      </tr>
    </thead>
    <tbody>
      @php $conceptos = $presupuesto->conceptos ?? collect(); @endphp
      @foreach ($conceptos as $c)
        @php $nomen = explode('-', $c->nomenclatura)[0] ?? ''; @endphp
        <tr>
          <td class="center">{{ $nomen }}</td>
          <td class="center">{{ number_format($c->cantidad, 0) }}</td>
          <td>{{ $c->descripcion }}</td>
          <td class="right">${{ number_format($c->mano_obra, 2) }}</td>
          <td class="right">${{ number_format($c->refacciones, 2) }}</td>
        </tr>
      @endforeach
      @for ($i = $conceptos->count(); $i < max(20, $conceptos->count()); $i++)
        <tr>
          <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
        </tr>
      @endfor
    </tbody>
    <tfoot>
      <tr>
        <td class="no-border" colspan="3"></td>
        <td class="right"><strong>Total Mano de Obra</strong></td>
        <td class="right"><strong>${{ number_format($presupuesto->total_mano_obra, 2) }}</strong></td>
      </tr>
      <tr>
        <td class="no-border" colspan="3"></td>
        <td class="right"><strong>Total Refacciones</strong></td>
        <td class="right"><strong>${{ number_format($presupuesto->total_refacciones, 2) }}</strong></td>
      </tr>
    </tfoot>
  </table>

  <table class="mb-2">
    <tr>
      <td class="no-border right" style="width: 80%"><strong>SUB-TOTAL</strong></td>
      <td class="right" style="width: 20%">${{ number_format($presupuesto->subtotal, 2) }}</td>
    </tr>
    <tr>
      <td class="no-border right"><strong>IVA ({{ number_format(($presupuesto->tasa_iva ?? 0) * 100, 0) }}%)</strong></td>
      <td class="right">${{ number_format($presupuesto->iva, 2) }}</td>
    </tr>
    <tr>
      <td class="no-border right"><strong>TOTAL</strong></td>
      <td class="right"><strong>${{ number_format($presupuesto->total, 2) }}</strong></td>
    </tr>
  </table>

  <table>
    <tr>
      <td class="center" style="width:25%"><strong>MECÁNICA</strong><br>{{ $presupuesto->mecanica }}</td>
      <td class="center" style="width:25%"><strong>HOJALATERÍA</strong><br>{{ $presupuesto->hojalateria }}</td>
      <td class="center" style="width:25%"><strong>PINTURA</strong><br>{{ $presupuesto->pintura }}</td>
      <td class="center" style="width:25%"><strong>ARMADO</strong><br>{{ $presupuesto->armado }}</td>
    </tr>
  </table>

</body>
</html>


