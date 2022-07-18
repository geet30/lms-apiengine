<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LifeSupportEquipment;

class LifeSupportData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LifeSupportEquipment::insert(
            [
                [
                'title'        => 'Other',
                'status'         => 1
            ],
            [
                'title'        => 'Total Parental Nutrition',
                'status'         => 1
            ],
            [
                'title'        => 'Oxygen Concentrator',
                'status'         => 1
            ],
            [
                'title'        => 'Phototherapy',
                'status'         => 1
            ],
            [
                'title'        => 'Ventilators',
                'status'         => 1
            ],
            [
                'title'        => 'Respirator',
                'status'         => 1
            ],
            [
                'title'        => 'PAP Device',
                'status'         => 1
            ],
            [
                'title'        => 'Enternal Feeding Pump',
                'status'         => 1
            ],
            [
                'title'        => 'Home Dialysis',
                'status'         => 1
            ],
            [
                'title'        => 'External Heart Pump',
                'status'         => 1
            ],
            [
                'title'        => 'Power Wheelchairs for Quadriplegics',
                'status'         => 1
            ],
            [
                'title'        => 'Intermittent Peritoneal Dialysis Machine',
                'status'         => 1
            ],
            [
                'title'        => 'Chronic Positive Airways Pressure Respirator',
                'status'         => 1
            ],
            ]
        );
    }
}
