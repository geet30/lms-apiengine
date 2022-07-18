<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('state_id');
            $table->string('state', 99);
            $table->string('state_code', 99);
            $table->integer('country');
            $table->tinyInteger('status')->default(1)->comment('1 Enable 2  Disable');
            $table->timestamps();
        });

        DB::table('states')->insert([
            [
                'state' => 'Australian Capital Territory',
                'state_code' => 'ACT',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'New South Wales',
                'state_code' => 'NSW',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'Northern Territory',
                'state_code' => 'NT',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'Queensland',
                'state_code' => 'QLD',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'South Australia',
                'state_code' => 'SA',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'Tasmania',
                'state_code' => 'TAS',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'Victoria',
                'state_code' => 'VIC',
                'country' => 1,
                'created_at' => date("Y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("Y-m-d H:i:s", strtotime('now')),
            ],
            [
                'state' => 'Western Australia',
                'state_code' => 'WA',
                'country' => 1,
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
        Schema::dropIfExists('states');
    }
}
