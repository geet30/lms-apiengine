<?php

namespace App\Imports;

use App\Models\MasterTariffCode;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MasterTariffCodesImport implements ToModel, WithStartRow
{
    private $method;

    public function __construct(string $method)
    {
        $this->method = $method;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $distributor = self::getDistributor($row[3]);
        $property_type = self::getPropertyType($row[2]);
        if (!isset($distributor)) {
            throw new CustomException('Distributor not found: '.$row[0]);
        }
        if (!isset($property_type)) {
            throw new CustomException('Incorrect property type: '.$row[4]);
        }

        if ($this->method == 'replace_all') {
            // todo
        }

        if ($this->method == 'replace_existing') {
            // todo
        }

        return new MasterTariffCode([
            'distributor_id' => $distributor->id,
            'property_type' => $property_type,
            'tariff_type' => $row[1],
            'tariff_code' => $row[0],
            'master_tariff_ref_id' => 1,
            'units_type' => $row[4],
            'status' => $row[5],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private static function getDistributor($distributor_id)
    {
        return DB::table('distributors')->whereId($distributor_id)->first('id');
    }

    private static function getPropertyType($type)
    {
        if ($type === 1 || $type === 2) {
            return $type;
        }
        return null;
    }
}
