<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class indentificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indentficationArr =  DB::table('master_identification_details')->insert([
            [
                'id' => '1',
                'options' => 'Medicare Card',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => '2',
                'options' => 'Foreign Passport',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],  [
                'id' => '3',
                'options' => 'Drivers Licence',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],  [
                'id' => '4',
                'options' => 'Australian Passport',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);

        if ($indentficationArr) {
            echo "\n Identification Details added successfully\n";
        } else {
            echo "\n Unable to add Identification Details\n";
        }
    }
}
