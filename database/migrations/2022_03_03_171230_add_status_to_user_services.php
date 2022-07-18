<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToUserServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_services', function (Blueprint $table) {
            $table->tinyInteger('status')->after('user_type')->default(1)->comment('1: enable, 2:disable');
            $table->tinyInteger('assigned_by')->after('status');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_services', function (Blueprint $table) {
            //
        });
    }
}
