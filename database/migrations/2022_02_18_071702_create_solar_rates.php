<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolarRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solar_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('plans_energy')->onDelete('cascade');
            $table->float('solar_price');
            $table->text('solar_description');
            $table->tinyInteger('is_show_frontend');
            $table->tinyInteger('status');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('solar_rates');
    }
}
