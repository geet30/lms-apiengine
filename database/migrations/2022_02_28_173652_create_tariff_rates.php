<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tariff_info_ref_id');
            $table->foreign('tariff_info_ref_id')->references('id')->on('tariff_infos')->onDelete('cascade');
            $table->string('season_rate_type');
            $table->string('usage_type');
            $table->integer('limit_level');
            $table->float('limit_charges');
            $table->float('limit_daily')->nullable();
            $table->float('limit_yearly')->nullable();
            $table->string('usage_discription')->nullable();
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
        Schema::dropIfExists('tariff_rates');
    }
}
