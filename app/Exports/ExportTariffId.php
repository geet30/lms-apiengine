<?php

namespace App\Exports;
 
use App\Models\Plans\{  
    EnergyPlanRate, 
};
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ExportTariffId implements WithTitle,FromCollection,WithHeadings,WithStyles,WithColumnWidths
{
    public $row;
    public function __construct()
    {
        $this->row = 1;
    }
    public function headings() :array
    {
        return array(
            'Provider Name', 
            'Provider ID', 
            'Plan name', 
            'Plan ID', 
            'Tariff Name', 
            'Tariff distributor name', 
            'Tariff Type Title', 
            'Tariff Type code', 
            'Tariff ID'
        );
    }
    public function collection()
    {

        $records= EnergyPlanRate::with([
            'energyPlan' => function ($query) {
                $query->select('id', 'name');
            },
            'provider' => function ($query) {
                $query->select('id', 'name','user_id');
            },
            'distributors'
        ])
        ->select('type','distributor_id','tariff_type_title','tariff_type_code','id','plan_id','provider_id')
        ->get();    
        
        $providers = [];
        foreach ($records as $record) {
            if (isset($record->energyPlan) && isset($record->provider)) { 
                    $providers[] = array(
                        $record->provider->name,
                        $record->provider->user_id,
                        decryptGdprData($record->energyPlan->name),
                        $record->energyPlan->id,
                        $record->type,
                        isset($record->distributors->name)?$record->distributors->name: 'N/A',
                        $record->tariff_type_title,
                        $record->tariff_type_code,
                        decryptGdprData($record->id),
                    ); 
                    $this->row++;
            }
        }   
        return collect($providers);
    } 

    public function title(): string
    {
        return 'Tariff Id';
    }

     
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('I1:I'.$this->row)->getFill()->applyFromArray(['fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'ffff00'],]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 25,
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 25,
            'I' => 25,            
        ];
    }
}
