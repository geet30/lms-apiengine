<?php

namespace App\Imports;

use App\Exceptions\CustomException;
use App\Models\DistributorPostCode;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DistributorPostCodesImport implements  ToModel, WithStartRow
{
    private $distributor_id;

    public function __construct(string $distributor_id)
    {
        $this->distributor_id = $distributor_id;
    }

    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if (!isset($row[1])) {
            throw new CustomException('Post code is required at row: '.$row[1]);
        }
        if (!is_numeric($row[1])) {
            throw new CustomException('Post code must be a number at row: '.$row[1]);
        }
        if (Str::length($row[1]) != 4) {
            throw new CustomException('Post code must be of 4 digits at row: '.$row[1]);
        }
        DistributorPostCode::where('distributor_id', $this->distributor_id)->delete();
        return new DistributorPostCode([
           'distributor_id' =>  $this->distributor_id,
           'post_code' => $row[1],
           'created_at' => now(),
           'updated_at' => now(),
        ]);
    }
}
