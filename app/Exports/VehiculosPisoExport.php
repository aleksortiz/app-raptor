<?php

namespace App\Exports;

use App\Models\Entrada;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class VehiculosPisoExport implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings, WithStyles, WithCustomStartCell, WithDrawings, WithColumnWidths
{
    private $title = 'Vehiculos en Piso';

    public $presupuesto;

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
        $vehiculos = Entrada::where('fecha_entrega', null)->get();

        return $vehiculos;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function columnWidths(): array
    {
        return [
          'A' => 13, // INGRESO
          'B' => 5, // FOLIO
          'C' => 5, // ORIGEN
          'D' => 10, // No. Reporte
          'E' => 20, // VEHICULO
          'F' => 25, // Notas
        ];
    }

    public function headings(): array
    {
        return [
            'Ingreso',
            'Folio',
            'Origen',
            'No. Reporte',
            'Vehículo',
            'Notas',
        ];
    }

    public function map($item): array
    {
        return [
            $item->fecha_creacion ?? '',
            $item->folio_short ?? '',
            $item->origen_short ?? '',
            $item->orden ?? 'N/A',
            $item->vehiculo ?? '',
            ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        // Bordes y estilos de la tabla
        $cellRange = "A5:{$highestColumn}{$highestRow}";
        //font size
        $sheet->getStyle($cellRange)->getFont()->setSize(8);
        // all rows height
        for ($row = 5; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle('thin');
        $sheet->getStyle('A5:F5')->getFont()->setBold(true);

    }


}
