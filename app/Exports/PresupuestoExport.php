<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class PresupuestoExport implements FromCollection, WithMapping, WithColumnFormatting, ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithDrawings, WithColumnWidths
{
    private $title = 'Presupuesto';

    public $presupuesto;

    public function __construct($presupuesto)
    {
        $this->presupuesto = $presupuesto;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('logo');
        $drawing->setPath(public_path('/images/logo.png'));
        $drawing->setHeight(80);
        $drawing->setCoordinates('C1');

        return $drawing;
    }

    public function collection()
    {
        return $this->presupuesto->conceptos;
    }

    public function startCell(): string
    {
        return 'A10';
    }

    public function columnWidths(): array
    {
        return [
          'A' => 6, // Clave
          'B' => 12, // Cantidad
          'C' => 5, // Descripcion
          'D' => 25,
          'E' => 5,
          'F' => 14, // Mano de Obra
          'G' => 14, // Refacciones
        ];
    }

    public function headings(): array
    {
        return [
            'Clave',
            'Cantidad',
            '', // Placeholder para alineación con las columnas combinadas
            '',
            '',
            'Mano de Obra',
            'Refacciones',
        ];
    }

    public function map($item): array
    {
        $nomenclatura = explode('-', $item->nomenclatura)[0] ?? '';
        return [
            $nomenclatura,
            $item->cantidad ?? '',
            $item->descripcion ?? '',
            '', // Columnas combinadas, no se usa en el mapeo
            '',
            $item->mano_obra ?? '',
            $item->refacciones ?? '',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'G' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $margin = 15; // RENGLONES DE LA HOJA DESPUES DE LA ULTIMA FILA
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $countConceptos = count($this->presupuesto->conceptos);
        if($countConceptos < 20){
            $highestRow += 20 - $countConceptos;
        }

        $lastDocRow = $highestRow + $margin;
        $sheet->getStyle("A1:{$highestColumn}{$lastDocRow}")->getFont()->setSize(8);

        $sheet->setCellValue('D5', "PRESUPUESTO");
        $sheet->getStyle("D5")->getFont()->setSize(11);
        $sheet->getStyle('D5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A5:G8")->getFont()->setBold(true);

        // Encabezado de cliente y datos
        $sheet->mergeCells('A6:C6');
        $sheet->setCellValue('A6', "Cliente: {$this->presupuesto->cliente->nombre}");
        $sheet->getStyle('A6')->getBorders()->getBottom()->setBorderStyle('thin');

        $sheet->mergeCells('E6:G6');
        $sheet->setCellValue('E6', "Reporte: {$this->presupuesto->model->numero_reporte}");
        $sheet->getStyle('E6')->getBorders()->getBottom()->setBorderStyle('thin');

        $sheet->mergeCells('A7:C7');
        $sheet->setCellValue('A7', "Teléfono: {$this->presupuesto->cliente->telefono}");
        $sheet->getStyle('A7')->getBorders()->getBottom()->setBorderStyle('thin');

        $sheet->mergeCells('E7:G7');
        $sheet->setCellValue('E7', "Vehículo: {$this->presupuesto->vehiculo}");
        $sheet->getStyle('E7')->getBorders()->getBottom()->setBorderStyle('thin');

        $sheet->mergeCells('A8:C8');
        $sheet->setCellValue('A8', "Fecha: {$this->presupuesto->fecha_creacion}");
        $sheet->getStyle('A8')->getBorders()->getBottom()->setBorderStyle('thin');


        // Bordes y estilos de la tabla
        $cellRange = "A10:{$highestColumn}{$highestRow}";
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('A10:G10')->getFont()->setBold(true);
        $sheet->getStyle("A11:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Ajuste para la columna de descripción (C, D, E combinadas)
        $sheet->mergeCells('C10:E10');
        $sheet->setCellValue('C10', 'Descripción');
        $sheet->getStyle('A10:G10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        //ULTIMA FILA TOTAL
        $totalRow = $highestRow + 1;
        $sheet->mergeCells("C{$totalRow}:E{$totalRow}");
        $sheet->setCellValue("C{$totalRow}", 'Total:');
        $sheet->getStyle("C{$totalRow}:E{$totalRow}")->getFont()->setBold(true);
        $sheet->getStyle("C{$totalRow}:E{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle("F{$totalRow}:G{$totalRow}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_INTEGER);
        //TOTAL MANO DE OBRA
        $sheet->setCellValue("F{$totalRow}", $this->presupuesto->total_mano_obra);
        $sheet->getStyle("F{$totalRow}")->getFont()->setBold(true);
        $sheet->getStyle("F{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        //TOTAL REFACCIONES
        $sheet->setCellValue("G{$totalRow}", $this->presupuesto->total_refacciones);
        $sheet->getStyle("G{$totalRow}")->getFont()->setBold(true); 
        $sheet->getStyle("G{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        //TABLA NOMENCLATURA
        $nomenclaturaRow  = $highestRow + 3;
        $nomenclaturaLastRow = $nomenclaturaRow + 6;
        $sheet->mergeCells("A{$nomenclaturaRow}:B{$nomenclaturaRow}");
        $sheet->getStyle("A{$nomenclaturaRow}:B{$nomenclaturaLastRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle("A{$nomenclaturaRow}:B{$nomenclaturaLastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$nomenclaturaRow}")->getFont()->setBold(true);
        $sheet->setCellValue("A{$nomenclaturaRow}", 'Nomenclatura');

        $claves = [
            'I' => 'Reparar',
            'E' => 'Reemplazo',
            'LE' => 'Pint. Reemplazo',
            'LI' => 'Pint. Reparación',
            'V' => 'Alineación',
            'N' => 'Desmontaje',
        ];

        //TABLA TOTAL
        $subtotalRow = $highestRow + 3;
        $ivaRow = $subtotalRow + 1;
        $totalRow = $ivaRow + 1;
        $sheet->setCellValue("F{$subtotalRow}", 'SUB-TOTAL');
        $sheet->setCellValue("G{$subtotalRow}", $this->presupuesto->subtotal);

        $sheet->setCellValue("F{$ivaRow}", 'IVA');
        $sheet->setCellValue("G{$ivaRow}", $this->presupuesto->iva);

        $sheet->setCellValue("F{$totalRow}", 'TOTAL');
        $sheet->setCellValue("G{$totalRow}", $this->presupuesto->total);
        $sheet->getStyle("F{$totalRow}:G{$totalRow}")->getFont()->setBold(true);
        $sheet->getStyle("G{$subtotalRow}:G{$totalRow}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD_INTEGER);
        $sheet->getStyle("F{$subtotalRow}:F{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        //TABLA DIAS
        $diasMecanica = $totalRow + 2;
        $diasHojalatariaRow = $diasMecanica + 1;
        $diasPinturaRow = $diasHojalatariaRow + 1;
        $diasArmadoRow = $diasPinturaRow + 1;
        $sheet->getStyle("F{$diasMecanica}:G{$diasArmadoRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("F{$diasMecanica}:G{$diasArmadoRow}")->getBorders()->getAllBorders()->setBorderStyle('thin');

        $sheet->setCellValue("F{$diasMecanica}", 'MECÁNICA');
        $sheet->setCellValue("G{$diasMecanica}", $this->presupuesto->mecanica);

        $sheet->setCellValue("F{$diasHojalatariaRow}", 'HOJALATERÍA');
        $sheet->setCellValue("G{$diasHojalatariaRow}", $this->presupuesto->hojalateria);

        $sheet->setCellValue("F{$diasPinturaRow}", 'PINTURA');
        $sheet->setCellValue("G{$diasPinturaRow}", $this->presupuesto->pintura);

        $sheet->setCellValue("F{$diasArmadoRow}", 'ARMADO');
        $sheet->setCellValue("G{$diasArmadoRow}", $this->presupuesto->armado);

        // LEYENDA FOOTER
        $footerNameRow = $diasArmadoRow + 2;
        $footerCalleRow = $footerNameRow + 1;
        $footerColoniaRow = $footerCalleRow + 1;
        $footerTelefonoRow = $footerCalleRow + 1;

        $leyendaRange = "A{$footerNameRow}:D{$footerTelefonoRow}";
        $sheet->mergeCells($leyendaRange);
        $sheet->setCellValue("A{$footerNameRow}", 'PROFESIONALES AL SERVICIO DE SU AUTOMÓVIL');

        $sheet->mergeCells("E{$footerNameRow}:G{$footerNameRow}");
        $sheet->mergeCells("E{$footerCalleRow}:G{$footerCalleRow}");
        $sheet->mergeCells("E{$footerColoniaRow}:G{$footerColoniaRow}");
        $sheet->mergeCells("E{$footerTelefonoRow}:G{$footerTelefonoRow}");

        $sheet->setCellValue("E{$footerNameRow}", 'ING. GUILLERMO VILLANUEVA GUTIERREZ');
        $sheet->setCellValue("E{$footerCalleRow}", 'AV. VALLE DE JUÁREZ #6591');
        $sheet->setCellValue("E{$footerColoniaRow}", 'COL. SAN LORENZO CP. 32320');
        $sheet->setCellValue("E{$footerTelefonoRow}", 'TEL 311.5245 / 381.7465 CD. JUÁREZ, CHIH.');

        $colorFooter = new Color('808080');
        $sheet->getStyle("A{$footerNameRow}:G{$footerTelefonoRow}")->getFont()->setColor($colorFooter);
        $sheet->getStyle("A{$footerNameRow}:G{$footerTelefonoRow}")->getFont()->setItalic(true);
        $sheet->getStyle("A{$footerNameRow}:G{$footerTelefonoRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$footerNameRow}:G{$footerTelefonoRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        
        $sheet->getStyle("A{$footerNameRow}:D{$footerTelefonoRow}")->getFont()->setSize(11);
        $sheet->getStyle("E{$footerNameRow}:G{$footerTelefonoRow}")->getFont()->setSize(8);
        

        //TABLA NOMENCLATURA
        foreach ($claves as $clave => $descripcion) {
            $nomenclaturaRow++;
            $sheet->setCellValue("A{$nomenclaturaRow}", $clave);
            $sheet->setCellValue("B{$nomenclaturaRow}", $descripcion);
            $sheet->getStyle("A{$nomenclaturaRow}")->getFont()->setBold(true);
        }

        // Merge en descripción para los datos
        $countConceptosFinal = $countConceptos < 20 ? 20 : $countConceptos;
        // foreach ($this->presupuesto->conceptos as $index => $concepto) {
        for ($index = 0; $index < $countConceptosFinal; $index++) {
            $row = $index + 11; // La tabla empieza en la fila 10 con encabezados
            $concepto = $this->presupuesto->conceptos->get($index);
            $sheet->mergeCells("C{$row}:E{$row}");
            $sheet->setCellValue("C{$row}", $concepto->descripcion ?? '');
            $sheet->getStyle("C{$row}")->getAlignment()->setWrapText(true);
            $sheet->getStyle("A{$row}:G{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
        

    }


}
