<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEnergyContentAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('energy_content_attributes')->truncate();

        DB::table('energy_content_attributes')->insert([
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@% Difference Without Conditional Discount@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@% Difference With Conditional Discount@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Lowest Possible Annual Cost@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Property Type@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Total Consumption@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Tariff Type@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Distributor@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Plan Name@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Provider Name@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Less/More@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@% Difference Without Conditional Discount@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@% Difference With Conditional Discount@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Lowest Possible Annual Cost@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Property Type@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Total Consumption@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Tariff Type@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Distributor@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Plan Name@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Provider Name@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 2,
                'service_id' => 1,
                'attribute' => '@Less/More@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
