<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SolarType;

class SolarType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SolarType::insert(
            [
                [
                    'state_code'        => 'NSW',
                ],
                [
                    'state_code'        => 'ACT',
                ],
                [
                    'state_code'        => 'NT',
                ],
                [
                    'state_code'        => 'QLD',
                ],
                [
                    'state_code'        => 'SA',
                ],
                [
                    'state_code'        => 'TAS',
                ],
                [
                    'state_code'        => 'VIC',
                ],
                [
                    'state_code'        => 'WA',
                ],
           
            ]
        );
    }
}
