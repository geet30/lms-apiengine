<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyContentAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_content_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->comment('1 plan 2 master'); 
            $table->integer('service_id');
            $table->string('attribute');
            $table->timestamps();
        });

        DB::table('energy_content_attributes')->insert([
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Affiliate-Name@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Provider-Name@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Provider-Phone-Number@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Provider-Address@',
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'type' => 1,
                'service_id' => 1,
                'attribute' => '@Affiliate-Email@',
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
        Schema::dropIfExists('energy_content_attributes');
    }
}
