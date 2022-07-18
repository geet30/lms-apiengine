<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansBroadbandFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_broadband_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans_broadbands')->onDelete('cascade');
            $table->integer('fee_id')->nullable();
            $table->integer('cost_type_id')->nullable();
            $table->integer('fees')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans_broadband_fees');
    }
}
