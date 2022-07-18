<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansBroadbandTechnologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans_broadband_technologies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->foreign('plan_id')->references('id')->on('plans_broadbands')->onDelete('cascade');
            $table->integer('connection_id')->nullable();
            $table->integer('technology_id');
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
        Schema::dropIfExists('plans_broadband_technologies');
    }
}
