<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tariff_code_ref_id');
            $table->foreign('tariff_code_ref_id')->references('id')->on('master_tariffs')->onDelete('cascade');
            $table->string('tariff_code_aliases')->nullable();
            $table->float('tariff_discount')->nullable();
            $table->float('tariff_daily_supply')->nullable();
            $table->float('tariff_supply_discount')->nullable();
            $table->string('daily_supply_charges_description')->nullable();
            $table->string('discount_on_usage_description')->nullable();
            $table->string('discount_on_supply_description')->nullable();
            $table->unsignedBigInteger('plan_rate_ref_id');
            $table->foreign('plan_rate_ref_id')->references('id')->on('energy_plan_rates')->onDelete('cascade');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('tariff_info');
    }
}
