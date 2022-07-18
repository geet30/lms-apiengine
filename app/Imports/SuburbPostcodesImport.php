<?php

namespace App\Imports;

use App\Exceptions\CustomException;
use App\Models\Postcode;
use App\Models\States;
use App\Models\UserSuburb;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use function PHPUnit\Framework\isNull;

class SuburbPostcodesImport implements ToModel, WithStartRow
{
    private $user_id;

    public function __construct(string $user_id)
    {
        $this->user_id = $user_id;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $state = self::getState($row[3]);
        $suburb_id = Postcode::insertGetId([
            'postcode' => $row[1],
            'suburb' => $row[2],
            'state' => $row[3],
        ]);
        UserSuburb::insert([
            'user_id' => $this->user_id,
            'state_id' => $state->id,
            'suburb_id' => $suburb_id,
            'status' => $row[4],
        ]);
    }

    private static function getState($state_code)
    {
        $state = States::select('state_id as id')->where('state_code', strtoupper(trim($state_code)))->first();

        if (!isset($state)) {
            throw new CustomException('State not found "'.$state_code.'". Please check your sheet');
        }

        return $state;
    }
}
