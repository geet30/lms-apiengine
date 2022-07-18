<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\{ExportTariffId,ExportMasterTariffId};
class ExportMasterTariff implements WithMultipleSheets
{
    use Exportable;
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ExportTariffId();
        $sheets[] = new ExportMasterTariffId();
        return $sheets;
    }
}
