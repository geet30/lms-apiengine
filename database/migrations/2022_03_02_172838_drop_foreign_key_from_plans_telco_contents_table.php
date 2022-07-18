<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyFromPlansTelcoContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans_telco_contents', function (Blueprint $table) {
            $table->dropForeign('plans_telco_contents_plan_id_foreign');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans_telco_contents', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('plans_broadbands')->onDelete('cascade');
        });
    }
}
