<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConnectionTypeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::table('connection_types')->insert([
        //     [
        //         'id' => 1,
        //         'service_id' => 3,
        //         'name' => 'NBN',
        //         'status' => 1,
        //         'is_deleted' => 0
        //     ],
        //     [
        //         'id' => 2,
        //         'service_id' => 3,
        //         'name' => 'ADSL',
        //         'status' => 1,
        //         'is_deleted' => 0
        //     ],
        //     [
        //         'id' => 3,
        //         'service_id' => 3,
        //         'name' => 'CABLE',
        //         'status' => 1,
        //         'is_deleted' => 0
        //     ],
        //     [
        //         'id' => 4,
        //         'service_id' => 3,
        //         'name' => '4G',
        //         'status' => 1,
        //         'is_deleted' => 0
        //     ],
        //     [
        //         'id' => 5,
        //         'service_id' => 3,
        //         'name' => '5G',
        //         'status' => 1,
        //         'is_deleted' => 0
        //     ],
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('connection_types')->whereIn('id',[1,2,3,4,5])->delete();
    }
}
