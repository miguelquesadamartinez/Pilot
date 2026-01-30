<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class DsmOrdersExport implements FromCollection, WithHeadings
{
    protected $orders;

    // Constructor para pasar los datos de la consulta
    public function __construct(Collection $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Return a collection for Excel export
     */
    public function collection()
    {
        return $this->orders;
    }
    public function headings(): array
    {
        return [
            'ID',                // Ejemplo de nombre de columna
            'Reference',         // Ejemplo de nombre de columna
            'Laboratory Name',
            'Status',
            'Updated At',
        ];
    }
}
