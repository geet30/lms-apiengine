<?php

namespace App\Imports;

use App\Exceptions\CustomException;
use App\Models\DmoVdo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DmoVdoPriceImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $distributor = self::getDistributor($row[0]);
        $tariff_type = self::getTariffType($row[1]);
        $offer_type = self::getOfferType($row[3]);
        $property_type = self::getPropertyType($row[4]);

        if (!isset($distributor)) {
            throw new CustomException('Distributor not found: '.$row[0]);
        }

        if (!isset($tariff_type)) {
            throw new CustomException('Tariff type not found: '.$row[1]);
        }

        if (!isset($offer_type)) {
            throw new CustomException('Incorrect offer type: '.$row[3]);
        }

        if (!isset($property_type)) {
            throw new CustomException('Incorrect property type: '.$row[4]);
        }

        return new DmoVdo([
            'distributor_id' => $distributor->id,
            'tariff_type' => $tariff_type->id,
            'tariff_name' => $row[2],
            'offer_type' => $offer_type,
            'property_type' => $property_type,
            'annual_price' => $row[5],
            'annual_usage' => $row[6],
            'peak_only' => $row[7],
            'peak_offpeak_peak' => $row[8],
            'peak_offpeak_offpeak' => $row[9],
            'peak_shoulder_peak' => $row[10],
            'peak_shoulder_offpeak' => $row[11],
            'peak_shoulder_shoulder' => $row[12],
            'peak_shoulder_1_2_peak' => $row[13],
            'peak_shoulder_1_2_offpeak' => $row[14],
            'peak_shoulder_1_2_shoulder_1' => $row[15],
            'peak_shoulder_1_2_shoulder_2' => $row[16],
            'control_load_1' => $row[17],
            'control_load_2' => $row[18],
            'control_load_1_2_1' => $row[19],
            'control_load_1_2_2' => $row[20],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private static function getDistributor($name)
    {
        return DB::table('distributors')->where('name', $name)->first('id');
    }

    private static function getTariffType($type)
    {
        return DB::table('tariff_types')->where('tariff_types', $type)->first('id');
    }

    private static function getOfferType($offer)
    {
        if ($offer === 'DMO') {
            return 1;
        }

        if ($offer === 'VDO') {
            return 2;
        }

        return null;
    }

    private static function getPropertyType($type)
    {
        if ($type === 'Residential') {
            return 1;
        }

        if ($type === 'Business') {
            return 2;
        }

        return null;
    }
}
