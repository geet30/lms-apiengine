<?php

namespace App\Exports;
use App\Models\Plans\{   
    EnergyMasterTariff
};

use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ExportMasterTariffId implements WithTitle,FromCollection,WithHeadings,WithStyles,WithColumnWidths
{
    public $row;
    public function __construct()
    {
        $this->row = 1;
    }

    public function headings() :array
    {
        return array(
            'Demand Tariff name', 
            'Demandd tariff distributor name', 
            'Demand tariff Units Type', 
            'Demand tariff ID', 
            'Property Type'
        );
    }
    public function collection()
    {
        $demandTariffCodes = EnergyMasterTariff::with('distributor')->whereNotNull('distributor_id')->get();
        
        $masterTariffs = [];  
        foreach ($demandTariffCodes as $demandTariffCode) {
            $propertyType = 'Residential';
            $unitType = 'kWh';
            if ($demandTariffCode->property_type == 1) {
                $propertyType = 'Business';
            }
            if ($demandTariffCode->units_type == 1) {
                $unitType = 'KVA';
            }
            $masterTariffs[] = array(
                $demandTariffCode->tariff_code,
                isset($demandTariffCode->distributor->name)? $demandTariffCode->distributor->name:'',
                $unitType,
                $demandTariffCode->id,
                $propertyType,
            ); 
            $this->row++;
        }   
        return collect($masterTariffs);
    } 

    public function title(): string
    {
        return 'Master Tariff Id';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('D1:D'.$this->row)->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffff00'],]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 32,
            'B' => 32,
            'C' => 32,
            'D' => 32,
            'E' => 32,
            'F' => 32,            
        ];
    }
}
