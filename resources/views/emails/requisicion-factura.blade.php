<div style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #111">
  <h2 style="margin-bottom: 0;">Nueva Requisición de Factura</h2>
  <p style="margin-top: 4px;">Se ha creado una nueva requisición de factura en el sistema.</p>

  <table style="border-collapse: collapse; width: 100%; max-width: 640px;">
    <tr>
      <td style="padding: 6px 8px; font-weight: bold; width: 200px;">ID</td>
      <td style="padding: 6px 8px;">{{ $requisicion->id }}</td>
    </tr>
    <tr>
      <td style="padding: 6px 8px; font-weight: bold;">Cliente</td>
      <td style="padding: 6px 8px;">{{ $requisicion->cliente?->nombre ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td style="padding: 6px 8px; font-weight: bold;">Monto</td>
      <td style="padding: 6px 8px;">${{ number_format($requisicion->monto ?? 0, 2) }}</td>
    </tr>
    <tr>
      <td style="padding: 6px 8px; font-weight: bold;">Forma de pago</td>
      <td style="padding: 6px 8px;">{{ $requisicion->forma_pago ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td style="padding: 6px 8px; font-weight: bold;">Uso CFDI</td>
      <td style="padding: 6px 8px;">{{ $requisicion->uso_cfdi ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td style="padding: 6px 8px; font-weight: bold;">Descripción</td>
      <td style="padding: 6px 8px;">{{ $requisicion->descripcion ?? 'N/A' }}</td>
    </tr>
    <tr>
      <td style="padding: 6px 8px; font-weight: bold;">Aseguradora</td>
      <td style="padding: 6px 8px;">{{ $requisicion->aseguradora ?? 'N/A' }}</td>
    </tr>
  </table>

  <p style="margin-top: 12px; color: #666;">Este mensaje fue generado automáticamente.</p>
</div> 